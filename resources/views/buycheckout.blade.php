@php
    $title = 'Checkout';
@endphp
@extends('layouts.app')

@section('content')
@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
    $subtotal = $product->price * $qty;
    $discount = session('coupon_discount', 0);
    $coupon = session('coupon', null);
    $grandTotal = $subtotal - $discount;
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">{{ __('buttons.checkout') }}</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">{{ __('buttons.checkout') }}</h1>

        <form id="checkout-form" method="POST" action="">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="qty" value="{{ $qty }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass rounded-2xl p-6 lg:p-8 border border-[rgba(255,255,255,0.06)]">
                        <h3 class="text-white font-semibold text-lg mb-6">{{ __('buttons.billing_address') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                                @error('name') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Phone *</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="input-field" required>
                                @error('phone') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="input-field" required>
                                @error('email') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Address *</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="input-field" required>
                                @error('address') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Country *</label>
                                <select name="country" class="input-field">
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="india" {{ old('country') == 'india' ? 'selected' : '' }}>India</option>
                                    <option value="usa" {{ old('country') == 'usa' ? 'selected' : '' }}>USA</option>
                                </select>
                                @error('country') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">State *</label>
                                <select name="state" class="input-field">
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="rajsthan" {{ old('state') == 'rajsthan' ? 'selected' : '' }}>Rajasthan</option>
                                    <option value="gujrat" {{ old('state') == 'gujrat' ? 'selected' : '' }}>Gujarat</option>
                                </select>
                                @error('state') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">City *</label>
                                <select name="city" class="input-field">
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="jaipur" {{ old('city') == 'jaipur' ? 'selected' : '' }}>Jaipur</option>
                                    <option value="bikaner" {{ old('city') == 'bikaner' ? 'selected' : '' }}>Bikaner</option>
                                </select>
                                @error('city') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Zip *</label>
                                <input type="text" name="pin_code" value="{{ old('pin_code') }}" class="input-field" required>
                                @error('pin_code') <p class="text-xs text-[#EF4444] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-white mb-3">{{ __('buttons.payment_method') }}</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 rounded-xl glass border border-[rgba(255,255,255,0.06)] cursor-pointer hover:border-[#6C3BF1]/30 transition-all">
                                    <input type="radio" name="payment_method" value="stripe" checked class="text-[#6C3BF1] focus:ring-[#6C3BF1]">
                                    <span class="text-sm text-[#F1F1F6]">{{ __('buttons.payment_method_stripe') }}</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-xl glass border border-[rgba(255,255,255,0.06)] cursor-pointer hover:border-[#6C3BF1]/30 transition-all">
                                    <input type="radio" name="payment_method" value="cod" class="text-[#6C3BF1] focus:ring-[#6C3BF1]">
                                    <span class="text-sm text-[#F1F1F6]">{{ __('buttons.payment_method_cod') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] sticky top-24">
                        <h3 class="text-white font-semibold text-lg mb-4">{{ __('buttons.your_order') }}</h3>
                        <div class="flex items-center gap-3 pb-4 border-b border-[rgba(255,255,255,0.06)]">
                            <img src="{{ $product->getFirstMediaUrl('image') }}" class="w-16 h-16 rounded-xl object-cover">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('product', ['lang' => $langCode, 'url_key' => $product->url_key]) }}" class="text-sm text-white hover:text-[#8B5CF6] transition-colors truncate block">{{ $product->name }}</a>
                                <p class="text-xs text-[#9CA3AF]">Qty: {{ $qty }}</p>
                                <p class="text-sm font-medium text-white mt-1">{{ $symbol }}{{ number_format($product->price * $rate, 2) }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 pt-4 text-sm">
                            <div class="flex justify-between text-[#9CA3AF]">
                                <span>{{ __('buttons.sub_total') }}</span>
                                <span>{{ $symbol }}{{ number_format($subtotal * $rate, 2) }}</span>
                            </div>
                            @if ($coupon)
                            <div class="flex justify-between text-[#9CA3AF]">
                                <span>{{ __('buttons.discount') }} ({{ $coupon }})</span>
                                <span class="text-[#10B981]">-{{ $symbol }}{{ number_format($discount * $rate, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-[#9CA3AF]">
                                <span>{{ __('buttons.shipping_cost') }}</span>
                                <span class="text-[#10B981]">Free</span>
                            </div>
                            <div class="border-t border-[rgba(255,255,255,0.06)] pt-2 flex justify-between text-white font-semibold">
                                <span>{{ __('buttons.grand_total') }}</span>
                                <span class="text-lg">{{ $symbol }}{{ number_format($grandTotal * $rate, 2) }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('apply.coupon', ['lang' => $langCode]) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="{{ $qty }}">
                                <input type="text" name="coupon" placeholder="Coupon Code" class="input-field text-sm flex-1">
                                <button type="submit" class="btn-secondary text-sm py-2 px-4 whitespace-nowrap">{{ __('buttons.apply_coupon') }}</button>
                            </form>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center mt-6">
                            <i class="fas fa-lock"></i> {{ __('buttons.place_order') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        if (selectedMethod === 'stripe') {
            this.action = "{{ route('stripe.buy') }}";
        } else {
            this.action = "{{ route('checkout.buy') }}";
        }
    });
</script>
@endpush
@endsection
