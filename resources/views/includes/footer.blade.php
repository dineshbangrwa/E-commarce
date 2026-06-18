<div class="instagram-box">
    <div class="main-instagram owl-carousel owl-theme">
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-01.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-02.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-03.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-04.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-05.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-06.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-07.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-08.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-09.jpg') }}?v={{ time() }}" loading="lazy" alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ins-inner-box">
                <img src="{{ asset('front/images/instagram-img-05.jpg') }}?v={{ time() }}"  loading="lazy"alt="" />
                <div class="hov-in">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-widget">
                        <h4>{{ __('buttons.about_zupify') }}</h4>
                        <p>{{ __('buttons.about_zupify_desc') }}</p>

                        <ul>
                            <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link">
                        <h4>{{ __('buttons.our_pages') }}</h4>
                        @foreach (page() as $page)
                            <ul>
                                <li><a
                                        href="{{ route('page', ['lang' => session('language_code', app()->getLocale()), 'url_key' => $page->url_key]) }}">
                                        {{ $page->name }}
                                    </a></li>
                            </ul>
                            <ul>
                                <li><a
                                        href="{{ route('contact', ['lang' => session('language_code', app()->getLocale())]) }}">{{ __('buttons.contact_us') }}</a>
                                </li>

                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer-link-contact">
                        <h4>{{ __('buttons.contact_us') }}</h4>
                        <ul>
                            <li>
                                <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston
                                    Street Wichita,<br> KS 67213 </p>
                            </li>
                            <li>
                                <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705
                                        770</a></p>
                            </li>
                            <li>
                                <p><i class="fas fa-envelope"></i>Email: <a
                                        href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>

<a href="#" id="back-to-top" title="Back to top" style="display: none;">↑</a>

<script src="{{ asset('front/js/jquery-3.2.1.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/popper.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/jquery.superslides.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/bootstrap-select.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/inewsticker.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/bootsnav.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/images-loded.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/isotope.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/baguetteBox.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/form-validator.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/contact-form-script.js') }}?v={{ time() }}"></script>
<script src="{{ asset('front/js/custom.js') }}?v={{ time() }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '.update-qty', function() {
            let itemId = $(this).data('id');
            let qty = $(this).val();
            $.ajax({
                url: '/cart/update-ajax/' + itemId,
                method: 'PUT',
                data: { quantity: qty, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        $('#total-' + itemId).text('₹' + response.updated_total);
                        location.reload();
                    } else {
                        alert(response.message || 'Update failed');
                    }
                },
                error: function() { alert('Error updating quantity'); }
            });
        });
    </script>
</body>
</html>
