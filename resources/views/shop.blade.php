@php
    $title = $category->name . ' ' . 'Zopify' ?? $category->name . ' - Zopify';
    $meta_description = $category->meta_description ?? 'Explore our ' . $category->name . ' collection.';
    $meta_keywords = $category->meta_tag ?? 'category, zopify, ' . $category->name;
@endphp
@include('includes.header')


@php
    $rate = session('currency_rate', 1);
    $symbol = session('currency_symbol', '₹');
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ __('buttons.shop') }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('lang.index', ['lang' => $langCode]) }}">{{ __('buttons.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ $category->name ?? 'Shop' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    .products-single .box-img-hover img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }
</style>
<div class="shop-box-inner">

    <div class="container">
        <div class="row">

            <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">

                <div class="filter-sidebar-left">
                    <div class="title-left">
                        <h3>{{ __('buttons.categories') }}</h3>
                    </div>
                    <div class="list-group list-group-collapse list-group-sm list-group-tree" id="list-group-men"
                        data-children=".sub-men">
                        @foreach (category() as $category)
                            @if ($category->subcategories->count())
                                <div class="list-group-collapse sub-men">
                                    <a class="list-group-item list-group-item-action" href="#cat-{{ $category->id }}"
                                        data-toggle="collapse" aria-expanded="false"
                                        aria-controls="cat-{{ $category->id }}">
                                        {{ $category->name }}
                                        <small class="text-muted">({{ $category->products->count() }})</small>
                                    </a>
                                    <div class="collapse" id="cat-{{ $category->id }}" data-parent="#list-group-men">
                                        <div class="list-group">
                                            @foreach ($category->subcategories as $sub)
                                                <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $sub->url_key]) }}"
                                                    class="list-group-item list-group-item-action">
                                                    {{ $sub->name }}
                                                    <small class="text-muted">({{ $sub->products->count() }})</small>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $category->url_key]) }}"
                                    class="list-group-item list-group-item-action">
                                    {{ $category->name }}
                                    <small class="text-muted">({{ $category->products->count() }})</small>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
                @if ($products->isNotEmpty())
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="filter-price-left mb-4">
                            <div class="title-left">
                                <h3>{{ __('buttons.price') }}</h3>
                            </div>
                            @php
                                $symbol = session('currency_symbol', '₹');
                                $rate = session('currency_rate', 1);

                                $rawRanges = ['100-1000', '1000-5000', '5000-10000'];

                                $priceRanges = [];

                                foreach ($rawRanges as $range) {
                                    [$min, $max] = explode('-', $range);
                                    $minConverted = number_format($min * $rate, 2);
                                    $maxConverted = number_format($max * $rate, 2);
                                    $priceRanges[$range] = "{$symbol}{$minConverted} - {$symbol}{$maxConverted}";
                                }
                            @endphp

                            @foreach ($priceRanges as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range"
                                        value="{{ $value }}" id="price_{{ $value }}"
                                        {{ request('price_range') == $value ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="price_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach

                        </div>

                        @if (!empty($sizes))
                            <div class="filter-price-left mb-4">
                                <div class="title-left">
                                    <h3>{{ __('buttons.size') }}</h3>
                                </div>
                                @foreach ($sizes as $size)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size"
                                            value="{{ $size }}" id="size_{{ $size }}"
                                            {{ request('size') == $size ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="size_{{ $size }}">{{ strtoupper($size) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (!empty($colors))
                            <div class="filter-price-left mb-4">
                                <div class="title-left">
                                    <h3>{{ __('buttons.color') }}</h3>
                                </div>
                                @foreach ($colors as $color)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color"
                                            value="{{ $color }}" id="color_{{ $color }}"
                                            {{ request('color') == $color ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="color_{{ $color }}">{{ ucfirst($color) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mt-2">
                            {{ __('buttons.apply_filters') }}</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100 mt-2">
                            {{ __('buttons.clear_filters') }}</a>
                    </form>
                @endif
            </div>

            <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                <div class="row product-categorie-box">
                    @forelse ($products as $product)
                        <div class="col-sm-6 col-md-6 col-lg-4 mb-4">
                            <div class="products-single fix">
                                <div class="box-img-hover">
                                    <img src="{{ $product->getFirstMediaUrl('image') ?? 'default.jpg' }}"
                                        loading="lazy" class="img-fluid" alt="{{ $product->name }}">
                                    <div class="mask-icon">
                                        <ul>
                                            <li><a href="{{ route('product.show', $product->id) }}"
                                                    data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>
                                            </li>
                                            <li><a href="#" data-toggle="tooltip" title="Compare"><i
                                                        class="fas fa-sync-alt"></i></a></li>
                                            <li>
                                                <a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                                                    data-toggle="tooltip" title="Add to Wishlist">
                                                    <i class="far fa-heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <a class="cart"
                                            href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">Add
                                            to Cart</a>
                                    </div>
                                </div>
                                <div class="why-text text-center">
                                    <a class="cart"
                                        href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                        <h4>{{ $product->translated_name }}</h4><a>
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $hasSpecialPrice =
                                                    $product->special_price &&
                                                    $product->special_price_from &&
                                                    $product->special_price_to &&
                                                    $now->between(
                                                        $product->special_price_from,
                                                        $product->special_price_to,
                                                    );
                                            @endphp


                                            @if ($hasSpecialPrice)
                                                <h5>
                                                    <del style="color: #999;">
                                                        {{ $symbol }}
                                                        {{ number_format($product->price * $rate, 2) }}
                                                    </del>
                                                    <span class="text-danger ml-2">
                                                        {{ $symbol }}
                                                        {{ number_format($product->special_price * $rate, 2) }}
                                                    </span>
                                                </h5>
                                            @else
                                                <h5>{{ $symbol }}
                                                    {{ number_format($product->price * $rate, 2) }}</h5>
                                            @endif
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                No products found in this category or matching your filters.
                                <div class="mt-3">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">← Go
                                        Back</a>

                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
