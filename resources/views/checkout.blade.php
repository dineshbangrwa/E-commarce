@php
    $title = 'Checkout';

@endphp
@include('includes.header')

@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="top-search">
    <div class="container">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search">
            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
        </div>
    </div>
</div>

<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ __('buttons.checkout') }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('lang.index', ['lang' => $langCode]) }}">{{ __('buttons.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('buttons.checkout') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="cart-box-main">
    <div class="container">
        <div class="row new-account-login">
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="title-left">
                    <h3>{{ __('buttons.account_login_title') }}</h3>
                </div>
                <h5><a data-toggle="collapse" href="#formLogin" role="button" aria-expanded="false">
                        {{ __('buttons.click_here_login') }}</a></h5>
                <form class="mt-3 collapse review-form-box" id="formLogin" action="{{ route('custom.post') }}"
                    method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="InputEmail" class="mb-0">Email Address *</label>
                            <input type="email" class="form-control" id="InputEmail" name="email"
                                placeholder="Enter Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="InputPassword" class="mb-0">Password *</label>
                            <input type="password" class="form-control" id="InputPassword" name="password"
                                placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn hvr-hover">Login</button>
                </form>
            </div>
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="title-left">
                    <h3>{{ __('buttons.create_account_title') }}</h3>
                </div>
                <h5><a data-toggle="collapse" href="#formRegister" role="button"
                        aria-expanded="false">{{ __('buttons.click_here_register') }}
                    </a></h5>
                <form class="mt-3 collapse review-form-box" id="formRegister" method="POST"
                    action="{{ route('register.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="InputName" class="mb-0">First Name *</label>
                            <input type="text" class="form-control" id="InputName" name="name"
                                placeholder="First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="InputEmail1" class="mb-0">Email Address *</label>
                            <input type="email" class="form-control" id="InputEmail1" name="email"
                                placeholder="Enter Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="InputPhone" class="mb-0">Phone *</label>
                            <input type="tel" class="form-control" id="InputPhone" name="phone"
                                placeholder="Phone Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="InputPassword1" class="mb-0">Password *</label>
                            <input type="password" class="form-control" id="InputPassword1" name="password"
                                placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn hvr-hover">Register</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="checkout-address">
                    <div class="title-left">
                        <h3>{{ __('buttons.billing_address') }}</h3>
                    </div>
                    {{-- <form class="needs-validation" novalidate method="POST" action="{{ route('checkout.store') }}">
                        --}}
                    <form id="checkout-form" class="needs-validation" novalidate action="" method="POST">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First Name *</label>
                                <input type="text" class="form-control" id="firstName" name="name"
                                    value="{{ old('name')}}" placeholder="First Name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Phone *</label>
                                <input type="text" class="form-control" id="lastName" name="phone"
                                    value="{{ old('phone') }}" placeholder="phone">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Email Address">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address">Address *</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address') }}" placeholder="Address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="country">Country *</label>
                                <select class="wide w-100" id="country" name="country">
                                    <option value="" selected disabled>Choose...</option>
                                    <option
                                        value="United States"{{ old('country') == 'United States' ? 'selected' : '' }}>
                                        United States</option>
                                    <option value="india"{{ old('country') == 'india' ? 'selected' : '' }}>India
                                    </option>
                                    <option value="pakisthan" {{ old('country') == 'pakisthan' ? 'selected' : '' }}>
                                        Pakisthan</option>
                                </select>
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">State *</label>
                                <select class="wide w-100" id="state" name="state">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="rajsthan" {{ old('state') == 'rajsthan' ? 'selected' : '' }}>
                                        Rajsthan</option>
                                    <option value="uk"{{ old('state') == 'uk' ? 'selected' : '' }}>uk</option>
                                    <option value="mp"{{ old('state') == 'mp' ? 'selected' : '' }}>MP</option>
                                    <option value="gujrat" {{ old('state') == 'gujrat' ? 'selected' : '' }}>Gujrat
                                    </option>
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">City *</label>
                                <select class="wide w-100" id="city" name="city">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="churu"{{ old('city') == 'churu' ? 'selected' : '' }}>Churu
                                    </option>
                                    <option value="bikaner"{{ old('city') == 'bikaner' ? 'selected' : '' }}>Bikaner
                                    </option>
                                    <option value="jaipur"{{ old('city') == 'jaipur' ? 'selected' : '' }}>jaipur
                                    </option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip">Zip *</label>
                                <input type="text" class="form-control" id="zip"
                                    value="{{ old('pin_code') }}" name="pin_code" placeholder="Zip Code">
                                @error('pin_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <hr class="mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="same-address"
                                name="sameBillingShipping" value="1" value="{{ old('sameBillingShipping') }}">
                            <label class="custom-control-label" for="same-address">
                                {{ __('buttons.same_billing_shipping') }}
                            </label>
                            @error('sameBillingShipping')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="save-info" name="save_info"
                                value="{{ old('save_info') }}">
                            <label class="custom-control-label"
                                for="save-info">{{ __('buttons.save_info_next_time') }}</label>
                            @error('save_info')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr class="mb-4">
                        <div class="title"> <span>{{ __('buttons.payment') }}</span> </div>
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="payment_method" type="radio"
                                    class="custom-control-input" value="stripe" checked>
                                <label class="custom-control-label"
                                    for="credit">{{ __('buttons.payment_method_stripe') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="payment_method" type="radio"
                                    class="custom-control-input" value="cod">
                                <label class="custom-control-label"
                                    for="debit">{{ __('buttons.payment_method_cod') }}</label>
                            </div>
                        
                        </div>


                        <hr class="mb-4">
                        <button type="submit" class="btn hvr-hover">{{ __('buttons.place_order') }}</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="row">


                    <div class="col-md-12 col-lg-12">
                        <div class="odr-box">
                            <div class="title-left">
                                <h3>{{ __('buttons.shopping_cart') }}</h3>
                            </div>
                            <div class="rounded p-2 bg-light">
                                @foreach ($quote->quoteItems as $item)
                                    <div class="media mb-2 border-bottom">
                                        <div class="media-body">
                                            <a
                                                href="{{ route('product.detail', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}">
                                                {{ $item->product->name }}
                                            </a>

                                            <div class="small text-muted">
                                                {{ $symbol }}{{ number_format($item->price * $rate, 2) }} <span
                                                    class="mx-2">|</span>
                                                Qty: {{ $item->qty }} <span class="mx-2">|</span>
                                                {{ __('buttons.sub_total') }}:
                                                {{ $symbol }}{{ number_format($item->price * $item->qty * $rate, 2) }}
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="order-box">
                            <div class="title-left">
                                <h3>Your Order</h3>
                            </div>
                            <div class="d-flex">
                                <div class="font-weight-bold">Product</div>
                                <div class="ml-auto font-weight-bold">Total</div>
                            </div>
                            <hr class="my-1">
                            <div class="d-flex">
                                <h4>{{ __('buttons.sub_total') }}</h4>
                                <div class="ml-auto font-weight-bold">
                                    {{ $symbol }}{{ number_format($quote->subtotal * $rate, 2) }}
                                </div>
                            </div>
                            <div class="d-flex">
                                <h4>{{ __('buttons.coupon_discount') }}</h4>
                                <div class="ml-auto font-weight-bold">
                                    {{ $symbol }}{{ number_format($quote->coupon_discount * $rate, 2) }}</div>
                            </div>
                            <hr class="my-1">
                            <div class="d-flex">
                                <h4>{{ __('buttons.shipping_cost') }}</h4>
                                <div class="ml-auto font-weight-bold">Free</div>
                            </div>
                            <hr>
                            <div class="d-flex gr-total">
                                <h5>{{ __('buttons.grand_total') }}</h5>
                                <div class="ml-auto h5">
                                    {{ $symbol }}{{ number_format($quote->total * $rate, 2) }}</div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (selectedMethod === 'stripe') {
            this.action = "{{ route('stripe.post') }}";
        } else if (selectedMethod === 'cod') {
            this.action = "{{ route('checkout.store') }}";
        }
    });
</script>

@include('includes.footer')
