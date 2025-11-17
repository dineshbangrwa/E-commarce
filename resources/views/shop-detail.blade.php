@php
    $title = $product->name . ' - Zopify';
    $meta_description = $product->meta_description ?? Str::limit(strip_tags($product->description), 160);
    $meta_keywords = $product->meta_tag ?? 'product, zopify, ' . $product->name;
@endphp

@include('includes.header')

<style>
    .single-product-slider .carousel-item img,
    .carousel-indicators img {
        height: 450px;
        object-fit: cover;
        object-position: center;
    }

    .carousel-indicators li img {
        height: 80px;
        width: 80px;
        object-fit: cover;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .single-product-slider .carousel-item img {
            height: 300px;
        }
    }

    .variant-box {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px;
        background-color: #fff;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .variant-box:hover {
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        transform: translateY(-3px);
    }

    .variant-box.selected {
        border-color: #007bff;
        background-color: #f8f9fa;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }

    .variant-content {
        font-size: 12px;
    }

    .variant-details {
        margin-bottom: 5px;
        font-size: 13px;
    }

    .attribute-name {
        font-weight: 600;
        color: #333;
    }

    .attribute-value {
        color: #555;
        margin-left: 5px;
    }

    .special-price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 15px;
    }

    .original-price {
        font-size: 12px;
        margin-left: 6px;
    }

    .products-single .box-img-hover img {
        height: 250px;
        object-fit: scale-down;
        width: 100%;
    }

    .star-rating-wrap {
        display: inline-block;
        direction: ltr;
    }

    .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
        margin-right: 3px;
    }

    .star.selected,
    .star.hovered {
        color: #ffb300;
    }
</style>

@php
    $rate = session('currency_rate', 1);
    $symbol = session('currency_symbol', '₹');
    $langCode = session('language_code', app()->getLocale());
@endphp

<div class="shop-detail-box-main">
    <div class="container">
        <div class="row">
            @php
                $mainImage = $product->getFirstMediaUrl('image');
                $bannerImages = $product->getMedia('banner_image');
                $attributes =
                    $attributes ?? \App\Models\Attribute::where('product_id', $product->id)->with('values')->get();
                $attributeCombinations =
                    $attributeCombinations ??
                    \App\Models\AttributeCombination::where('product_id', $product->id)->get();
            @endphp

            <div class="col-xl-5 col-lg-5 col-md-6">
                <div id="carousel-example-1" class="single-product-slider carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ $mainImage }}" loading="lazy"
                                alt="{{ $product->name }}">
                        </div>
                        @foreach ($bannerImages as $index => $bannerImage)
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ $bannerImage->getUrl() }}" loading="lazy"
                                    alt="{{ $product->name }} Banner {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @if ($bannerImages->isNotEmpty())
                        <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                    <ol class="carousel-indicators">
                        @foreach ($bannerImages as $index => $bannerImage)
                            <li data-target="#carousel-example-1" data-slide-to="{{ $index + 1 }}">
                                <img class="d-block w-100 img-fluid" src="{{ $bannerImage->getUrl() }}"
                                    alt="{{ $product->name }} Banner {{ $index + 1 }}">
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <div class="col-xl-7 col-lg-7 col-md-6">
                <div class="single-product-details">
                    <a class="cart"
                        href="{{ route('product', ['lang' => session('language_code', app()->getLocale()), 'url_key' => $product->url_key]) }}">
                        <h2>{{ $product->name }}</h2>
                    </a>

                    <div id="price-display">
                        <h5>
                            <span style="text-decoration: line-through; color: #999;" id="original-price">
                                {{ $symbol }}{{ number_format($product->price * $rate, 2) }}
                            </span>
                            <span style="color: #e74c3c; margin-left: 10px;" id="current-price">
                                {{ $symbol }}{{ number_format(($product->special_price ?? $product->price) * $rate, 2) }}
                            </span>
                        </h5>
                    </div>

                    <p class="available-stock" style="display: none;">
                        <span><a href="#" id="stock-display">{{ $product->stock }} Stock</a></span>
                    </p>

                    <h4>Short Description:</h4>
                    <p>{{ $product->short_description ?? $product->description }}</p>


                    <form id="add-to-cart-form" action="{{ route('cart.store', ['lang' => $langCode]) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="combination_id" id="combination_id"
                            value="{{ $attributeCombinations->first()->id ?? '' }}">

                        <div class="row mb-4" id="variant-combination-boxes">
                            @foreach ($attributeCombinations as $index => $combination)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="variant-box {{ $index === 0 ? 'selected' : '' }}"
                                        data-combination-id="{{ $combination->id }}">
                                        <div class="variant-content">
                                            @php
                                                $valueIds = is_array($combination->attribute_value_ids)
                                                    ? $combination->attribute_value_ids
                                                    : explode(',', $combination->attribute_value_ids);
                                                $attributeValues = \App\Models\AttributeValue::whereIn('id', $valueIds)
                                                    ->with('attribute')
                                                    ->get();
                                            @endphp
                                            @foreach ($attributeValues as $value)
                                                <div class="variant-details">
                                                    <span
                                                        class="attribute-name">{{ $value->attribute->name ?? 'N/A' }}:</span>
                                                    <span class="attribute-value">{{ $value->value ?? 'N/A' }}</span>
                                                </div>
                                            @endforeach
                                            <div class="variant-price">
                                                <span
                                                    class="special-price">{{ $symbol }}{{ number_format($combination->price * $rate, 2) }}</span>
                                            </div>
                                            @if ($combination->stock <= 0)
                                                <div class="badge badge-danger mt-2">Out of Stock</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group quantity-box">
                            <label class="quantity-label control-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="quantity" value="1"
                                min="1" max="{{ $product->stock }}" required>
                        </div>

                        <div class="price-box-bar">
                            <div class="cart-and-bay-btn">
                                <a class="btn hvr-hover"
                                    href="{{ route('wishlist.add', ['lang' => session('language_code', app()->getLocale()), 'id' => $product->id]) }}">
                                    {{ __('buttons.add_to_wishlist') }}
                                </a>
                                @auth
                                    <button type="submit" class="btn hvr-hover"> {{ __('buttons.Add to Cart') }}</button>
                                    <button type="button" class="btn hvr-hover"
                                        id="buy-now-btn">{{ __('buttons.buy_now') }}</button>
                                @else
                                    <a href="{{ route('login', ['lang' => session('language_code', app()->getLocale())]) }}"
                                        class="btn hvr-hover"> {{ __('buttons.Add to Cart') }}</a>
                                    <a href="{{ route('login', ['lang' => session('language_code', app()->getLocale())]) }}"
                                        class="btn hvr-hover">{{ __('buttons.buy_now') }}</a>
                                @endauth
                            </div>
                        </div>
                    </form>
                </div>

                <div class="share-bar">
                    <a class="btn hvr-hover" href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    <a class="btn hvr-hover" href="#"><i class="fab fa-google-plus"
                            aria-hidden="true"></i></a>
                    <a class="btn hvr-hover" href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a class="btn hvr-hover" href="#"><i class="fab fa-pinterest-p"
                            aria-hidden="true"></i></a>
                    <a class="btn hvr-hover" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-5">
            <h3 class="mb-4 fw-bold text-dark"> {{ __('buttons.customer_reviews') }} <span
                    class="text-muted">({{ $approvedReviews->count() }})</span></h3>

            @if ($approvedReviews->isEmpty())
                <p class="text-muted fst-italic">No reviews yet. Be the first to share your thoughts!</p>
            @else
                <div class="row g-4">
                    @foreach ($approvedReviews as $review)
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0">
                                            {{ $review->user ? $review->user->name : $review->reviewer_name }}</h5>
                                        <small
                                            class="text-muted fst-italic">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="card-text text-secondary">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <hr class="my-5">

            @if (session('success'))
                <div class="alert alert-success rounded-0">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @guest
                    <div class="mb-3">
                        <label for="reviewer_name" class="form-label fw-semibold">Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="reviewer_name" id="reviewer_name" class="form-control shadow-sm"
                            required value="{{ old('reviewer_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="reviewer_email" class="form-label fw-semibold">Email <span
                                class="text-danger">*</span></label>
                        <input type="email" name="reviewer_email" id="reviewer_email" class="form-control shadow-sm"
                            required value="{{ old('reviewer_email') }}">
                    </div>
                @endguest

                <div class="form-group mb-3">
                    <label class="form-label fw-semibold d-block">{{ __('buttons.rating') }} <span
                            class="text-danger">*</span></label>
                    <div class="star-rating-wrap">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                        <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 0) }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="comment" class="form-label fw-semibold">{{ __('buttons.comment') }}</label>
                    <textarea name="comment" id="comment" rows="4" class="form-control shadow-sm">{{ old('comment') }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning px-4">{{ __('buttons.submit_review') }}</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Star rating hover effect */
    .star-rating input[type=radio]:checked~label i,
    .star-rating label:hover~label i,
    .star-rating label:hover i {
        color: #ffb300 !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

@include('includes.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attributeCombinations = @json($attributeCombinations);
        const langCode = "{{ session('language_code', app()->getLocale()) }}";

        const addToCartButton = document.querySelector('button[type="submit"]');
        const buyNowButton = document.getElementById('buy-now-btn');

        document.querySelectorAll('.variant-box').forEach(box => {
            box.addEventListener('click', function() {
                document.querySelectorAll('.variant-box').forEach(b => b.classList.remove(
                    'selected'));
                this.classList.add('selected');

                const combinationId = this.dataset.combinationId;
                const combination = attributeCombinations.find(c => c.id == combinationId);

                if (combination) {
                    let currencySymbol = @json(session('currency_symbol', '₹'));
                    let currencyRate = parseFloat(@json(session('currency_rate', 1)));
                    let convertedPrice = (combination.price * currencyRate).toLocaleString(
                        'en-IN', {
                            minimumFractionDigits: 2
                        });
                    document.getElementById('current-price').textContent = currencySymbol +
                        convertedPrice;

                    document.getElementById('stock-display').textContent = combination.stock +
                        ' Stock';
                    document.getElementById('quantity').max = combination.stock;
                    document.getElementById('combination_id').value = combinationId;

                    if (combination.stock <= 0) {
                        addToCartButton.disabled = true;
                        buyNowButton.disabled = true;
                        addToCartButton.textContent = "Out of Stock";
                        buyNowButton.textContent = "Out of Stock";
                    } else {
                        addToCartButton.disabled = false;
                        buyNowButton.disabled = false;
                        addToCartButton.textContent = " {{ __('buttons.Add to Cart') }}";
                        buyNowButton.textContent = "{{ __('buttons.buy_now') }}";
                    }
                }
            });
        });

        buyNowButton.addEventListener('click', function() {
            if (buyNowButton.disabled) return;

            const productId = "{{ $product->id }}";
            const qty = document.getElementById('quantity').value || 1;
            const combinationId = document.getElementById('combination_id').value || '';
            const url = `/${langCode}/buy/${productId}?qty=${qty}&combination_id=${combinationId}`;
            window.location.href = url;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating-wrap .star');
        const ratingInput = document.getElementById('rating-value');
        const ratingError = document.getElementById('rating-error');
        let selectedValue = parseInt(ratingInput.value) || 0;

        highlightStars(selectedValue);

        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => {
                highlightStars(idx + 1, true);
            });
            star.addEventListener('mouseleave', () => {
                highlightStars(selectedValue);
            });
            star.addEventListener('click', () => {
                selectedValue = idx + 1;
                ratingInput.value = selectedValue;
                highlightStars(selectedValue);
                ratingError.classList.add('d-none');
            });
        });

        const reviewForm = document.querySelector('form');
        reviewForm.addEventListener('submit', function(e) {
            if (ratingInput.value === '0' || !ratingInput.value) {
                e.preventDefault();
                ratingError.classList.remove('d-none');
                ratingError.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });

        function highlightStars(count, hover = false) {
            stars.forEach((star, i) => {
                if (i < count) star.classList.add(hover ? 'hovered' : 'selected');
                else star.classList.remove('hovered', 'selected');
            });
        }
    });
</script>
