@php
    $title = 'Register at Zopify';
@endphp
@extends('layouts.app')

@section('content')
@php
    $langCode = session('language_code', app()->getLocale());
@endphp
<div class="pt-24 pb-12">
    <div class="max-w-md mx-auto px-4">
        <div class="glass rounded-2xl p-8 border border-[rgba(255,255,255,0.08)]">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-sm text-[#9CA3AF] mt-1">Join Zopify today</p>
            </div>
            <form action="{{ route('adminregister.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe"
                        class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Email Address</label>
                    <input type="email" name="email" required placeholder="you@example.com"
                        class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Phone Number</label>
                    <input type="tel" name="phone" required placeholder="+1 234 567 890"
                        class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Create a strong password"
                        class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm your password"
                        class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Profile Image</label>
                    <input type="file" name="image"
                        class="input-field file:text-[#9CA3AF] file:bg-[rgba(255,255,255,0.05)] file:border-0 file:rounded-lg file:px-3 file:py-1.5 file:text-sm file:text-[#F1F1F6] file:mr-3 file:cursor-pointer">
                </div>
                <button type="submit" class="btn-primary w-full justify-center">
                    Create Account <i class="fas fa-user-plus"></i>
                </button>
            </form>
            <p class="text-center text-sm text-[#9CA3AF] mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#8B5CF6] hover:text-white transition-colors font-medium">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection
