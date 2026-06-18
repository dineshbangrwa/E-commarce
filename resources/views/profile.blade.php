@php
    $title = 'My Account';
@endphp
@extends('layouts.app')

@section('content')
@php
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">My Account</span>
        </div>

        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-8">My Account</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1">
                <div class="glass rounded-2xl p-6 border border-[rgba(255,255,255,0.06)] sticky top-24">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 rounded-full glass flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user text-2xl text-[#8B5CF6]"></i>
                        </div>
                        <h3 class="text-white font-semibold">{{ Auth::user()->name ?? 'User' }}</h3>
                        <p class="text-xs text-[#9CA3AF]">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('profile', ['lang' => $langCode]) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg bg-[rgba(108,59,241,0.15)] text-white">
                            <i class="fas fa-user text-[#8B5CF6]"></i> Profile
                        </a>
                        <a href="{{ route('order.index', ['lang' => $langCode]) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)] transition-all">
                            <i class="fas fa-box"></i> Orders
                        </a>
                        <a href="{{ route('wishlist.index', ['lang' => $langCode]) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg text-[#9CA3AF] hover:text-white hover:bg-[rgba(255,255,255,0.05)] transition-all">
                            <i class="fas fa-heart"></i> Wishlist
                        </a>
                        <a href="{{ route('logout', ['lang' => $langCode]) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg text-[#EF4444] hover:bg-[#EF4444]/10 transition-all">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>

            <div class="lg:col-span-3">
                <div class="glass rounded-2xl p-6 lg:p-8 border border-[rgba(255,255,255,0.06)]">
                    <h3 class="text-white font-semibold text-lg mb-6">Profile Information</h3>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">First Name</label>
                                <input type="text" name="first_name" value="{{ Auth::user()->first_name ?? old('first_name') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Last Name</label>
                                <input type="text" name="last_name" value="{{ Auth::user()->last_name ?? old('last_name') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email ?? old('email') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Phone</label>
                                <input type="tel" name="phone" value="{{ Auth::user()->phone ?? old('phone') }}" class="input-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Address</label>
                                <input type="text" name="address" value="{{ Auth::user()->address ?? old('address') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">City</label>
                                <input type="text" name="city" value="{{ Auth::user()->city ?? old('city') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">State</label>
                                <input type="text" name="state" value="{{ Auth::user()->state ?? old('state') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Postcode</label>
                                <input type="text" name="postcode" value="{{ Auth::user()->postcode ?? old('postcode') }}" class="input-field">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Country</label>
                                <input type="text" name="country" value="{{ Auth::user()->country ?? old('country') }}" class="input-field">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Profile Image</label>
                                <input type="file" name="image" class="input-field file:text-[#9CA3AF] file:bg-[rgba(255,255,255,0.05)] file:border-0 file:rounded-lg file:px-3 file:py-1.5 file:text-sm file:text-[#F1F1F6]">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
