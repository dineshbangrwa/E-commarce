@php
    $title = __('buttons.contact_us');
@endphp

@php
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
                <h2>{{ __('buttons.contact_us') }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('lang.index', ['lang' => $langCode]) }}">{{ __('buttons.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('buttons.contact_us') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="contact-info-left">
                    <h2>{{ __('buttons.contact_info') }}</h2>
                    <p>{{ __('buttons.contact_info_text') }}</p>
                    <ul>
                        <li>
                            <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street
                                Wichita,<br> KS 67213 </p>
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
            <div class="col-lg-8 col-sm-12">
                <div class="contact-form-right">
                    <h2>{{ __('buttons.get_in_touch') }}</h2>
                    <p>{{ __('buttons.contact_info_text') }}</p>
                    <form action="{{ route('contact.store', ['lang' => $langCode]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Your Name" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="email" placeholder="Your Email" id="email" class="form-control"
                                        name="email" required data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Phone" required data-error="Please enter your Phone No..">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="message" name="message" placeholder="Your Message" rows="4"
                                        data-error="Write your message" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" id="submit"
                                        type="submit">{{ __('buttons.send_message') }}</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
