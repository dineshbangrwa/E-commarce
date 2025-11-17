@php
    $title = 'Zopify Login';
    $langCode = session('language_code', app()->getLocale());

@endphp
@include('includes.header')

<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Login</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lang.index', ['lang' => $langCode]) }}">Home</a></li>
                    <li class="breadcrumb-item active">Login</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="shop-box-inner">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h3 class="text-center mb-4">Login to Your Account</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('custom.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                required autofocus>
                        </div>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <div class="form-group form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <button type="submit" class="btn hvr-hover w-100 text-white mb-3">Login</button>
                    </form>

                    <div class="text-center mb-3">
                        <hr>
                        <span>Or</span>
                        <hr>
                    </div>


                    <a href="{{ route('login.google') }}"
                        class="btn btn-primary w-100 mb-2 d-flex align-items-center justify-content-center">
                        <i class="fab fa-facebook-f mr-2"></i> Login with Facebook
                    </a>


                    <a href="{{ route('login.google') }}"
                        class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center">
                        <img src="https://developers.google.com/identity/images/g-logo.png" loading="lazy"
                            style="width:20px; margin-right:10px;">
                        <span>Login with Google</span>
                    </a>

                    <div class="text-center mt-3">
                        <a href="#">Forgot your password?</a><br>
                        <a href="{{ route('register', ['lang' => $langCode]) }}">Don't have an account? Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
