@php
    $symbol = session('currency_symbol', '₹');
    $rate = session('currency_rate', 1);
    $langCode = session('language_code', app()->getLocale());
    $pageTitle = $title ?? ($page->name ?? 'Zopify');
    $metaDescription = $meta_description ?? ($page->meta_description ?? 'Discover amazing products at Zopify');
    $metaKeywords = $meta_keywords ?? ($page->meta_tag ?? 'ecommerce, zopify, shopping');
@endphp
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="author" content="Zopify">
    <title>{{ $pageTitle }}</title>
    <link rel="shortcut icon" href="{{ asset('front/images/favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('front/images/apple-touch-icon.png') }}?v={{ time() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#0F0F1A] text-[#F1F1F6] antialiased">
    @include('layouts.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
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
