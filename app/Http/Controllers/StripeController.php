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
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session as StripeSession;

use Stripe\Stripe;

class StripeController extends Controller
{
    public function stripe(): View
    {
        $quote = Auth::check()
            ? Quote::where('user_id', Auth::id())->with('quoteItems')->first()
            : Quote::where('cart_id', session('cart_id'))->with('quoteItems')->first();

        $quote->coupon_discount = session('coupon_discount', 0);
        $quote->coupon_name = session('coupon_name', '');

        return view('stripe', compact('quote'));
    }

    public function stripePost(Request $request): RedirectResponse
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

        $quote = Auth::check()
            ? Quote::where('user_id', Auth::id())->with('quoteItems')->first()
            : Quote::where('cart_id', session('cart_id'))->with('quoteItems')->first();

        if (!$quote || $quote->total <= 0) {
            return redirect()->back()->with('error', 'Cart total is invalid or empty.');
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => 'Order from ' . $request->name,
                    ],
                    'unit_amount' => intval($quote->total * 100), // make sure it's integer
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => array_merge(
                $request->except('_token'),
                [
                    'coupon' => session('coupon_name', ''),
                    'coupon_discount' => session('coupon_discount', 0),
                ]
            ),
        ]);

        return redirect($session->url);
    }
    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');
        $session = StripeSession::retrieve($sessionId);
        $metadata = $session->metadata;

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
        // dd($lastOrder);
        $orderdata = [
            'order_increment_id' => $orderIncrementId,
            'user_id' => $user->id,
            'name' => $metadata->name,
            'email' => $metadata->email,
            'phone' => $metadata->phone,
            'address' => $metadata->address,
            'address_2' => $metadata->address_2 ?? '',
            'city' => $metadata->city,
            'state' => $metadata->state,
            'country' => $metadata->country,
            'pincode' => $metadata->pin_code,
            'coupon' => $cart->coupon ?? '',
            'coupon_discount' => $cart->coupon_discount ?? '',
            'subtotal' => $cart->subtotal ?? 0,
            'total' => $cart->total ?? 0,
            'payment_method' => $metadata->payment_method,
        ];

        $order = Order::create($orderdata);
        // dd($order);

        $cart->update([
            'subtotal' => 0,
            'total' => 0,
        ]);

        if ($metadata->sameBillingShipping == 1) {

            Order_address::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'name' => $metadata->name,
                'email' => $metadata->email,
                'phone' => $metadata->phone,
                'address' => $metadata->address,
                'address_2' => $metadata->address_2 ?? '',
                'city' => $metadata->city,
                'state' => $metadata->state,
                'country' => $metadata->country,
                'pincode' => $metadata->pin_code,
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
                $options = explode(',', $cartItem->custom_option);
                foreach ($options as $option) {
                    $pair = explode(':', $option);

                    if (count($pair) == 2) {
                        $value = trim($pair[1]);

                        $attributeValue = Attributevalue::where('value', $value)
                            ->where('product_id', $cartItem->product_id)
                            ->first();

                        if ($attributeValue) {
                            $combination = AttributeCombination::where('product_id', $cartItem->product_id)
                                ->where('attribute_value_ids', $attributeValue->id)
                                ->first();

                            if ($combination) {
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
        // Mail::to($user)->send(new MyEmail($user, $order, $orderItems));

        // dd($user);
        $langCode = session('language_code', app()->getLocale());

        return redirect()->route('lang.index',['lang' => $langCode])->with('message', 'Order placed successfully.');
    }
}
