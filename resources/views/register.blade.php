@php
    $title = 'Register at Zopify';
    $langCode = session('language_code', app()->getLocale());

@endphp
@include('includes.header')
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Register</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lang.index', ['lang' => $langCode]) }}">Home</a></li>
                    <li class="breadcrumb-item active">Register</li>
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
                    <h3 class="text-center mb-4">Create Your Account</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <button type="submit" class="btn hvr-hover w-100 text-white">Register</button>
                    </form>

                    <div class="text-center mt-3">
                        Already have an account?
                        <a href="{{ route('login',['lang' => $langCode]) }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
