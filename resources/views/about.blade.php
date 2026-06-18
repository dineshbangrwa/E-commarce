@php
    $title = $page->name . ' - Zopify';
    $meta_description = $page->meta_description ?? 'Zopify - ' . $page->name;
    $meta_keywords = $page->meta_tag ?? 'zopify, ' . $page->name;
@endphp
@extends('layouts.app')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-[#9CA3AF] mb-6">
            <a href="{{ route('index') }}" class="hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-[#F1F1F6]">{{ $page->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div>
                <h1 class="text-2xl lg:text-4xl font-bold text-white mb-4">{{ $page->meta_title ?? $page->name }}</h1>
                <div class="prose prose-invert text-sm text-[#9CA3AF] leading-relaxed space-y-4">
                    <p>{{ $page->description }}</p>
                    @if ($page->meta_description)
                        <p>{{ $page->meta_description }}</p>
                    @endif
                </div>
            </div>
            @if ($page->getFirstMediaUrl('image'))
                <div class="glass rounded-2xl p-2 border border-[rgba(255,255,255,0.06)]">
                    <img src="{{ $page->getFirstMediaUrl('image') }}" alt="{{ $page->name }}" class="w-full rounded-xl">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
