<?php

namespace App\Http\Controllers;

use App\Models\AttributeCombination;
use App\Models\AttributeValue;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Quote_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $quote = null;

        if (Auth::check()) {
            $quote = Quote::where('user_id', Auth::id())->with('quoteItems')->first();
        } else {
            $cartId = session('cart_id');
            $quote = Quote::where('cart_id', $cartId)->with('quoteItems')->first();
        }

        if ($quote) {
            foreach ($quote->quoteItems as $item) {
                $product = Product::find($item->product_id);

                $latestPrice = $product->price;

                if ($item->custom_option) {
                    $combination = AttributeCombination::where('product_id', $product->id)
                        ->get()
                        ->first(function ($combo) use ($item) {
                            $valueIds = is_array($combo->attribute_value_ids)
                                ? $combo->attribute_value_ids
                                : explode(',', $combo->attribute_value_ids);

                            $attributeValues = AttributeValue::whereIn('id', $valueIds)->with('attribute')->get();

                            $pairs = [];
                            foreach ($attributeValues as $value) {
                                $pairs[] = $value->attribute->name.': '.$value->value;
                            }

                            $option = implode(', ', $pairs);

                            return $option === $item->custom_option;
                        });

                    if ($combination) {
                        $latestPrice = $combination->price;
                    }
                }

                if ($item->price != $latestPrice) {
                    $item->price = $latestPrice;
                    $item->row_total = $latestPrice * $item->qty;
                    $item->save();
                }
            }

            // Recalculate quote total
            $subtotal = $quote->quoteItems->sum('row_total');
            $quote->subtotal = $subtotal;
            $quote->total = $subtotal - ($quote->coupon_discount ?? 0);
            $quote->save();
        }

        return view('cart', compact('quote'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'combination_id' => 'nullable|exists:attribute_combinations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($data['product_id']);
        $quantity = $data['quantity'];
        $custom_option = null;

        if ($data['combination_id']) {
            $combination = AttributeCombination::where('id', $data['combination_id'])
                ->where('product_id', $data['product_id'])
                ->firstOrFail();

            $valueIds = is_array($combination->attribute_value_ids) ?
                $combination->attribute_value_ids : explode(',', $combination->attribute_value_ids);
            $attributeValues = AttributeValue::whereIn('id', $valueIds)->with('attribute')->get();

            $pairs = [];
            foreach ($attributeValues as $value) {
                $pairs[] = $value->attribute->name.': '.$value->value;
            }
            $custom_option = implode(', ', $pairs);

            if ($combination->stock < $quantity) {
                return redirect()->back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.']);
            }
            $combination->stock -= $quantity;
            $combination->save();
        }

        if ($user) {
            $quote = Quote::firstOrCreate(
                ['user_id' => $user->id],
                ['cart_id' => Str::random(20)]
            );
            session(['quote_id' => $quote->id]);
        } else {
            $cartId = session('cart_id') ?? Str::random(20);
            session(['cart_id' => $cartId]);

            $quote = Quote::firstOrCreate(
                ['cart_id' => $cartId],
                ['user_id' => null]
            );
            session(['quote_id' => $quote->id]);
        }

        $price = $data['combination_id'] ? $combination->price : $product->price;

        $existingItem = Quote_item::where('product_id', $product->id)
            ->where('quote_id', $quote->id)
            ->where('custom_option', $custom_option)
            ->first();

        if ($existingItem) {
            $existingItem->qty += $quantity;
            $existingItem->row_total = $existingItem->qty * $existingItem->price;
            $existingItem->save();
        } else {
            Quote_item::create([
                'quote_id' => $quote->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'qty' => $quantity,
                'row_total' => $quantity * $price,
                'custom_option' => $custom_option,
            ]);
        }

        $subtotal = Quote_item::where('quote_id', $quote->id)->sum('row_total');
        $quote->update([
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    public function remove($id)
    {
        $item = Quote_item::findOrFail($id);
        $quote = $item->quote;

        $item->delete();

        $remainingItems = $quote->quoteItems()->count();

        if ($remainingItems === 0) {
            $quote->update([
                'subtotal' => 0,
                'total' => 0,
                'coupon' => null,
                'coupon_discount' => 0,
            ]);
        } else {
            $subtotal = $quote->quoteItems->sum(function ($i) {
                return $i->qty * $i->price;
            });

            $total = $subtotal;

            if ($quote->coupon_discount) {
                $total -= $quote->coupon_discount;
            }

            $quote->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        }

        return redirect()->back()->with('message', 'Item removed successfully');
    }

    public function coupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string',
            'quote_id' => 'required|exists:quotes,id',
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon)->first();

        if (! $coupon || $coupon->status != 1) {
            return redirect()->back()->with('error', 'Invalid or inactive coupon.');
        }

        $now = now();
        if (! $now->between($coupon->valid_from, $coupon->valid_to)) {
            return redirect()->back()->with('error', 'Coupon is not valid right now.');
        }

        $quote = Quote::find($request->quote_id);
        if (! $quote) {
            return redirect()->back()->with('warning', 'Cart not found.');
        }

        if ($quote->coupon === $coupon->coupon_code) {
            return redirect()->back()->with('message', 'Coupon already applied.');
        }

        if ($quote->subtotal >= $coupon->coupon_discount) {
            $quote->update([
                'total' => $quote->subtotal - $coupon->coupon_discount,
                'coupon' => $coupon->coupon_code,
                'coupon_discount' => $coupon->coupon_discount,
            ]);

            return redirect()->back()->with('message', 'Coupon applied successfully!');
        }

        return redirect()->back()->with('warning', 'Coupon discount exceeds subtotal.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cartId = session('cart_id');

        $quote = Quote::where('user_id', optional($user)->id)
            ->orWhere('cart_id', $cartId)
            ->first();

        if (! $quote) {
            return response()->json(['success' => false, 'error' => 'Cart not found.']);
        }

        $item = Quote_item::where('id', $id)->where('quote_id', $quote->id)->first();

        if (! $item) {
            return response()->json(['success' => false, 'error' => 'Item not found in cart.']);
        }

        $item->qty = $request->quantity;
        $item->row_total = $request->quantity * $item->price;
        $item->save();

        $subtotal = Quote_item::where('quote_id', $quote->id)->sum('row_total');
        $quote->update([
            'subtotal' => $subtotal,
            'total' => max($subtotal - ($quote->coupon_discount ?? 0), 0),
        ]);

        return response()->json([
            'success' => true,
            'updated_total' => number_format($item->row_total, 2),
        ]);
    }
}
