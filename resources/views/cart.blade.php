@php
    $title = 'Your Cart';
@endphp
@extends('layouts.app')

@section('content')
@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('shop', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.shop') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">{{ __('buttons.cart') }}</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">{{ __('buttons.cart') }}</h1>

        @if (quote() && quote()->quoteItems && quote()->quoteItems->count() > 0)
            <div class="glass rounded-2xl border border-[rgba(255,255,255,0.06)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[rgba(255,255,255,0.06)]">
                                <th class="text-left py-4 px-6 text-xs font-medium text-[#9CA3AF] uppercase tracking-wider">{{ __('buttons.product') }}</th>
                                <th class="text-left py-4 px-6 text-xs font-medium text-[#9CA3AF] uppercase tracking-wider">{{ __('buttons.price') }}</th>
                                <th class="text-left py-4 px-6 text-xs font-medium text-[#9CA3AF] uppercase tracking-wider">{{ __('buttons.quantity') }}</th>
                                <th class="text-left py-4 px-6 text-xs font-medium text-[#9CA3AF] uppercase tracking-wider">{{ __('buttons.total') }}</th>
                                <th class="text-right py-4 px-6 text-xs font-medium text-[#9CA3AF] uppercase tracking-wider">{{ __('buttons.remove') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (quote()->quoteItems as $item)
                                <tr class="border-b border-[rgba(255,255,255,0.04)] hover:bg-[rgba(255,255,255,0.02)] transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $item->product->getFirstMediaUrl('image') }}" alt="{{ $item->product->name }}"
                                                class="w-16 h-16 rounded-xl object-cover">
                                            <div>
                                                <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}"
                                                    class="text-sm font-medium text-white hover:text-[#8B5CF6] transition-colors">{{ $item->product->name }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-[#F1F1F6]">{{ $symbol }}{{ number_format($item->price * $rate, 2) }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center glass rounded-lg border border-[rgba(255,255,255,0.06)] w-fit">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="qty" value="{{ max(1, $item->qty - 1) }}" class="px-3 py-1.5 text-[#9CA3AF] hover:text-white transition-colors text-sm"><i class="fas fa-minus"></i></button>
                                                <span class="px-3 py-1.5 text-white font-medium text-sm min-w-[30px] text-center">{{ $item->qty }}</span>
                                                <button type="submit" name="qty" value="{{ $item->qty + 1 }}" class="px-3 py-1.5 text-[#9CA3AF] hover:text-white transition-colors text-sm"><i class="fas fa-plus"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-white" id="total-{{ $item->id }}">{{ $symbol }}{{ number_format($item->price * $item->qty * $rate, 2) }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-[#EF4444] hover:bg-[#EF4444]/10 transition-all">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                <div class="lg:col-span-2"></div>
                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)]">
                    <h3 class="text-white font-semibold text-lg mb-4">{{ __('buttons.cart_total') }}</h3>
                    @php
                        $subtotal = quote()->quoteItems->sum(function ($item) use ($rate) { return $item->price * $item->qty * $rate; });
                    @endphp
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-[#9CA3AF]">{{ __('buttons.sub_total') }}</span>
                            <span class="text-white">{{ $symbol }}{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#9CA3AF]">Shipping</span>
                            <span class="text-[#10B981]">Free</span>
                        </div>
                        <div class="border-t border-[rgba(255,255,255,0.06)] pt-3 flex justify-between">
                            <span class="text-white font-semibold">{{ __('buttons.total') }}</span>
                            <span class="text-white font-bold text-lg">{{ $symbol }}{{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 mt-6">
                        <a href="{{ route('checkout', ['lang' => $langCode]) }}" class="btn-primary w-full justify-center">
                            {{ __('buttons.proceed_to_checkout') }} <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="btn-secondary w-full justify-center">
                            {{ __('buttons.continue_shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full glass flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-2xl text-[#6B7280]"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">{{ __('buttons.your_cart_is_empty') }}</h3>
                <p class="text-sm text-[#9CA3AF] mb-6">{{ __('buttons.add_items_to_cart') }}</p>
                <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="btn-primary">
                    {{ __('buttons.continue_shopping') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
