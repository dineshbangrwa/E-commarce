@php
    $title = 'Order Id:' . ' ' . $order->order_increment_id;
    $meta_description = $order->meta_description ?? 'Explore our ' . $order->name . ' collection.';
    $meta_keywords = $order->meta_tag ?? 'order, zopify, ' . $order->name;
    $langCode = session('language_code', app()->getLocale());
@endphp
@include('includes.header')

<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="title-all text-center">
                <h1>Order Details</h1>
                <p>Order ID: <strong>#{{ $order->order_increment_id }}</strong></p>
            </div>

            <div class="card mb-4">
                <div class="card-header"><strong>Order Info</strong></div>
                <div class="card-body">
                    <p><strong>Placed on:</strong> {{ $order->created_at->format('d M Y') }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>

                    <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><strong>Shipping Address</strong></div>
                <div class="card-body">
                    <p>{{ $order->name }}</p>
                    <p>{{ $order->address }}, {{ $order->address_2 }}</p>
                    <p>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
                    <p>{{ $order->country }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><strong>Order Items</strong></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $symbol = session('currency_symbol', '₹');
                                $rate = session('currency_rate', 1);
                            @endphp
                            @foreach ($order->order_items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->name ?? 'N/A' }}
                                    </td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $symbol }} {{ number_format($item->price * $rate, 2) }}</td>
                                    <td>{{ $symbol }} {{ number_format($item->price * $item->qty * $rate, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><strong>Price Summary</strong></div>
                <div class="card-body">
                    <p><strong>Subtotal:</strong> {{ $symbol }} {{ number_format($order->subtotal * $rate, 2) }}
                    </p>
                    @if ($order->coupon)
                        <p><strong>Coupon ({{ $order->coupon }}):</strong> -{{ $symbol }}
                            {{ number_format($order->coupon_discount * $rate, 2) }}</p>
                    @endif
                    <p><strong>Shipping:</strong> {{ $symbol }}
                        {{ number_format($order->shipping_cost * $rate, 2) }}</p>
                    <hr>
                    <p><strong>Total:</strong> {{ $symbol }} {{ number_format($order->total * $rate, 2) }}</p>
                </div>
            </div>

            <div class="text-center">

                <a href="{{ route('orders.index', ['lang' => $langCode]) }}" class="btn btn-outline-dark">← Back to My
                    Orders</a>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
