@php
    $title = 'Your Cart';

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
                <h2>{{ __('buttons.cart') }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{ __('buttons.shop') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('buttons.cart') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="cart-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-main table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (quote() && quote()->quoteItems && quote()->quoteItems->count() > 0)
                                @foreach (quote()->quoteItems as $item)
                                    <tr>
                                        <td class="thumbnail-img">
                                            <a
                                                href="{{ route('product.detail', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}">
                                                <img class="img-fluid"
                                                    src="{{ $item->product->getFirstMediaUrl('image') }}" loading="lazy"
                                                    alt="" />
                                            </a>

                                        </td>
                                        <td class="name-pr">
                                            <a
                                                href="{{ route('product.detail', ['lang' => $langCode, 'url_key' => $item->product->url_key]) }}">
                                                {{ $item->product->name }}
                                                <br>
                                                @if ($item->custom_option)
                                                    <small>Option: {{ $item->custom_option }}</small>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="price-pr">
                                            <p>{{ $symbol }}{{ number_format($item->price * $rate, 2) }}</p>

                                        </td>
                                        <td class="quantity-box">
                                            <input type="number" name="quantity" value="{{ $item->qty }}"
                                                min="1" class="c-input-text qty text update-qty"
                                                data-id="{{ $item->id }}">
                                        </td>

                                        <td class="total-pr">
                                            <p id="total-{{ $item->id }}">
                                                {{ $symbol }}{{ number_format($item->price * $item->qty * $rate, 2) }}
                                            </p>
                                        </td>



                                        <td class="remove-pr">
                                            <form action="{{ route('remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: none; background: transparent;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('buttons.no_items_in_cart') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row my-5">

            <div class="col-lg-6 col-sm-6">
                <div class="coupon-box">
                    <form action="{{ route('coupon_dis', ['lang' => $langCode]) }}" method="POST">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input class="form-control" name="coupon" placeholder="Enter your coupon code"
                                aria-label="Coupon code" type="text">
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">

                            <div class="input-group-append">
                                <button class="btn btn-theme" type="submit">{{ __('buttons.apply_coupon') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>

        <div class="row my-5">
            <div class="col-lg-8 col-sm-12"></div>
            <div class="col-lg-4 col-sm-12">
                <div class="order-box">
                    <h3>{{ __('buttons.order_summary') }}</h3>
                    <div class="d-flex">
                        <h4>{{ __('buttons.sub_total') }}</h4>
                        <div class="ml-auto font-weight-bold">
                            {{ $symbol }}{{ number_format($quote->subtotal * $rate, 2) }}</div>
                    </div>
                    <div class="d-flex">
                        <h4>{{ __('buttons.discount') }}</h4>
                        <div class="ml-auto font-weight-bold">{{ $quote->coupon }}</div>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex">
                        <h4>{{ __('buttons.coupon_discount') }}</h4>
                        <div class="ml-auto font-weight-bold">
                            {{ $symbol }}{{ number_format($quote->coupon_discount * $rate, 2) }}
                        </div>

                    </div>

                    <div class="d-flex">
                        <h4>{{ __('buttons.shipping_cost') }}</h4>
                        <div class="ml-auto font-weight-bold"> Free </div>
                    </div>
                    <hr>
                    <div class="d-flex gr-total">
                        <h5>{{ __('buttons.grand_total') }}</h5>
                        <div class="ml-auto h5">{{ $symbol }}{{ number_format($quote->total * $rate, 2) }}</div>

                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-12 d-flex shopping-box"><a href="{{ route('checkout', ['lang' => $langCode]) }}"
                    class="ml-auto btn hvr-hover">{{ __('buttons.checkout') }}</a>
            </div>
        </div>

    </div>
</div>

@include('includes.footer')
