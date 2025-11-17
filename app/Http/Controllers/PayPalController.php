<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Quote;
use App\Models\Order;
use App\Models\Order_address;
use App\Models\Order_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;
use Illuminate\Http\RedirectResponse;

class PayPalController extends Controller
{
    // Show PayPal checkout page
    public function index()
    {
        $quote = Auth::check()
            ? Quote::where('user_id', Auth::id())->with('quoteItems')->first()
            : Quote::where('cart_id', session('cart_id'))->with('quoteItems')->first();

        return view('paypal', compact('quote'));
    }

    // Create PayPal payment order
    public function payment(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'address_2' => 'nullable|string|max:500',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pin_code' => 'required|string|max:10',
            'payment_method' => 'required|in:paypal',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $quote = Auth::check()
            ? Quote::where('user_id', Auth::id())->with('quoteItems')->first()
            : Quote::where('cart_id', session('cart_id'))->with('quoteItems')->first();

        if (!$quote || $quote->total <= 0) {
            return redirect()->back()->with('error', 'Cart is empty or total invalid.');
        }

        // Create order
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($quote->total, 2, '.', ''),
                ]
            ]],
        ]);

        // Store checkout data for success callback
        session(['checkout_data' => $request->all()]);

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('paypal')->with('error', 'Error creating PayPal order.');
    }

    // Payment success callback
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $user = Auth::user();
            $quote = $user
                ? Quote::where('user_id', $user->id)->with('quoteItems')->first()
                : Quote::where('cart_id', session('cart_id'))->with('quoteItems')->first();

            if (!$quote || $quote->quoteItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty');
            }

            $data = session('checkout_data');

            $lastOrder = Order::orderByDesc('id')->first();
            $orderIncrementId = $lastOrder ? $lastOrder->order_increment_id + 1 : 1000;

            $orderData = [
                'order_increment_id' => $orderIncrementId,
                'user_id' => $user ? $user->id : null,
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'phone' => $data['phone'] ?? '',
                'address' => $data['address'] ?? '',
                'address_2' => $data['address_2'] ?? '',
                'city' => $data['city'] ?? '',
                'state' => $data['state'] ?? '',
                'country' => $data['country'] ?? '',
                'pincode' => $data['pin_code'] ?? '',
                'coupon' => $quote->coupon ?? '',
                'coupon_discount' => $quote->coupon_discount ?? 0,
                'subtotal' => $quote->subtotal ?? 0,
                'total' => $quote->total ?? 0,
                'payment_method' => 'paypal',
            ];

            $order = Order::create($orderData);

            if (!empty($orderData['address'])) {
                Order_address::create([
                    'order_id' => $order->id,
                    'user_id' => $user ? $user->id : null,
                    'name' => $orderData['name'],
                    'email' => $orderData['email'],
                    'phone' => $orderData['phone'],
                    'address' => $orderData['address'],
                    'address_2' => $orderData['address_2'],
                    'city' => $orderData['city'],
                    'state' => $orderData['state'],
                    'country' => $orderData['country'],
                    'pincode' => $orderData['pincode'],
                    'address_type' => 'Shipping Address',
                ]);
            }

            foreach ($quote->quoteItems as $item) {
                Order_item::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'row_total' => $item->row_total,
                    'custom_option' => $item->custom_option,
                ]);
                $item->delete();
            }

            $quote->update([
                'subtotal' => 0,
                'total' => 0,
                'coupon' => null,
                'coupon_discount' => 0,
            ]);

            session()->forget('checkout_data');
            session()->forget('coupon');
            session()->forget('coupon_discount');

            Mail::to($orderData['email'])->send(new MyEmail($user, $order, Order_item::where('order_id', $order->id)->get()));

            return redirect()->route('lang.index', ['lang' => session('language_code', app()->getLocale())])
                ->with('success', 'Order placed successfully via PayPal');
        }

        return redirect()->route('paypal')->with('error', 'Payment failed or cancelled');
    }

    public function paymentCancel(): RedirectResponse
    {
        return redirect()->route('paypal')->with('error', 'Payment was cancelled.');
    }
}
