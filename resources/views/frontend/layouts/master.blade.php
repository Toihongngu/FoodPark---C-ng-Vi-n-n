<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoodPark || Restaurant Template</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.exzoom.css') }}">
    <!-- fw toastr -->
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
</head>

<body>
    <div class="overlay-container d-none">
        <div class="overlay">
            <span class="loader"></span>
        </div>
    </div>

    <!--=============================
        TOPBAR START
    ==============================-->
    <section class="fp__topbar">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-8">
                    <ul class="fp__topbar_info d-flex flex-wrap">
                        <li><a href="mailto:example@gmail.com"><i class="fas fa-envelope"></i> Unifood@gmail.com</a>
                        </li>
                        <li><a href="callto:123456789"><i class="fas fa-phone-alt"></i> +96487452145214</a></li>
                    </ul>
                </div>
                <div class="col-xl-6 col-md-4 d-none d-md-block">
                    <ul class="topbar_icon d-flex flex-wrap">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a> </li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a> </li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a> </li>
                        <li><a href="#"><i class="fab fa-behance"></i></a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        TOPBAR END
    ==============================-->


    <!--=============================
        MENU START
    ==============================-->

    @include('frontend.layouts.menu')

    <!--=============================
        MENU END
    ==============================-->


    @yield('content')

    <!--=============================
        FOOTER START
    ==============================-->
    @include('frontend.layouts.footer')
    <!--=============================
        FOOTER END
    ==============================-->


    <!--=============================
        SCROLL BUTTON START
    ==============================-->
    <div class="fp__scroll_btn">
        go to top
    </div>
    <!--=============================
        SCROLL BUTTON END
    ==============================-->


    <!--jquery library js-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!-- isotop js -->
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <!-- simplyCountdownjs -->
    <script src="{{ asset('frontend/js/simplyCountdown.js') }}"></script>
    <!-- counter up js -->
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <!-- nice select js -->
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <!-- venobox js -->
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <!-- sticky sidebar js -->
    <script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <!-- ex zoom js -->
    <script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
    <!-- fw toastr -->
    <script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
    <!--main/custom js-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <!--show validate message js-->
    <script>
        toastr.options.progressBar = true;
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        //csrf ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function loadProductModal(productId) {
            $.ajax({
                method: 'GET',
                url: '{{ route('load-product-modal', ':productId') }}'.replace(':productId', productId),
                beforeSend: function() {
                    $('.overlay-container').removeClass('d-none');
                    $('.overlay').addClass('active');
                },
                success: function(response) {
                    $(".load_product_modal_body").html(response);
                    $('#cartModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
                complete: function() {
                    $('.overlay').removeClass('active');
                    $('.overlay-container').addClass('d-none');
                }
            })
        }
    </script>
    <script>
        function updateProductModal(callBack = null) {
            $.ajax({
                method: 'GET',
                url: '{{ route('get-cart-products') }}',
                beforeSend: function() {

                },
                success: function(response) {
                    $(".cart_contents").html(response);
                    let cartTotal = $("#cart_total").val();
                    let cartCount = $("#cart_product_count").val();

                    $(".cart_subtotal").text("{{ currencyPosition(':cartTotal') }}".replace(':cartTotal',
                        cartTotal));
                    $(".cart_count").text(cartCount);
                    if (callBack && typeof callBack === 'function') {
                        callBack();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
                complete: function() {

                }
            })
        }
    </script>
    <script>
        function removeProductFormSidebar($rowId) {
            $.ajax({
                method: 'GET',
                url: '{{ route("cart-product-remove", ":rowId") }}'.replace(":rowId", $rowId),
                beforeSend: function() {
                    $('.overlay-container').removeClass('d-none');
                    $('.overlay').addClass('active');
                },
                success: function(response) {
                    updateProductModal(function() {
                        toastr.success(response.message);
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    });

                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('.overlay').removeClass('active');
                    $('.overlay-container').addClass('d-none');
                }

            })
        }
    </script>
    @stack('scripts')
</body>

</html>
