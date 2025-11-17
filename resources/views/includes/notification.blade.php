{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ session('error') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Warning!',
            text: "{{ session('warning') }}",
            confirmButtonText: 'Got it!'
        });
    </script>
@endif

@if (!Auth::check() && !session('alert_shown'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Welcome to Our Store!',
                text: "Please login or register to access your wishlist and cart.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Register',
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#28a745',
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: true,
                allowEscapeKey: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "{{ route('register') }}";
                }
            });
        });
    </script> --}}

 
  {{--  @php
        session(['alert_shown' => true]);
    @endphp --}}
{{-- @endif --}}


<!-- In head section -->
{{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- At bottom before </body> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(session('message'))
        toastr.success("{{ session('message') }}", '', { timeOut: 2000 });
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}", '', { timeOut: 2000 });
    @endif
</script> --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    // Normal messages
    @if(session('message'))
        toastr.success("{{ session('message') }}", '', { timeOut: 2000 });
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}", '', { timeOut: 2000 });
    @endif

    // Guest login/register prompt
    @if(!Auth::check() && !session('alert_shown'))
        $(document).ready(function() {
            toastr.info("Please login or register to access your wishlist and cart.", '', {
                timeOut: 3000,
                closeButton: true,
                tapToDismiss: false,
                onHidden: function() {
                  
                    if(confirm('Do you want to Login? Click Cancel for Register')) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        window.location.href = "{{ route('register') }}";
                    }
                }
            });
        });

        @php
            session()->flash('alert_shown', true); 
        @endphp
    @endif
</script>


