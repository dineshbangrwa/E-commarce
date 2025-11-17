@php
    $title = 'Checkout';

@endphp
@include('includes.header')

@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
@endphp


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
    
        <div class="row">
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="checkout-address">
                    <div class="title-left">
                        <h3>{{ __('buttons.billing_address') }}</h3>
                    </div>
                    <form id="checkout-form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="qty" value="{{ $qty }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Email *</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Address *</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Country *</label>
                                <select class="form-control" name="country">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="india" {{ old('country') == 'india' ? 'selected' : '' }}>India
                                    </option>
                                    <option value="usa" {{ old('country') == 'usa' ? 'selected' : '' }}>Usa</option>
                                    <option value="pakisthan"{{ old('country') == 'pakisthan' ? 'selected' : '' }}>
                                        pakisthan</option>
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
                                <select class="wide w-100" id="state" name="city">
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="churu" {{ old('city') == 'churu' ? 'selected' : '' }}>Churu
                                    </option>
                                    <option value="bikaner" {{ old('city') == 'bikaner' ? 'selected' : '' }}>Bikaner
                                    </option>
                                    <option value="jaipur" {{ old('city') == 'jaipur' ? 'selected' : '' }}>jaipur
                                    </option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Zip *</label>
                                <input type="text" class="form-control" name="pin_code"
                                    value="{{ old('pin_code') }}">
                                @error('pin_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="stripe" name="payment_method" type="radio" class="custom-control-input"
                                    value="stripe" checked>
                                <label class="custom-control-label"
                                    for="stripe">{{ __('buttons.payment_method_stripe') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="cod" name="payment_method" type="radio" class="custom-control-input"
                                    value="cod">
                                <label class="custom-control-label"
                                    for="cod">{{ __('buttons.payment_method_cod') }}</label>
                            </div>
                        </div>

                        <button type="submit" class="btn hvr-hover mt-3">Place Order</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="order-box">
                    <h3>Your Product</h3>
                    <div class="media mb-2 border-bottom">
                        <div class="media-body">
                            <a
                                href="{{ route('product.detail', ['lang' => $langCode, 'url_key' => $product->url_key]) }}">{{ $product->name }}</a>
                            <div class="small text-muted">
                                Qty: {{ $qty }}<br>
                                Price: {{ $symbol }}{{ number_format($product->price * $rate, 2) }}

                            </div>
                        </div>
                    </div>

                    @php
                        $subtotal = $product->price * $qty;
                        $discount = session('coupon_discount', 0);
                        $coupon = session('coupon', null);
                        $grandTotal = $subtotal - $discount;
                    @endphp

                    <hr class="my-2">
                    <div class="d-flex">
                        <h4>{{ __('buttons.sub_total') }}</h4>
                        <div class="ml-auto font-weight-bold">
                            {{ $symbol }}{{ number_format($subtotal * $rate, 2) }}
                        </div>

                    </div>
                    <div class="d-flex">
                        <h4>{{ __('buttons.discount') }}</h4>
                        <div class="ml-auto font-weight-bold">
                            @if ($coupon)
                                ({{ $coupon }})
                            @endif
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex">
                        <h4>{{ __('buttons.coupon_discount') }}</h4>
                        <div class="ml-auto font-weight-bold">
                            {{ $symbol }}{{ number_format($discount * $rate, 2) }}
                        </div>

                    </div>

                    <div class="d-flex">
                        <h4>{{ __('buttons.shipping_cost') }}</h4>
                        <div class="ml-auto font-weight-bold">Free</div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex gr-total">
                        <h5>{{ __('buttons.grand_total') }}</h5>
                        <div class="ml-auto h5">{{ $symbol }}{{ number_format($grandTotal * $rate, 2) }}</div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-lg-12">
                        <form action="{{ route('apply.coupon', ['lang' => $langCode]) }}" method="POST"
                            class="d-flex">
                            @csrf
                            <input type="text" name="coupon" class="form-control"
                                placeholder="Enter Coupon Code">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="{{ $qty }}">
                            <button type="submit"
                                class="btn btn-theme ms-2">{{ __('buttons.apply_coupon') }}</button>
                        </form>
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
            this.action = "{{ route('stripe.buy') }}";
        } else {
            this.action = "{{ route('checkout.buy') }}";
        }
    });
</script>

@include('includes.footer')
