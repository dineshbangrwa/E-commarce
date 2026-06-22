@php
    $title = 'Checkout';
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
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('cart', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('cart') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">{{ __('checkout') }}</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">{{ __('checkout') }}</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    @if (!Auth::check())
                    <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)]">
                        <h3 class="text-white font-semibold mb-4">{{ __('account login') }}</h3>
                        <a href="#formLogin" data-toggle="collapse" class="text-sm text-[#8B5CF6] hover:text-white transition-colors">{{ __('click login') }}</a>
                        <div class="collapse mt-4" id="formLogin">
                            <form action="{{ route('custom.post') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="email" name="email" placeholder="Email" class="input-field" required>
                                <input type="password" name="password" placeholder="Password" class="input-field" required>
                                <button type="submit" class="btn-primary text-sm py-2">Login</button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)]">
                        <h3 class="text-white font-semibold mb-4">{{ __('billing_details') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('first_name') }} *</label>
                                <input type="text" name="firstname" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('last_name') }} *</label>
                                <input type="text" name="lastname" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('email') }} *</label>
                                <input type="email" name="email" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('phone') }} *</label>
                                <input type="tel" name="phone" class="input-field" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('address') }} *</label>
                                <input type="text" name="address" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('country') }} *</label>
                                <select name="country" class="input-field">
                                    <option value="India" class="bg-[#1A1A2E]">India</option>
                                    <option value="USA" class="bg-[#1A1A2E]">USA</option>
                                    <option value="UK" class="bg-[#1A1A2E]">UK</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('postcode') }} *</label>
                                <input type="text" name="postcode" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('city') }} *</label>
                                <input type="text" name="city" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">{{ __('state') }} *</label>
                                <input type="text" name="state" class="input-field" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] sticky top-24">
                        <h3 class="text-white font-semibold text-lg mb-4">{{ __('your_order') }}</h3>
                        @if (quote() && quote()->quoteItems && quote()->quoteItems->count() > 0)
                            @php $subtotal = quote()->quoteItems->sum(function ($item) use ($rate) { return $item->price * $item->qty * $rate; }); @endphp
                            <div class="space-y-3 mb-6">
                                @foreach (quote()->quoteItems as $item)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->product->getFirstMediaUrl('image') }}" class="w-12 h-12 rounded-lg object-cover">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-white truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-[#9CA3AF]">Qty: {{ $item->qty }}</p>
                                        </div>
                                        <span class="text-sm text-white">{{ $symbol }}{{ number_format($item->price * $item->qty * $rate, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-[rgba(255,255,255,0.06)] pt-4 space-y-2 text-sm">
                                <div class="flex justify-between text-[#9CA3AF]">
                                    <span>{{ __('sub_total') }}</span>
                                    <span>{{ $symbol }}{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-[#9CA3AF]">
                                    <span>Shipping</span>
                                    <span class="text-[#10B981]">Free</span>
                                </div>
                                <div class="border-t border-[rgba(255,255,255,0.06)] pt-2 flex justify-between text-white font-semibold">
                                    <span>{{ __('total') }}</span>
                                    <span class="text-lg">{{ $symbol }}{{ number_format($subtotal, 2) }}</span>
                                </div>
                            </div>
                            <div class="mt-6 space-y-3">
                                <button type="submit" class="btn-primary w-full justify-center">
                                    <i class="fas fa-lock"></i> {{ __('place_order') }}
                                </button>
                                <p class="text-xs text-center text-[#6B7280]">
                                    <i class="fas fa-shield-alt mr-1"></i> Your payment is secure and encrypted
                                </p>
                            </div>
                        @else
                            <p class="text-sm text-[#9CA3AF] text-center py-6">{{ __('your_cart_is_empty') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
