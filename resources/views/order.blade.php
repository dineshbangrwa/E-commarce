@php
    $title = 'My Orders';
@endphp
@extends('layouts.app')

@section('content')
@php
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">My Orders</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">My Orders</h1>

        @if ($orders && $orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('order.show', ['lang' => session('language_code', app()->getLocale()), 'id' => $order->id]) }}"
                        class="block glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] hover:border-[#6C3BF1]/30 transition-all group">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <p class="text-sm text-[#9CA3AF]">Order #<span class="text-white font-medium">{{ $order->order_increment_id }}</span></p>
                                <p class="text-xs text-[#6B7280] mt-1">{{ $order->created_at->format('d M, Y') }}</p>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = ['pending' => '#F59E0B', 'processing' => '#8B5CF6', 'completed' => '#10B981', 'cancelled' => '#EF4444'];
                                    $color = $statusColors[$order->status] ?? '#9CA3AF';
                                @endphp
                                <span class="text-xs font-medium px-3 py-1 rounded-full" style="background: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-sm text-white font-medium mt-2">
                                    {{ session('currency_symbol', '₹') }}{{ number_format($order->grand_total * session('currency_rate', 1), 2) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full glass flex items-center justify-center">
                    <i class="fas fa-box text-2xl text-[#6B7280]"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No orders yet</h3>
                <p class="text-sm text-[#9CA3AF] mb-6">Start shopping to see your orders here</p>
                <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="btn-primary">
                    Start Shopping <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
