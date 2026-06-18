@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
    $pageTitle = $title ?? ($page->name ?? 'Ecommerce');
    $metaDescription = $meta_description ?? ($page->meta_description ?? 'Default zopify description');
    $metaKeywords = $meta_keywords ?? ($page->meta_tag ?? 'ecommerce');
@endphp
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="author" content="">
    <title>{{ $pageTitle }}</title>
    <link rel="shortcut icon" href="{{ asset('front/images/favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('front/images/apple-touch-icon.png') }}?v={{ time() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}?v={{ time() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0F0F1A] text-[#F1F1F6] antialiased">
<div class="main-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-slid-box">
                    <div id="offer-box" class="carouselTicker">
                        <ul class="offer-box">
                            <li><i class="fab fa-opencart"></i> Off Shop Now Man</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="custom-select-box">
                    <form id="currency-change-form" action="{{ route('currency.change') }}" method="POST">
                        @csrf
                        <select name="currency_code" onchange="document.getElementById('currency-change-form').submit();"
                            class="selectpicker show-tick form-control">
                            @foreach (App\Models\Currency::all() as $currency)
                                <option value="{{ $currency->code }}" {{ session('currency_code') == $currency->code ? 'selected' : '' }}>
                                    {{ $currency->symbol }} {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="custom-select-box">
                    <form id="language-change-form" action="{{ route('language.change', ['lang' => session('language_code', app()->getLocale())]) }}" method="POST">
                        @csrf
                        <select name="lang" onchange="document.getElementById('language-change-form').submit();"
                            class="selectpicker show-tick form-control">
                            @foreach (App\Models\Language::all() as $language)
                                <option value="{{ $language->code }}" {{ session('language_code', app()->getLocale()) == $language->code ? 'selected' : '' }}>
                                    {{ $language->language }} ({{ $language->code }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="right-phone-box">
                    <p>Call US :- <a href=""> +11 900 800 100</a></p>
                </div>
                <div class="our-link">
                    <ul>
                        @if (Auth::check())
                            <li><a href="{{ route('logout', ['lang' => session('language_code', app()->getLocale())]) }}">Logout</a></li>
                        @else
                            <li><a href="{{ route('login', ['lang' => session('language_code', app()->getLocale())]) }}">Login</a></li>
                        @endif
                        <li><a href="#">Our location</a></li>
                        <li><a href="{{ route('contact', ['lang' => session('language_code', app()->getLocale())]) }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('includes.notification')
</div>
<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu"
                    aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('lang.index', ['lang' => $langCode]) }}">
                    <img src="{{ asset('front/images/logo.png') }}?v={{ time() }}" class="logo" loading="lazy" alt="">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('lang.index', ['lang' => $langCode]) }}">{{ __('buttons.home') }}</a>
                    </li>
                    @foreach (page() as $page)
                        <li class="nav-item {{ request()->is('page/' . $page->url_key) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('page', ['lang' => $langCode, 'url_key' => $page->url_key]) }}">{{ $page->name }}</a>
                        </li>
                    @endforeach
                    <li class="dropdown megamenu-fw">
                        <a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">{{ __('buttons.categories') }}</a>
                        <ul class="dropdown-menu megamenu-content" role="menu">
                            <li>
                                <div class="row">
                                    @foreach (category1() as $category)
                                        @php $subcategories = subcategory($category->id); $active = request()->is('category/' . $category->url_key); foreach ($subcategories as $subcat) { if (request()->is('category/' . $subcat->url_key)) { $active = true; break; } } @endphp
                                        <div class="col-menu col-md-3 {{ $active ? 'active' : '' }}">
                                            <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $category->url_key]) }}"><h6 class="title">{{ $category->name }}</h6></a>
                                            <div class="content">
                                                @if ($subcategories->count() > 0)
                                                    <ul class="menu-col">
                                                        @foreach ($subcategories as $subcategory)
                                                            <li><a href="{{ route('category', ['lang' => $langCode, 'url_key' => $subcategory->url_key]) }}">{{ $subcategory->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('contact', ['lang' => $langCode]) }}">{{ __('buttons.contact_us') }}</a>
                    </li>
                </ul>
            </div>
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                    <li>@if (Auth::check())<a href="{{ route('profile', ['lang' => session('language_code', app()->getLocale())]) }}"><i class="fa fa-user"></i></a>@else<a href="{{ route('login') }}"><i class="fa fa-user"></i></a>@endif</li>
                    @if (Auth::user())
                        <li><a href="{{ route('wishlist.index', ['lang' => session('language_code', app()->getLocale())]) }}"><i class="fa fa-heart"></i>@if (isset($wishlistCount) && $wishlistCount > 0)<span class="badge">{{ $wishlistCount }}</span>@endif</a></li>
                        <li class="side-menu"><a href="{{ route('cart', ['lang' => session('language_code', app()->getLocale())]) }}"><i class="fa fa-shopping-bag"></i>@if (isset($cartCount) && $cartCount > 0)<span class="badge">{{ $cartCount }}</span>@endif</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="side">
            <a href="#" class="close-side"><i class="fa fa-times"></i></a>
            <li class="cart-box">
                <ul class="cart-list">
                    @if (quote() && quote()->quoteItems && quote()->quoteItems->count() > 0)
                        @foreach (quote()->quoteItems as $item)
                            <li>
                                <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}" class="photo"><img src="{{ $item->product->getFirstMediaUrl('image') }}?v={{ time() }}" loading="lazy" class="cart-thumb" alt="" /></a>
                                <h6><a href="{{ route('product.detail', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}">{{ $item->product->name }}</a></h6>
                                <p>{{ $item->qty }}x - <span class="price">{{ $symbol }}{{ number_format($item->price * $rate, 2) }}</span></p>
                            </li>
                        @endforeach
                        <li class="total">
                            <a href="{{ route('cart', ['lang' => $langCode]) }}" class="btn btn-default hvr-hover btn-cart">{{ __('buttons.view_cart') }}</a>
                            @php $cartTotal = quote()->quoteItems->sum(function ($item) use ($rate) { return $item->price * $item->qty * $rate; }); @endphp
                            <span class="float-right"><strong>Total</strong>:{{ $symbol }}{{ number_format($cartTotal, 2) }}</span>
                        </li>
                    @else
                        <tr><td colspan="5" class="text-center">No items in your cart</td></tr>
                    @endif
                </ul>
            </li>
        </div>
    </nav>
</header>
