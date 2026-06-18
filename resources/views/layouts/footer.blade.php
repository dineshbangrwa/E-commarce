<footer class="mt-20 border-t border-[rgba(255,255,255,0.06)] bg-[rgba(15,15,26,0.8)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <img src="{{ asset('front/images/logo.png') }}?v={{ time() }}" alt="Zopify" class="h-8 brightness-0 invert mb-4">
                <p class="text-sm text-[#9CA3AF] leading-relaxed">{{ __('buttons.about_zupify_desc') }}</p>
                <div class="flex items-center gap-3 mt-6">
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg glass text-[#9CA3AF] hover:text-[#8B5CF6] hover:border-[#8B5CF6] transition-all text-sm"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg glass text-[#9CA3AF] hover:text-[#8B5CF6] hover:border-[#8B5CF6] transition-all text-sm"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg glass text-[#9CA3AF] hover:text-[#8B5CF6] hover:border-[#8B5CF6] transition-all text-sm"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg glass text-[#9CA3AF] hover:text-[#8B5CF6] hover:border-[#8B5CF6] transition-all text-sm"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-lg glass text-[#9CA3AF] hover:text-[#8B5CF6] hover:border-[#8B5CF6] transition-all text-sm"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ __('buttons.our_pages') }}</h4>
                <ul class="space-y-3">
                    @foreach (page() as $page)
                        <li>
                            <a href="{{ route('page', ['lang' => session('language_code', app()->getLocale()), 'url_key' => $page->url_key]) }}"
                                class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">
                                {{ $page->name }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('contact', ['lang' => session('language_code', app()->getLocale())]) }}"
                            class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">
                            {{ __('buttons.contact_us') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('lang.index', ['lang' => session('language_code', app()->getLocale())]) }}" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">{{ __('buttons.home') }}</a></li>
                    <li><a href="#" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact', ['lang' => session('language_code', app()->getLocale())]) }}" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">Contact</a></li>
                    @if (!Auth::check())
                        <li><a href="{{ route('login') }}" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">Register</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ __('buttons.contact_us') }}</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-sm text-[#9CA3AF]">
                        <i class="fas fa-map-marker-alt text-[#8B5CF6] mt-1"></i>
                        <span>Michael I. Days 3756 Preston Street Wichita, KS 67213</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <i class="fas fa-phone-alt text-[#8B5CF6]"></i>
                        <a href="tel:+1-888705770" class="text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">+1-888 705 770</a>
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <i class="fas fa-envelope text-[#8B5CF6]"></i>
                        <a href="mailto:contactinfo@gmail.com" class="text-[#9CA3AF] hover:text-[#8B5CF6] transition-colors">contactinfo@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-12 pt-6 border-t border-[rgba(255,255,255,0.06)] text-center">
            <p class="text-xs text-[#6B7280]">&copy; {{ date('Y') }} Zopify. All rights reserved.</p>
        </div>
    </div>
</footer>
