@php
    $title = ($category->name ?? 'Shop') . ' - Zopify';
    $meta_description = $category->meta_description ?? 'Explore our ' . ($category->name ?? 'products') . ' collection.';
    $meta_keywords = $category->meta_tag ?? 'category, zopify, ' . ($category->name ?? 'shop');
@endphp
@extends('layouts.app')

@section('content')
@php
    $rate = session('currency_rate', 1);
    $symbol = session('currency_symbol', '₹');
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">{{ $category->name ?? 'Shop' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1">
                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] sticky top-24">
                    <h3 class="text-white font-semibold mb-4">{{ __('buttons.categories') }}</h3>
                    <div class="space-y-1">
                        @foreach (category() as $cat)
                            @if ($cat->subcategories->count())
                            <div x-data="{ open: {{ request()->is('category/' . $cat->url_key) ? 'true' : 'false' }} }">
                                <button @click="open = !open"
                                    class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg transition-colors {{ request()->is('category/' . $cat->url_key) ? 'text-white bg-[rgba(108,59,241,0.15)]' : 'text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]' }}">
                                    {{ $cat->name }}
                                    <i class="fas fa-chevron-down text-[10px]" :class="{'rotate-180': open}"></i>
                                </button>
                                <div x-show="open" class="ml-3 mt-1 space-y-1">
                                    @foreach ($cat->subcategories as $sub)
                                        <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $sub->url_key]) }}"
                                            class="block px-3 py-1.5 text-xs rounded-lg transition-colors {{ request()->is('category/' . $sub->url_key) ? 'text-[#8B5CF6] bg-[rgba(108,59,241,0.1)]' : 'text-[#6B7280] hover:text-[#9CA3AF]' }}">
                                            {{ $sub->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @else
                                <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $cat->url_key]) }}"
                                    class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg transition-colors {{ request()->is('category/' . $cat->url_key) ? 'text-white bg-[rgba(108,59,241,0.15)]' : 'text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]' }}">
                                    {{ $cat->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-[rgba(255,255,255,0.06)]">
                        <h3 class="text-white font-semibold mb-4">Price Range</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="price" class="text-[#6C3BF1] focus:ring-[#6C3BF1] bg-[rgba(255,255,255,0.05)] border-[rgba(255,255,255,0.1)]">
                                <span class="text-sm text-[#9CA3AF]">Under ₹500</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="price" class="text-[#6C3BF1] focus:ring-[#6C3BF1] bg-[rgba(255,255,255,0.05)] border-[rgba(255,255,255,0.1)]">
                                <span class="text-sm text-[#9CA3AF]">₹500 - ₹1,000</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="price" class="text-[#6C3BF1] focus:ring-[#6C3BF1] bg-[rgba(255,255,255,0.05)] border-[rgba(255,255,255,0.1)]">
                                <span class="text-sm text-[#9CA3AF]">₹1,000 - ₹5,000</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="price" class="text-[#6C3BF1] focus:ring-[#6C3BF1] bg-[rgba(255,255,255,0.05)] border-[rgba(255,255,255,0.1)]">
                                <span class="text-sm text-[#9CA3AF]">Above ₹5,000</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-[#9CA3AF]">Showing <span class="text-white font-medium">{{ $products->count() }}</span> results</p>
                    <div class="flex items-center gap-2">
                        <select class="bg-[rgba(255,255,255,0.05)] border border-[rgba(255,255,255,0.1)] rounded-lg px-3 py-2 text-sm text-[#9CA3AF] outline-none focus:border-[#6C3BF1]">
                            <option>Sort by: Default</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest First</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6">
                    @forelse ($products as $product)
                        @php
                            $now = \Carbon\Carbon::now();
                            $hasSpecialPrice = $product->special_price && $product->special_price_from && $product->special_price_to && $now->between($product->special_price_from, $product->special_price_to);
                            if ($hasSpecialPrice) {
                                $discount = (($product->price - $product->special_price) / $product->price) * 100;
                            }
                        @endphp
                        <div class="card-product group">
                            <div class="relative aspect-square overflow-hidden">
                                @if ($hasSpecialPrice)
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
                                <div class="mt-2 flex items-center justify-between">
                                    <div>
                                        @if ($hasSpecialPrice)
                                            <span class="text-xs text-[#9CA3AF] line-through">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                                            <span class="text-sm font-bold text-[#8B5CF6] ml-1">{{ $symbol }}{{ number_format($product->special_price * $rate, 2) }}</span>
                                        @else
                                            <span class="text-sm font-bold text-white">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#6C3BF1]/20 text-[#8B5CF6] hover:bg-[#6C3BF1] hover:text-white transition-all">
                                        <i class="fas fa-plus text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-box-open text-4xl text-[#6B7280] mb-4"></i>
                            <p class="text-[#9CA3AF]">No products found in this category.</p>
                        </div>
                    @endforelse
                </div>
                @if (method_exists($products, 'links'))
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
