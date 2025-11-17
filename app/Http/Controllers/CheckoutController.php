<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Quote_item;
use Illuminate\Support\Facades\Auth;
use App\Models\Order_address;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Support\Facades\Log;
use App\Models\Attributevalue;
use App\Models\AttributeCombination;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;

class CheckoutController extends Controller
{
    public function index($lang)
    {
        app()->setLocale($lang);
        $langCode = session('language_code', 'en');

        $quote = null;

        if (Auth::check()) {
            $quote = Quote::where('user_id', Auth::id())->with('quoteItems')->first();
        } else {
            $cartId = session('cart_id');
            $quote = Quote::where('cart_id', $cartId)->with('quoteItems')->first();
        }

        return view('checkout', compact('quote'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'address_2' => 'nullable|string|max:500',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required|string|max:10',
            'payment_method' => 'required|in:stripe,cod',
            'sameBillingShipping' => 'nullable|boolean',
            'save_info' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $user = Auth::user();
        $cartId = session('cart_id');

        if ($user) {
            $cart = Quote::where('user_id', $user->id)->with('quoteItems')->first();
        } else {
            $cart = Quote::where('cart_id', $cartId)->with('quoteItems')->first();
        }
        if (!$cart || $cart->quoteItems->isEmpty()) {
            return redirect()->back()->with('message', 'Your cart is empty.');
        }

        $lastOrder = Order::orderBy('id', 'desc')->first();
        $orderIncrementId = $lastOrder ? $lastOrder->order_increment_id + 1 : 1000;

        $orderdata = [
            'order_increment_id' => $orderIncrementId,
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'address_2' => $request->address_2 ?? '',
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pin_code,
            'coupon' => $cart->coupon ?? '',
            'coupon_discount' => $cart->coupon_discount ?? '',
            'subtotal' => $cart->subtotal ?? 0,
            'total' => $cart->total ?? 0,
        ];

        $order = Order::create($orderdata);
        // dd($order);

        $cart->update([
            'subtotal' => 0,
            'total' => 0,
        ]);

        if ($request->sameBillingShipping == 1) {
            if (!$request->name || !$request->address) {
                dd('Billing info missing:', $request->all());
            }

            Order_address::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'address_2' => $request->address_2 ?? '',
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->pin_code,
                'address_type' => 'Shipping Address',
            ]);
        }


        foreach ($cart->quoteItems as $cartItem) {
            Order_item::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->name,
                'sku' => $cartItem->sku,
                'price' => $cartItem->price,
                'qty' => $cartItem->qty,
                'row_total' => $cartItem->row_total,
                'custom_option' => $cartItem->custom_option,
            ]);

            if (!empty($cartItem->custom_option)) {
                $options = explode(',', $cartItem->custom_option); // Example: "Color:White,Size:M"

                foreach ($options as $option) {
                    $pair = explode(':', $option);

                    if (count($pair) == 2) {
                        $value = trim($pair[1]);

                        // Step 1: Find the attribute value by value and product_id
                        $attributeValue = Attributevalue::where('value', $value)
                            ->where('product_id', $cartItem->product_id)
                            ->first();

                        if ($attributeValue) {
                            // Step 2: Get combination by product_id and attribute_value_id
                            $combination = AttributeCombination::where('product_id', $cartItem->product_id)
                                ->where('attribute_value_ids', $attributeValue->id)
                                ->first();

                            if ($combination) {
                                // Step 3: Safely reduce the stock
                                $combination->stock = max($combination->stock - $cartItem->qty, 0);
                                $combination->save();
                            } else {
                                Log::warning('Combination not found: product_id = ' . $cartItem->product_id . ', attribute_value_ids = ' . $attributeValue->id);
                            }
                        } else {
                            Log::warning('Attribute value not found for value = ' . $value);
                        }
                    }
                }
            }
            // Reset coupon after order
            $cart->update([
                'coupon' => null,
                'coupon_discount' => 0,
            ]);

            session()->forget('coupon_code');
            session()->forget('coupon_discount');


            $cartItem->delete();
        }
        $orderItems = Order_item::where('order_id', $order->id)->get();

        Mail::to('dineshkumarbangrwa55@gmail.com')->send(new MyEmail($user, $order, $orderItems));
        // dd($user);
        $langCode = session('language_code', app()->getLocale());
        return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'Order placed successfully.');
    }
}
