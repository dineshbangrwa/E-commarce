<?php

namespace App\Http\Controllers;

use App\Mail\MyEmail;
use App\Models\Order;
use App\Models\Order_address;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BuyController extends Controller
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

        return view('checkout', compact('quote'));
    }

    public function buystore(Request $request)
    {

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

        $product = Product::findOrFail($request->product_id);

        $discount = 0;
        if ($request->coupon_code && $request->coupon_code == 'DISCOUNT10') {
            $discount = 0.10 * $product->price;
            session([
                'coupon_name' => $request->coupon_code,
                'coupon_discount' => $discount,
            ]);
        }

        $total = $product->price - $discount;

        $orderIncrementId = Order::max('order_increment_id') + 1 ?? 1000;

        $order = Order::create([
            'order_increment_id' => $orderIncrementId,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pin_code,
            'coupon' => session('coupon_name', ''),
            'coupon_discount' => $discount,
            'subtotal' => $product->price,
            'total' => $total,
            'payment_method' => 'cod',
        ]);

        Order_item::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku ?? '',
            'price' => $product->price,
            'qty' => 1,
            'row_total' => $total,
            'custom_option' => '',
        ]);

        if ($request->sameBillingShipping == 1) {
            Order_address::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->pin_code,
                'address_type' => 'Shipping Address',
            ]);
        }
        $orderItems = Order_item::where('order_id', $order->id)->get();

        session()->forget('coupon_name');
        session()->forget('coupon_discount');

        // Mail::to($request->email)->send(new MyEmail(Auth::user(), $order, [$product]));

        Mail::to('dineshkumarbangrwa55@gmail.com')->send(new MyEmail(Auth::user(), $order, $orderItems));
        $langCode = session('language_code', app()->getLocale());

        return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'Order placed successfully!');
    }
}
