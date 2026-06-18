@php
    $title = 'Order #' . $order->order_increment_id;
@endphp
@extends('layouts.app')

@section('content')
@php
    $langCode = session('language_code', app()->getLocale());
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('order.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">My Orders</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">#{{ $order->order_increment_id }}</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">Order #{{ $order->order_increment_id }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)]">
                    <h3 class="text-white font-semibold mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center gap-4 py-3 border-b border-[rgba(255,255,255,0.04)] last:border-0">
                                <img src="{{ $item->product->getFirstMediaUrl('image') }}" class="w-16 h-16 rounded-xl object-cover">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-white">{{ $item->product->name }}</p>
                                    <p class="text-xs text-[#9CA3AF]">Qty: {{ $item->qty }}</p>
                                </div>
                                <span class="text-sm text-white">{{ $symbol }}{{ number_format($item->price * $rate, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)]">
                    <h3 class="text-white font-semibold mb-4">Shipping Address</h3>
                    <div class="text-sm text-[#9CA3AF] space-y-1">
                        <p>{{ $order->address->first_name ?? '' }} {{ $order->address->last_name ?? '' }}</p>
                        <p>{{ $order->address->address ?? '' }}</p>
                        <p>{{ $order->address->city ?? '' }}, {{ $order->address->state ?? '' }} {{ $order->address->postcode ?? '' }}</p>
                        <p>{{ $order->address->country ?? '' }}</p>
                        <p>{{ $order->address->phone ?? '' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] sticky top-24">
                    <h3 class="text-white font-semibold mb-4">Order Summary</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-[#9CA3AF]">
                            <span>Subtotal</span>
                            <span>{{ $symbol }}{{ number_format($order->sub_total * $rate, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-[#9CA3AF]">
                            <span>Shipping</span>
                            <span class="text-[#10B981]">Free</span>
                        </div>
                        <div class="border-t border-[rgba(255,255,255,0.06)] pt-3 flex justify-between">
                            <span class="text-white font-semibold">Total</span>
                            <span class="text-white font-bold text-lg">{{ $symbol }}{{ number_format($order->grand_total * $rate, 2) }}</span>
                        </div>
                        <div class="pt-3">
                            @php
                                $statusColors = ['pending' => '#F59E0B', 'processing' => '#8B5CF6', 'completed' => '#10B981', 'cancelled' => '#EF4444'];
                                $color = $statusColors[$order->status] ?? '#9CA3AF';
                            @endphp
                            <span class="text-xs font-medium px-3 py-1 rounded-full" style="background: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                Status: {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-[#6B7280]">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
