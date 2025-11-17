@php
    $title = 'My Wishlist';
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());

@endphp

@include('includes.header')

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
                <h2>Wishlist</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lang.index', ['lang' => $langCode]) }}">Shop</a></li>
                    <li class="breadcrumb-item active">Wishlist</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="wishlist-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-main table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Unit Price </th>
                                <th>Stock</th>
                                <th>Add Item</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlist as $wish)
                                <tr>
                                    <td class="thumbnail-img">
                                        <a
                                            href="{{ route('product', ['lang' => $langCode, 'url_key' => $wish->product->url_key]) }}">
                                            <img class="img-fluid" src="{{ $wish->product->getFirstMediaUrl('image') }}"
                                                loading="lazy" alt="" />
                                        </a>
                                    </td>
                                    <td class="name-pr">
                                        <a
                                            href="{{ route('product', ['lang' => $langCode, 'url_key' => $wish->product->url_key]) }}">
                                            {{ $wish->product->name }}
                                        </a>
                                    </td>
                                    <td class="price-pr">
                                        <p>{{ $symbol }}{{ number_format($wish->product->price * $rate, 2) }}</p>
                                    </td>
                                    <td class="quantity-box">Stock:{{ $wish->product->stock }}</td>
                                    <td class="add-pr">
                                        <a class="btn hvr-hover"
                                            href="{{ route('product', ['lang' => $langCode, 'url_key' => $wish->product->url_key]) }}">Add
                                            to
                                            Cart</a>
                                    </td>
                                    <td class="remove-pr">
                                        <a
                                            href="{{ route('wishlist.remove', ['lang' => $langCode, 'id' => $wish->product->id]) }}">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
