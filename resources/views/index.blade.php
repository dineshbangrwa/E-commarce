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

{{-- Hero Slider --}}
<section class="relative pt-16 lg:pt-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-[#6C3BF1]/10 via-transparent to-transparent pointer-events-none"></div>
    <div id="hero-slider" class="relative">
        @foreach ($sliders as $index => $slider)
            <div class="hero-slide {{ $index === 0 ? 'block' : 'hidden' }} relative">
                <div class="relative h-[60vh] lg:h-[80vh] min-h-[400px]">
                    <img src="{{ $slider->getFirstMediaUrl('image') }}" alt="{{ $slider->title }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0F0F1A]/90 via-[#0F0F1A]/70 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F0F1A] via-transparent to-transparent"></div>
                    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                        <div class="max-w-xl">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-[#6C3BF1]/20 text-[#8B5CF6] border border-[#6C3BF1]/30 mb-4">Featured Collection</span>
                            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-white leading-tight mb-4">
                                {{ $slider->title }}
                            </h1>
                            <p class="text-sm sm:text-base lg:text-lg text-[#9CA3AF] leading-relaxed mb-6">
                                {{ $slider->description }}
                            </p>
                            <a href="#" class="btn-primary">
                                Shop Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($sliders->count() > 1)
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                @foreach ($sliders as $index => $slider)
                    <button onclick="goToSlide({{ $index }})"
                        class="w-2 h-2 rounded-full transition-all duration-300 slide-dot {{ $index === 0 ? 'bg-[#8B5CF6] w-6' : 'bg-[#9CA3AF]/50 hover:bg-[#9CA3AF]' }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Categories --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <div class="text-center mb-10">
        <h2 class="section-title">Shop by Category</h2>
        <p class="text-[#9CA3AF] text-sm">Find what you're looking for in our curated categories</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 lg:gap-6">
        @foreach (category() as $category)
            <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $category->url_key]) }}"
                class="group relative rounded-2xl overflow-hidden card-product">
                <div class="aspect-[4/3]">
                    <img src="{{ $category->getFirstMediaUrl('image') }}" alt="{{ $category->name }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F0F1A]/90 via-[#0F0F1A]/30 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-6">
                    <h3 class="text-white font-semibold text-base lg:text-lg group-hover:text-[#8B5CF6] transition-colors">{{ $category->name }}</h3>
                    <p class="text-xs text-[#9CA3AF] mt-1 opacity-0 group-hover:opacity-100 transition-opacity">Explore Now <i class="fas fa-arrow-right ml-1"></i></p>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- Featured Products --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <div class="text-center mb-10">
        <h2 class="section-title">{{ __('buttons.featured_products') }}</h2>
        <p class="text-[#9CA3AF] text-sm">{{ __('buttons.featured_products_desc') }}</p>
        <div class="flex items-center justify-center gap-2 mt-6">
            <button class="filter-btn active px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300" data-filter="all">
                {{ __('buttons.all') }}
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]" data-filter="featured">
                {{ __('buttons.top_featured') }}
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]" data-filter="bestseller">
                {{ __('buttons.best_seller') }}
            </button>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6" id="product-grid">
        @foreach (product() as $product)
            @php
                $now = \Carbon\Carbon::now();
                $hasSpecialPrice = $product->special_price && $product->special_price_from && $product->special_price_to && $now->between($product->special_price_from, $product->special_price_to);
                if ($hasSpecialPrice) {
                    $discount = (($product->price - $product->special_price) / $product->price) * 100;
                }
            @endphp
            <div class="card-product group product-item" data-category="bestseller">
                <div class="relative aspect-square overflow-hidden">
                    <span class="absolute top-3 left-3 z-10">
                        @if ($hasSpecialPrice)
                            <span class="badge-sale">{{ round($discount) }}% OFF</span>
                        @else
                            <span class="badge-new">New</span>
                        @endif
                    </span>
                    <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                        <img src="{{ $product->getFirstMediaUrl('image') }}" alt="{{ $product->translated_name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                        <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}"
                            class="w-10 h-10 flex items-center justify-center rounded-full glass text-white hover:text-[#8B5CF6] transition-all">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                            class="w-10 h-10 flex items-center justify-center rounded-full glass text-white hover:text-[#EF4444] transition-all">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>
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
        @endforeach
    </div>
</section>

{{-- Blog --}}
@if ($blocks->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <div class="text-center mb-10">
        <h2 class="section-title">{{ __('buttons.Latest Blog') }}</h2>
        <p class="text-[#9CA3AF] text-sm">{{ __('buttons.sample_text') }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($blocks as $block)
            <div class="card-product group">
                <div class="aspect-[16/9] overflow-hidden">
                    <img src="{{ $block->getFirstMediaUrl('image') }}" alt="{{ $block->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="text-base font-semibold text-white group-hover:text-[#8B5CF6] transition-colors">{{ $block->name }}</h3>
                    <p class="text-sm text-[#9CA3AF] mt-2 line-clamp-3">{{ $block->description }}</p>
                    <a href="#" class="inline-flex items-center text-sm text-[#8B5CF6] hover:text-white transition-colors mt-4">
                        Read More <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- You May Also Like --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <div class="text-center mb-10">
        <h2 class="section-title">{{ __('buttons.you_may_also_like') }}</h2>
        <p class="text-[#9CA3AF] text-sm">{{ __('buttons.you_may_also_like_desc') }}</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach (product1() as $product)
            @php
                $now = \Carbon\Carbon::now();
                $hasSpecialPrice = $product->special_price && $product->special_price_from && $product->special_price_to && $now->between($product->special_price_from, $product->special_price_to);
            @endphp
            <div class="card-product group">
                <div class="relative aspect-square overflow-hidden">
                    <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                        <img src="{{ $product->getFirstMediaUrl('image') }}" alt="{{ $product->translated_name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                        <a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                            class="w-10 h-10 flex items-center justify-center rounded-full glass text-white hover:text-[#EF4444] transition-all">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>
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
</section>

@push('scripts')
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slide-dot');

    function goToSlide(index) {
        slides.forEach(s => s.classList.add('hidden'));
        dots.forEach(d => d.classList.remove('bg-[#8B5CF6]', 'w-6'));
        dots.forEach(d => d.classList.add('bg-[#9CA3AF]/50'));
        slides[index].classList.remove('hidden');
        dots[index].classList.remove('bg-[#9CA3AF]/50');
        dots[index].classList.add('bg-[#8B5CF6]', 'w-6');
        currentSlide = index;
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % slides.length);
    }

    if (slides.length > 1) {
        setInterval(nextSlide, 5000);
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active', 'bg-[rgba(108,59,241,0.15)]', 'text-white');
                b.classList.add('text-[#9CA3AF]');
            });
            this.classList.add('active', 'bg-[rgba(108,59,241,0.15)]', 'text-white');
            this.classList.remove('text-[#9CA3AF]');
        });
    });
</script>
@endpush
@endsection
