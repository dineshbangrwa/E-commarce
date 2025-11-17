@php
    $meta_description = 'Buy the best fashion products online at Zopify. Explore deals on clothing, electronics, and
accessories.';
    $meta_keywords = 'fashion, electronics, online shopping, zopify, deals, offers';
@endphp
@include('includes.header')

@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
@endphp
<!-- Start Top Search -->
<div class="top-search">
    <div class="container">
        <form action="{{ route('search', ['lang' => $langCode]) }}" method="GET">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" name="query" class="form-control" placeholder="Search" required>
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </form>
    </div>
</div>

@php
    $textClasses = ['text-left', 'text-center', 'text-right'];
@endphp

<div id="slides-shop" class="cover-slides">
    <ul class="slides-container">
        @foreach ($sliders as $index => $slider)
            @php
                $textClass = $textClasses[$index % 3];
            @endphp

            <li class="{{ $textClass }}">
                <img src="{{ $slider->getFirstMediaUrl('image') }}" loading="lazy" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-b-20"><strong>{{ $slider->title }}</strong></h1>
                            @php
                                $words = explode(' ', $slider->description);
                                $chunks = array_chunk($words, 12);
                            @endphp
                            <p class="m-b-40">
                                @foreach ($chunks as $line)
                                    {{ implode(' ', $line) }}<br>
                                @endforeach
                            </p>
                            <p><a class="btn hvr-hover" href="#">{{ __('buttons.shop_now') }}</a></p>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="slides-navigation">
        <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
</div>

<div class="categories-shop">
    <div class="container">
        <div class="row">
            @foreach (category() as $category)
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="shop-cat-box">
                        <img class="img-fluid" src="{{ $category->getFirstMediaUrl('image') }}" loading="lazy"
                            alt="" />
                        <a class="btn hvr-hover"
                            href="{{ route('category', ['lang' => $langCode, 'url_key' => $category->url_key]) }}">
                            {{ $category->name }}
                        </a>

                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="products-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>{{ __('buttons.featured_products') }}</h1>
                    <p>{{ __('buttons.featured_products_desc') }}</p>
                </div>
            </div>
        </div>
        <hr style="border-color: red">
        <div class="row">
            <div class="col-lg-12">
                <div class="special-menu text-center">
                    <div class="button-group filter-button-group">
                        <button class="active" data-filter="*">{{ __('buttons.all') }}</button>
                        <button data-filter=".top-featured">{{ __('buttons.top_featured') }}</button>
                        <button data-filter=".best-seller">{{ __('buttons.best_seller') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .sale {
                background: red;
                color: white;
                font-size: 12px;
                padding: 2px 6px;
                border-radius: 4px;
                display: inline-block;
            }
        </style>
        <div class="row special-list">
            @foreach (product() as $product)
                <div class="col-lg-3 col-md-6 special-grid best-seller">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <div class="type-lb">
                                @if ($product->special_price && $product->special_price < $product->price)
                                    @php
                                        $discount =
                                            (($product->price - $product->special_price) / $product->price) * 100;
                                    @endphp
                                    <p class="sale">{{ round($discount) }}% OFF</p>
                                @else
                                    <p class="sale">New</p>
                                @endif
                            </div>
                            <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}"><img
                                    src="{{ $product->getFirstMediaUrl('image') }}" loading="lazy" class="img-fluid"
                                    alt="Image"></a>
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i
                                                class="fas fa-eye"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right"
                                            title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                                            data-toggle="tooltip" data-placement="right" title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                    </li>
                                </ul>
                                <a class="cart"
                                    href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                    {{ __('buttons.Add to Cart') }}</a>
                            </div>
                        </div>
                        <div class="why-text">
                            <a class="cart"
                                href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                <h4>{{ $product->translated_name }}</h4>
                            </a>
                            @php
                                $now = \Carbon\Carbon::now();
                                $hasSpecialPrice =
                                    $product->special_price &&
                                    $product->special_price_from &&
                                    $product->special_price_to &&
                                    $now->between($product->special_price_from, $product->special_price_to);
                            @endphp

                            @if ($hasSpecialPrice)
                                <h5>
                                    <del style="color: #999;">
                                        {{ $symbol }} {{ number_format($product->price * $rate, 2) }}
                                    </del>
                                    <span class="text-danger ml-2">
                                        {{ $symbol }} {{ number_format($product->special_price * $rate, 2) }}
                                    </span>
                                </h5>
                            @else
                                <h5>{{ $symbol }} {{ number_format($product->price * $rate, 2) }}</h5>
                            @endif

                            {{-- @if ($product->special_price)
                        <h5>
                            <del style="color: #999;">
                                {{ $symbol }} {{ number_format($product->price * $rate, 2) }}
                            </del>
                            <span class="text-danger ml-2">
                                {{ $symbol }} {{ number_format($product->special_price * $rate, 2) }}
                            </span>
                        </h5>
                        @else
                        <h5>{{ $symbol }} {{ number_format($product->price * $rate, 2) }}</h5>
                        @endif --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .products-single .box-img-hover img {
                height: 250px;
                object-fit: cover;
                width: 100%;
            }
        </style>
    </div>
</div>

<style>
    .latest-blog .blog-box {
        display: flex !important;
        flex-direction: column !important;
        height: 450px !important;
        overflow: hidden !important;
        border: 1px solid #e8e8e8;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .latest-blog .blog-img {
        flex: 0 0 200px !important;
        overflow: hidden !important;
        position: relative;
    }
</style>

<div class="latest-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>{{ __('buttons.Latest Blog') }}</h1>

                    <p>{{ __('buttons.sample_text') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($blocks as $block)
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="blog-box">
                        <div class="blog-img">
                            <img class="img-fluid" src="{{ $block->getFirstMediaUrl('image') }}" loading="lazy"
                                alt="" />
                        </div>
                        <div class="blog-content">
                            <div class="title-blog">
                                <h3 style="text-align: center">{{ $block->name }}</h3>
                                <p>{{ $block->description }}</p>
                            </div>
                            {{-- <ul class="option-blog">
                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Likes"><i
                                        class="far fa-heart"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Views"><i
                                        class="fas fa-eye"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" data-placement="right" title="Comments"><i
                                        class="far fa-comments"></i></a></li>
                        </ul> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row my-5">
    <div class="col-lg-12">
        <div class="title-all text-center">
            <h1>{{ __('buttons.you_may_also_like') }}</h1>

            <p class="text-gray-600 mb-4">{{ __('buttons.you_may_also_like_desc') }}</p>
        </div>
        <div class="featured-products-box owl-carousel owl-theme">

            @foreach (product1() as $product)
                <div class="item">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <img src="{{ $product->getFirstMediaUrl('image') }}" class="img-fluid" loading="lazy"
                                alt="Image">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right"
                                            title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a href="{{ url()->current() }}" data-toggle="tooltip"
                                            data-placement="right" title="Compare"><i
                                                class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="{{ route('wishlist.add', ['lang' => $langCode, 'id' => $product->id]) }}"
                                            data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i
                                                class="far fa-heart"></i></a>
                                    </li>
                                </ul>
                                <a class="cart"
                                    href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                    {{ __('buttons.Add to Cart') }}
                                </a>
                            </div>
                        </div>
                        <div class="why-text">
                            {{-- <h4>{{ $product->name }}</h4> --}}
                            <a class="cart"
                                href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">
                                <h4>{{ $product->translated_name }}</h4>
                            </a>
                            @php
                                $now = \Carbon\Carbon::now();
                                $hasSpecialPrice =
                                    $product->special_price &&
                                    $product->special_price_from &&
                                    $product->special_price_to &&
                                    $now->between($product->special_price_from, $product->special_price_to);
                            @endphp


                            @if ($hasSpecialPrice)
                                <h5>
                                    <del style="color: #999;">
                                        {{ $symbol }} {{ number_format($product->price * $rate, 2) }}
                                    </del>
                                    <span class="text-danger ml-2">
                                        {{ $symbol }} {{ number_format($product->special_price * $rate, 2) }}
                                    </span>
                                </h5>
                            @else
                                <h5>{{ $symbol }} {{ number_format($product->price * $rate, 2) }}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@include('includes.footer')
