<?php

namespace App\Http\Controllers;

use App\Mail\MyEmail;
use App\Models\AttributeCombination;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class BuyNowController extends Controller
{
    public function checkout(Request $request, $lang, $id)
    {
        app()->setLocale($lang);
        session(['language_code' => $lang]);

        $product = Product::findOrFail($id);
        $qty = $request->input('qty', 1);
        $combinationId = $request->input('combination_id');

        $coupon = session('coupon', null);
        $discount = session('coupon_discount', 0);

        $combination = null;
        if ($combinationId) {
            $combination = AttributeCombination::find($combinationId);
        }

        $price = $combination ? $combination->price : $product->price;
        $subtotal = $price * $qty;
        $total = $subtotal - $discount;

        return view('buycheckout', compact('product', 'qty', 'coupon', 'discount', 'subtotal', 'total', 'combination'));
    }

    public function applyCoupon(Request $request, $lang)
    {
        $lang = session('language_code', config('app.locale', 'en'));

        $request->validate([
            'coupon' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $couponCode = $request->coupon;
        $qty = $request->qty;
        $product = Product::findOrFail($request->product_id);

        $coupon = Coupon::where('coupon_code', $couponCode)->first();

        if (! $coupon || $coupon->status != 1) {
            return redirect()->back()->with('error', 'Invalid or inactive coupon.');
        }

        $now = now();
        if (! $now->between($coupon->valid_from, $coupon->valid_to)) {
            return redirect()->back()->with('error', 'Coupon is not valid right now.');
        }

        $subtotal = $product->price * $qty;
        if ($subtotal < $coupon->coupon_discount) {
            return redirect()->back()->with('error', 'Coupon discount exceeds subtotal.');
        }

        session([
            'coupon' => $coupon->coupon_code,
            'coupon_discount' => $coupon->coupon_discount,
        ]);

        return redirect()->route('buy', ['lang' => $lang, 'id' => $product->id, 'qty' => $qty])
            ->with('message', 'Coupon applied successfully!');
    }

    public function stripePost(Request $request)
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

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $product = Product::findOrFail($request->product_id);
        $qty = $request->input('qty', 1);
        $combinationId = $request->input('combination_id');

        $combination = null;
        if ($combinationId) {
            $combination = AttributeCombination::find($combinationId);
        }

        $price = $combination ? $combination->price : $product->price;

        $coupon = session('coupon', '');
        $discount = session('coupon_discount', 0);
        $subtotal = $price * $qty;
        $total = $subtotal - $discount;

        $unitPriceAfterDiscount = $total / $qty;

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => ['name' => $product->name],
                    'unit_amount' => intval($unitPriceAfterDiscount * 100),
                ],
                'quantity' => $qty,
            ]],
            'mode' => 'payment',
            'success_url' => route('buy.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('buy.cancel'),
            'metadata' => [
                'product_id' => $product->id,
                'qty' => $qty,
                'combination_id' => $combinationId ?? '',
                'coupon' => $coupon,
                'coupon_discount' => $discount,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->pin_code,
                'payment_method' => 'stripe',

            ],
        ]);

        return redirect($session->url);
    }

    public function buysuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = StripeSession::retrieve($request->get('session_id'));
        $meta = $session->metadata;

        $product = Product::findOrFail($meta->product_id);
        $qty = $meta->qty ?? 1;

        $combinationId = $meta->combination_id ?? null;
        $combination = null;
        if ($combinationId) {
            $combination = AttributeCombination::find($combinationId);
        }

        $price = $combination ? $combination->price : $product->price;
        $subtotal = $price * $qty;
        $discount = $meta->coupon_discount ?? 0;
        $total = $subtotal - $discount;

        $order = Order::create([
            'order_increment_id' => Order::max('order_increment_id') + 1 ?? 1000,
            'user_id' => Auth::id(),
            'name' => $meta->name,
            'email' => $meta->email,
            'phone' => $meta->phone,
            'address' => $meta->address,
            'city' => $meta->city,
            'state' => $meta->state,
            'country' => $meta->country,
            'pincode' => $meta->pincode,
            'coupon' => $meta->coupon,
            'coupon_discount' => $discount,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $meta->payment_method,
        ]);

        Order_item::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku ?? '',
            'price' => $price,
            'qty' => $qty,
            'row_total' => $total,
            'custom_option' => $combinationId ?? '',
        ]);

        $orderItems = Order_item::where('order_id', $order->id)->get();

        // Mail::to($meta->email)->send(new MyEmail(Auth::user(), $order, [$product]));
        Mail::to('dineshkumarbangrwa55@gmail.com')->send(new MyEmail(Auth::user(), $order, $orderItems));

        session()->forget('coupon');
        session()->forget('coupon_discount');
        $langCode = session('language_code', app()->getLocale());

        return redirect()->route('lang.index', ['lang' => $langCode])->with('message', 'Order placed successfully!');
    }

    public function buycancel()
    {
        $langCode = session('language_code', app()->getLocale());

        return redirect()->route('lang.index', ['lang' => $langCode])->with('error', 'Payment was cancelled.');
    }
}
