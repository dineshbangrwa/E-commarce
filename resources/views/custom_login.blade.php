@php
    $title = 'Zopify Login';
@endphp
@extends('layouts.app')

@section('content')
@php
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="pt-24 pb-12">
    <div class="max-w-md mx-auto px-4">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('lang.index', ['lang' => $langCode]) }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">Login</span>
        </div>

        <div class="glass rounded-2xl p-8 border border-[rgba(255,255,255,0.08)]">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                <p class="text-sm text-[#9CA3AF] mt-1">Sign in to your account</p>
            </div>

            <form action="{{ route('custom.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Email Address</label>
                    <input type="email" name="email" required placeholder="you@example.com" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Enter your password" class="input-field">
                </div>
                <button type="submit" class="btn-primary w-full justify-center">
                    Sign In <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <p class="text-center text-sm text-[#9CA3AF] mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#8B5CF6] hover:text-white transition-colors font-medium">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection
