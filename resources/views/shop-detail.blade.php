@php
    $title = $product->name . ' - Zopify';
    $meta_description = $product->meta_description ?? Str::limit(strip_tags($product->description), 160);
    $meta_keywords = $product->meta_tag ?? 'product, zopify, ' . $product->name;
@endphp
@extends('layouts.app')

@section('content')
@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
    $now = \Carbon\Carbon::now();
    $hasSpecialPrice = $product->special_price && $product->special_price_from && $product->special_price_to && $now->between($product->special_price_from, $product->special_price_to);
    if ($hasSpecialPrice) {
        $discount = (($product->price - $product->special_price) / $product->price) * 100;
    }
    $images = $product->getMedia('image');
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            @if ($product->category)
                <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $product->category->url_key]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ $product->category->name }}</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
            @endif
            <span class="text-[#F1F1F6]">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <div>
                <div class="glass rounded-2xl p-2 border border-[rgba(255,255,255,0.06)]">
                    <div id="productCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner rounded-xl overflow-hidden">
                            @foreach ($images as $key => $image)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                                </div>
                            @endforeach
                        </div>
                        @if ($images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-target="#productCarousel" data-slide="prev">
                                <span class="w-10 h-10 flex items-center justify-center rounded-full glass text-white" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#productCarousel" data-slide="next">
                                <span class="w-10 h-10 flex items-center justify-center rounded-full glass text-white" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                            </button>
                        @endif
                    </div>
                    @if ($images->count() > 1)
                        <div class="flex gap-2 mt-2">
                            @foreach ($images as $key => $image)
                                <img src="{{ $image->getUrl() }}" alt="thumb"
                                    class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition-colors {{ $key === 0 ? 'border-[#6C3BF1]' : 'border-transparent hover:border-[rgba(255,255,255,0.2)]' }}"
                                    onclick="$('#productCarousel').carousel({{ $key }})">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-[#6C3BF1]/20 text-[#8B5CF6] border border-[#6C3BF1]/30 mb-3">
                    @if ($product->category) {{ $product->category->name }} @else Product @endif
                </span>
                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-[#F59E0B] text-sm">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-sm text-[#9CA3AF]">(4.5 Reviews)</span>
                </div>

                <div class="flex items-baseline gap-3 mb-6">
                    @if ($hasSpecialPrice)
                        <span class="text-3xl font-bold text-[#8B5CF6]">{{ $symbol }}{{ number_format($product->special_price * $rate, 2) }}</span>
                        <span class="text-lg text-[#6B7280] line-through">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                        <span class="badge-sale text-xs">SAVE {{ round($discount) }}%</span>
                    @else
                        <span class="text-3xl font-bold text-white">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</span>
                    @endif
                </div>

                <p class="text-sm text-[#9CA3AF] leading-relaxed mb-6">{{ $product->description }}</p>

                @if ($product->variants && $product->variants->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-white mb-3">Variants</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->variants as $variant)
                                <div class="px-4 py-2 rounded-xl glass border border-[rgba(255,255,255,0.06)] hover:border-[#6C3BF1] transition-all cursor-pointer text-center">
                                    <p class="text-xs text-[#9CA3AF]">{{ $variant->label ?? $variant->name }}</p>
                                    <p class="text-sm font-medium text-white">{{ $symbol }}{{ number_format($variant->price * $rate, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center glass rounded-xl border border-[rgba(255,255,255,0.06)]">
                        <button onclick="decrementQty()" class="px-4 py-2.5 text-[#9CA3AF] hover:text-white transition-colors"><i class="fas fa-minus"></i></button>
                        <span id="qty-display" class="px-4 py-2.5 text-white font-medium min-w-[40px] text-center">1</span>
                        <button onclick="incrementQty()" class="px-4 py-2.5 text-[#9CA3AF] hover:text-white transition-colors"><i class="fas fa-plus"></i></button>
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="qty" id="qty-input" value="1">
                        <button type="submit" class="btn-primary w-full justify-center">
                            <i class="fas fa-shopping-bag"></i> {{ __('buttons.Add to Cart') }}
                        </button>
                    </form>
                    <a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                        class="w-12 h-12 flex items-center justify-center rounded-xl glass border border-[rgba(255,255,255,0.06)] text-[#9CA3AF] hover:text-[#EF4444] hover:border-[#EF4444]/30 transition-all">
                        <i class="far fa-heart"></i>
                    </a>
                </div>

                <div class="glass rounded-2xl p-5 border border-[rgba(255,255,255,0.06)]">
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2 text-[#9CA3AF]">
                            <i class="fas fa-truck text-[#8B5CF6]"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="w-px h-4 bg-[rgba(255,255,255,0.06)]"></div>
                        <div class="flex items-center gap-2 text-[#9CA3AF]">
                            <i class="fas fa-undo text-[#8B5CF6]"></i>
                            <span>7 Days Return</span>
                        </div>
                        <div class="w-px h-4 bg-[rgba(255,255,255,0.06)]"></div>
                        <div class="flex items-center gap-2 text-[#9CA3AF]">
                            <i class="fas fa-shield-alt text-[#8B5CF6]"></i>
                            <span>Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function incrementQty() {
        let qty = parseInt(document.getElementById('qty-display').textContent);
        qty++;
        document.getElementById('qty-display').textContent = qty;
        document.getElementById('qty-input').value = qty;
    }
    function decrementQty() {
        let qty = parseInt(document.getElementById('qty-display').textContent);
        if (qty > 1) { qty--; }
        document.getElementById('qty-display').textContent = qty;
        document.getElementById('qty-input').value = qty;
    }
</script>
@endpush
@endsection
