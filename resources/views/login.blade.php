<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zopify - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0F0F1A] min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-[#6C3BF1]/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-[#8B5CF6]/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#6C3BF1]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <div class="glass rounded-2xl p-8 border border-[rgba(255,255,255,0.08)] shadow-2xl">
            <div class="text-center mb-8">
                <a href="{{ route('lang.index', ['lang' => session('language_code', app()->getLocale())]) }}" class="inline-block mb-4">
                    <img src="{{ asset('front/images/logo.png') }}?v={{ time() }}" alt="Zopify" class="h-8 brightness-0 invert mx-auto">
                </a>
                <h1 class="text-xl font-bold text-white">Welcome Back</h1>
                <p class="text-sm text-[#9CA3AF] mt-1">Sign in to your account</p>
            </div>

            <form id="login-form" action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-[#6B7280] text-sm"></i>
                        <input type="email" name="email" required placeholder="you@example.com"
                            class="input-field pl-10">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#9CA3AF] mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-[#6B7280] text-sm"></i>
                        <input id="password-input" type="password" name="password" required placeholder="Enter your password"
                            class="input-field pl-10 pr-10">
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#6B7280] hover:text-[#9CA3AF] transition-colors">
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-[rgba(255,255,255,0.1)] bg-[rgba(255,255,255,0.05)] text-[#6C3BF1] focus:ring-[#6C3BF1]">
                        <span class="text-sm text-[#9CA3AF]">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-[#8B5CF6] hover:text-white transition-colors">Forgot password?</a>
                </div>
                <button type="submit" class="btn-primary w-full justify-center">
                    Sign In <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-[rgba(255,255,255,0.06)]"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-[#1A1A2E] px-4 text-[#6B7280]">or continue with</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl glass text-sm text-[#9CA3AF] hover:text-white hover:border-[rgba(255,255,255,0.15)] transition-all border border-[rgba(255,255,255,0.06)]">
                    <i class="fab fa-google"></i> Google
                </button>
                <button class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl glass text-sm text-[#9CA3AF] hover:text-white hover:border-[rgba(255,255,255,0.15)] transition-all border border-[rgba(255,255,255,0.06)]">
                    <i class="fab fa-github"></i> GitHub
                </button>
            </div>

            <p class="text-center text-sm text-[#9CA3AF] mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#8B5CF6] hover:text-white transition-colors font-medium">Create one</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
