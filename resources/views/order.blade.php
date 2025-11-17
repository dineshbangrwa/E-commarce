@php
    $title = 'My Orders';
    $langCode = session('language_code', app()->getLocale());
@endphp
@include('includes.header')

<div class="my-account-box-main">
    <div class="container">
        <div class="my-account-page">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>My Orders</h1>
                        <p>Here are all your past orders.</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_increment_id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ session('currency_symbol', '₹') }}
                                            {{ number_format($order->total * session('currency_rate', 1), 2) }}</td>
                                        <td>{{ ucfirst($order->payment_method ?? '') }}</td>
                                        <td>
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', ['lang' => $langCode, 'order' => $order->id]) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
