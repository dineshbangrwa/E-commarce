@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
@endphp
<div class="fixed top-0 left-0 right-0 z-50 glass border-b border-[rgba(255,255,255,0.06)]">
    <div class="hidden lg:block border-b border-[rgba(255,255,255,0.04)] bg-[rgba(15,15,26,0.9)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-9">
                <div class="flex items-center gap-6 text-xs text-[#9CA3AF]">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-truck text-[#8B5CF6] text-[10px]"></i>
                        Free Shipping on Orders Above ₹499
                    </span>
                    <span class="hidden md:flex items-center gap-1.5">
                        <i class="fas fa-headset text-[#8B5CF6] text-[10px]"></i>
                        24/7 Customer Support
                    </span>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <form id="currency-change-form" action="{{ route('currency.change') }}" method="POST" class="inline">
                        @csrf
                        <select name="currency_code" onchange="this.form.submit()"
                            class="bg-transparent text-[#9CA3AF] border border-[rgba(255,255,255,0.08)] rounded-md px-2 py-1 text-xs outline-none focus:border-[#6C3BF1] cursor-pointer">
                            @foreach (App\Models\Currency::all() as $currency)
                                <option value="{{ $currency->code }}" {{ session('currency_code') == $currency->code ? 'selected' : '' }}
                                    class="bg-[#1A1A2E] text-[#F1F1F6]">
                                    {{ $currency->symbol }} {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <form id="language-change-form"
                        action="{{ route('language.change', ['lang' => session('language_code', app()->getLocale())]) }}"
                        method="POST" class="inline">
                        @csrf
                        <select name="lang" onchange="this.form.submit()"
                            class="bg-transparent text-[#9CA3AF] border border-[rgba(255,255,255,0.08)] rounded-md px-2 py-1 text-xs outline-none focus:border-[#6C3BF1] cursor-pointer">
                            @foreach (App\Models\Language::all() as $language)
                                <option value="{{ $language->code }}"
                                    {{ session('language_code', app()->getLocale()) == $language->code ? 'selected' : '' }}
                                    class="bg-[#1A1A2E] text-[#F1F1F6]">
                                    {{ $language->language }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <a href="tel:+11900800100" class="text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors hidden sm:inline">
                        <i class="fas fa-phone-alt mr-1"></i> +11 900 800 100
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="flex items-center gap-8">
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-[#F1F1F6] hover:text-[#8B5CF6] transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="flex items-center gap-2">
                    <img src="{{ asset('front/images/logo.png') }}?v={{ time() }}" alt="Zopify" class="h-8 lg:h-10 brightness-0 invert">
                </a>
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('lang.index', ['lang' => $langCode]) }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('index') ? 'text-white bg-[rgba(108,59,241,0.15)]' : 'text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]' }}">
                        {{ __('buttons.home') }}
                    </a>
                    @foreach (page() as $page)
                        <a href="{{ route('page', ['lang' => $langCode, 'url_key' => $page->url_key]) }}"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 {{ request()->is('page/' . $page->url_key) ? 'text-white bg-[rgba(108,59,241,0.15)]' : 'text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]' }}">
                            {{ $page->name }}
                        </a>
                    @endforeach
                    <div class="relative group">
                        <button class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)] flex items-center gap-1">
                            {{ __('buttons.categories') }}
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-[600px] glass rounded-2xl border border-[rgba(255,255,255,0.08)] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 shadow-2xl p-6">
                            <div class="grid grid-cols-3 gap-4">
                                @foreach (category1() as $category)
                                    @php $subcategories = subcategory($category->id); @endphp
                                    <div>
                                        <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $category->url_key]) }}"
                                            class="text-sm font-semibold text-white hover:text-[#8B5CF6] transition-colors">
                                            {{ $category->name }}
                                        </a>
                                        @if ($subcategories->count() > 0)
                                            <ul class="mt-2 space-y-1">
                                                @foreach ($subcategories as $subcategory)
                                                    <li>
                                                        <a href="{{ route('category', ['lang' => $langCode, 'url_key' => $subcategory->url_key]) }}"
                                                            class="text-xs text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">
                                                            {{ $subcategory->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('contact', ['lang' => $langCode]) }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('contact') ? 'text-white bg-[rgba(108,59,241,0.15)]' : 'text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)]' }}">
                        {{ __('buttons.contact_us') }}
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-2 lg:gap-4">
                <button onclick="document.getElementById('search-modal').classList.remove('hidden')"
                    class="w-9 h-9 flex items-center justify-center rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.08)] transition-all">
                    <i class="fas fa-search"></i>
                </button>
                @if (Auth::check())
                    <a href="{{ route('profile', ['lang' => $langCode]) }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.08)] transition-all">
                        <i class="fas fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.08)] transition-all">
                        <i class="fas fa-user"></i>
                    </a>
                @endif
                @if (Auth::user())
                    <a href="{{ route('wishlist.index', ['lang' => $langCode]) }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.08)] transition-all relative">
                        <i class="fas fa-heart"></i>
                        @if (isset($wishlistCount) && $wishlistCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-[#EF4444] text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cart', ['lang' => $langCode]) }}"
                        class="w-9 h-9 flex items-center justify-center rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.08)] transition-all relative">
                        <i class="fas fa-shopping-bag"></i>
                        @if (isset($cartCount) && $cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-[#6C3BF1] text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div id="search-modal" class="hidden fixed inset-0 z-[60] flex items-start justify-center pt-20 lg:pt-32 px-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('search-modal').classList.add('hidden')"></div>
        <div class="relative w-full max-w-2xl glass rounded-2xl border border-[rgba(255,255,255,0.08)] p-6 shadow-2xl animate__animated animate__fadeInDown">
            <form action="{{ route('search', ['lang' => $langCode]) }}" method="GET" class="flex items-center gap-3">
                <i class="fas fa-search text-[#9CA3AF]"></i>
                <input type="text" name="query" placeholder="Search products..." required
                    class="flex-1 bg-transparent border-none outline-none text-[#F1F1F6] text-base placeholder-[#6B7280]">
                <button type="submit" class="btn-primary text-sm py-2 px-4">Search</button>
                <button type="button" onclick="document.getElementById('search-modal').classList.add('hidden')"
                    class="text-[#9CA3AF] hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>

    @include('includes.notification')
</div>
