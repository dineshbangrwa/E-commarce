@php
    $title = 'My Account';
    $langCode = session('language_code', app()->getLocale());

@endphp
@include('includes.header')
<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>My Account</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('lang.index', ['lang' => $langCode]) }}">{{ __('buttons.home') }}</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <label for="profile-image-upload" style="cursor: pointer;">
                            <img src="{{ Auth::user()->getFirstMediaUrl('image') ?: asset('front/images/img-pro-01.jpg') }}"
                                class="rounded-circle mb-3" width="120" loading="lazy" height="120"
                                alt="User Image"title="Click to change image">
                        </label>
                        <input type="file" id="profile-image-upload" accept="image/*" style="display: none;">

                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted">Full Stack Developer<br>Bay Area, San Francisco, CA</p>
                        <a href="{{ route('logout') }}" class="btn btn-primary btn-sm">Logout</a>
                        <a href="{{ route('wishlist.index', ['lang' => $langCode]) }}"
                            class="btn btn-outline-secondary btn-sm">Wishlist</a>
                        <a href="{{ route('orders.index', ['lang' => $langCode]) }}"
                            class="btn btn-outline-primary btn-sm">My Orders</a>
                        <hr>
                        <ul class="list-unstyled text-left">
                            <li><i class="fas fa-globe mr-2"></i> Website: <a href="#">yourwebsite.com</a></li>
                            <li><i class="fab fa-github mr-2"></i> Github: yourgithub</li>
                            <li><i class="fab fa-twitter mr-2"></i> Twitter: @yourhandle</li>
                            <li><i class="fab fa-instagram mr-2"></i> Instagram: yourinsta</li>
                            <li><i class="fab fa-facebook mr-2"></i> Facebook: yourfb</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>My Profile</strong>
                        <button id="edit-btn" class="btn btn-light btn-sm float-right">Edit</button>
                    </div>
                    <div class="card-body">
                        <form id="profile-form"
                            action="{{ route('profile.update', ['lang' => $langCode, 'id' => Auth::user()->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" id="save-btn" class="btn btn-success d-none">Save
                                    Changes</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script to toggle editable form -->
<script>
    document.getElementById('edit-btn').addEventListener('click', function() {
        const form = document.getElementById('profile-form');
        form.querySelectorAll('input').forEach(el => el.removeAttribute('disabled'));
        document.getElementById('save-btn').classList.remove('d-none');
        this.classList.add('d-none');
    });
</script>
<script>
    document.getElementById('profile-image-upload').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('profile.image.upload', ['lang' => $langCode]) }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update image without refresh
                    document.querySelector('label[for="profile-image-upload"] img').src = data.image_url +
                        '?v=' + new Date().getTime();
                    alert("Image updated successfully");
                } else {
                    alert("Image update failed");
                }
            })
            .catch(error => {
                alert("An error occurred while uploading.");
                console.error(error);
            });
    });
</script>

@include('includes.footer')
