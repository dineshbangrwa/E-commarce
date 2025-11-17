<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Summary</title>
</head>

<body>
    <h2>New Order Received</h2>

    <p><strong>Customer Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->pincode }},
        {{ $order->country }}</p>

    <h3>Order Details:</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Image</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>₹{{ $item->price }}</td>
                    <td><img src="{{ $item->product->getFirstMediaUrl('image') }}"loading="lazy" width="60"
                            height="60" alt="{{ $item->name }}"></td>
                    <td>{{ $item->qty }}</td>
                    <td>₹{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> ₹{{ $order->subtotal }}</p>
    <p><strong>Total:</strong> ₹{{ $order->total }}</p>
    @if ($order->coupon)
        <p><strong>Coupon:</strong> {{ $order->coupon }} (₹{{ $order->coupon_discount }} off)</p>
    @endif
</body>

</html>
