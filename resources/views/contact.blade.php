@php
    $title = __('buttons.contact_us');
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
            <span class="text-[#F1F1F6]">{{ __('buttons.contact_us') }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-4">{{ __('buttons.get_in_touch') }}</h1>
                <p class="text-sm text-[#9CA3AF] leading-relaxed mb-8">{{ __('buttons.contact_us_desc') ?? 'Have questions? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.' }}</p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl glass flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-[#8B5CF6]"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-medium text-sm">Address</h4>
                            <p class="text-sm text-[#9CA3AF] mt-1">Michael I. Days 3756 Preston Street Wichita, KS 67213</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl glass flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-[#8B5CF6]"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-medium text-sm">Phone</h4>
                            <a href="tel:+1-888705770" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors mt-1 block">+1-888 705 770</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl glass flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-[#8B5CF6]"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-medium text-sm">Email</h4>
                            <a href="mailto:contactinfo@gmail.com" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors mt-1 block">contactinfo@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="glass rounded-2xl p-6 lg:p-8 border border-[rgba(255,255,255,0.06)]">
                    <h3 class="text-white font-semibold text-lg mb-6">Send Us a Message</h3>
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Name</label>
                                <input type="text" name="name" required class="input-field" placeholder="Your name">
                            </div>
                            <div>
                                <label class="block text-sm text-[#9CA3AF] mb-1.5">Email</label>
                                <input type="email" name="email" required class="input-field" placeholder="your@email.com">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-[#9CA3AF] mb-1.5">Subject</label>
                            <input type="text" name="subject" required class="input-field" placeholder="How can we help?">
                        </div>
                        <div>
                            <label class="block text-sm text-[#9CA3AF] mb-1.5">Message</label>
                            <textarea name="message" rows="5" required class="input-field resize-none" placeholder="Tell us more..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
