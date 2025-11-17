@include('admin.includes.header')

<body>
    <div class="wrapper">
        @include('admin.includes.slidebar')

        <div class="main-panel">
            @include('admin.includes.nav')

            <div class="container">
                <div class="page-inner">
                    @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

                    @yield('content')
                    
                </div>
            </div>
            @include('admin.includes.footer')
            @yield('script')
        </div>
    </div>

    <!-- jQuery CDN with fallback -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    <script>
        // Fallback: If jQuery CDN fails, load local copy
        window.jQuery || document.write('<script src="{{ asset("js/jquery-3.7.1.min.js") }}"><\/script>');
    </script>
</body>