@php
    $meta_description = 'Buy the best fashion products online at Zopify. Explore deals on clothing, electronics, and accessories.';
    $meta_keywords = 'fashion, electronics, online shopping, zopify, deals, offers';
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
            <span class="text-[#F1F1F6]">Search Results</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Search Results</h1>
        <p class="text-sm text-[#9CA3AF] mb-8">
            @if (isset($query) && $query)
                Showing results for "<span class="text-white">{{ $query }}</span>"
            @endif
            <span class="ml-2">({{ $products->count() ?? 0 }} products found)</span>
        </p>

        @if ($products && $products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach ($products as $product)
                    @php
                        $now = \Carbon\Carbon::now();
                        $hasSpecialPrice = $product->special_price && $product->special_price_from && $product->special_price_to && $now->between($product->special_price_from, $product->special_price_to);
                    @endphp
                    <div class="card-product group">
                        <div class="relative aspect-square overflow-hidden">
                            @if ($hasSpecialPrice)
                                @php $discount = (($product->price - $product->special_price) / $product->price) * 100; @endphp
                                <span class="absolute top-3 left-3 z-10 badge-sale">{{ round($discount) }}% OFF</span>
                            @else
                                <span class="absolute top-3 left-3 z-10 badge-new">New</span>
                            @endif
                            <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                <img src="{{ $product->getFirstMediaUrl('image') }}" alt="{{ $product->translated_name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                <h3 class="text-sm font-medium text-[#F1F1F6] group-hover:text-[#8B5CF6] transition-colors line-clamp-2">{{ $product->translated_name }}</h3>
                            </a>
                            <div class="mt-2">
                                @if ($hasSpecialPrice)
                                    <span class="text-xs text-[#9CA3AF] line-through">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                                    <span class="text-sm font-bold text-[#8B5CF6] ml-1">{{ $symbol }}{{ number_format($product->special_price * $rate, 2) }}</span>
                                @else
                                    <span class="text-sm font-bold text-white">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full glass flex items-center justify-center">
                    <i class="fas fa-search text-2xl text-[#6B7280]"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                <p class="text-sm text-[#9CA3AF] mb-6">Try different keywords or browse categories</p>
                <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="btn-primary">
                    Browse Products <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
