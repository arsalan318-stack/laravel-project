<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<!-- Mirrored from radiustheme.com/demo/html/classipost/classipost/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Nov 2022 11:05:26 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Noon</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Owl Caousel CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/owl.theme.default.min.css') }}">
    <!-- Main Menu CSS -->
    <link rel="stylesheet" href="{{ asset('css/meanmenu.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <!-- Magnific CSS -->
    <link rel="stylesheet" type="{{ asset('text/css" href="css/magnific-popup.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

</head>

<body>


    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong> browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
    <![endif]-->
    <!-- Add your site or application content here -->
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper">
        <!-- Header Area Start Here -->
        <header>
            <div id="header-three" class="header-style1 header-fixed">
                <div class="header-top-bar top-bar-style1 bg-white">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-8">
                                <div class="top-bar-left">
                                    <a href="{{ route('post_ad') }}" class="cp-default-btn d-lg-none">Post Your Ad</a>
                                    <p class="d-none d-lg-block text-dark">
                                        <i class="fa fa-life-ring text-dark" aria-hidden="true"></i>Have any questions? +088
                                        199990 or mail@classipost
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-4">
                                <div class="top-bar-right">
                                    <ul>
                                        @guest

                                            <li>
                                                <button type="button" class="login-btn text-dark" data-toggle="modal"
                                                    data-target="#authModal"onclick="showLogin()">
                                                    <i href="{{ route('login') }}" class="fa fa-lock"
                                                        aria-hidden="true"></i>Login
                                                </button>
                                            </li>
                                            @if (Route::has('register'))
                                                <li>
                                                    <button type="button" class="login-btn text-dark" data-toggle="modal"
                                                        data-target="#authModal"onclick="showRegister()">
                                                        <i href="{{ route('register') }}" class="fa fa-lock"
                                                            aria-hidden="true"></i>Sign up
                                                    </button>
                                                </li>
                                            @endif
                                        @else
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }} <span class="caret"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                                        Profile
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('my_ads') }}">
                                                        My Ads
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('favorites_ad') }}">
                                                        Favorites Ads
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                            <li class="hidden-mb">
                                                <a class="login-btn text-info" href="{{ route('chat.inbox') }}">
                                                    <i class="fa fa-comments-o" aria-hidden="true"></i>My Chat
                                                </a>
                                                   
                                            </li>
                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-menu-area bg-dark" id="sticker">
                    <div class="container">
                        <div class="row no-gutters d-flex align-items-center">
                            <div class="col-lg-2 col-md-2 col-sm-3">
                                <div class="logo-area">
                                    <a href="index.html" class="img-fluid">
                                        <img src="img/logo.png" alt="logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-6 possition-static">
                                <div class="cp-main-menu">
                                    <nav>
                                        <ul>
                                            <li><a href="{{ route('/') }}">Home</a>
                                                <ul class="cp-dropdown-menu">

                                                </ul>
                                            </li>

                                            <!-- ✅ NEW ALL CATEGORIES ITEM -->
                                            <li class="menu-justify"><a href="#">All Categories</a>
                                                <div class="rt-dropdown-mega container">
                                                    <div class="rt-dropdown-inner">
                                                        <div class="row">
                                                            @foreach ($categories as $category)
                                                                <div class="col-sm-3">
                                                                    <ul class="rt-mega-items">
                                                                        <li><strong>{{ $category->name }}</strong></li>
                                                                        @if ($category->subcategories->count())
                                                                            @foreach ($category->subcategories as $subcategory)
                                                                                <li><a
                                                                                        href="{{ route('get_products', $subcategory->id) }}">{{ $subcategory->name }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ✅ END ALL CATEGORIES ITEM -->
                                            @foreach ($subcategories as $subcategory)
                                                <li><a
                                                        href="{{ route('get_products', $subcategory->id) }}">{{ $subcategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-3 text-right">
                                <a href="#" onclick="handleProtectedAction(event, '{{ route('post_ad') }}')"
                                    class="cp-default-btn">Post Your Ad</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area Start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li><a href="#">All Categories</a>
                                            <ul>
                                                @foreach ($categories as $category)
                                                    <li><a href="#">{{ $category->name }}</a>
                                                        <ul>

                                                            @if ($category->subcategories->count())
                                                                @foreach ($category->subcategories as $subcategory)
                                                                    <li><a href="#">{{ $subcategory->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </li>

                                        <li><a href="{{ route('/') }}">Home</a>
                            
                                        </li>
                                        @foreach ($subcategories as $subcategory)
                                        <li><a
                                                href="{{ route('get_products', $subcategory->id) }}">{{ $subcategory->name }}</a>
                                        </li>
                                    @endforeach                                       
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End -->
        </header>
        <!-- Header Area End Here -->
        <!-- Search Area Start Here -->
        <section class="search-layout1 bg-body full-width-border-bottom fixed-menu-mt">
            <div class="container">
                <form method="GET" action="{{ route('search') }}" enctype="multipart/form-data"
                    id="cp-search-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group search-input-area input-icon-location">
                                <select name="location" id="location" class="select2">
                                    <option class="first" value="0">Select Location</option>
                                    <option value="islamabad">Islamabad</option>
                                    <option value="lahore">Lahore</option>
                                    <option value="karachi">Karachi</option>
                                    <option value="peshawar">Peshawar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group search-input-area input-icon-category">

                                <select name="category" id="categories" class="select2">
                                    <option class="first" value="0">Select Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group search-input-area input-icon-keywords">
                                <input placeholder="Enter Keywords here ..." value="" name="key-word"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-right text-left-mb">
                            <button class="cp-search-btn" type="submit">

                                <i class="fa fa-search" aria-hidden="true"></i>Search

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- Search Area End Here -->
        <!-- Service Area Start Here -->

        @yield('content')

        <!-- Subscribe Area End Here -->
        <!-- Footer Area Start Here -->
        <footer>
            <div class="footer-area-top s-space-equal">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-box">
                                <h3 class="title-medium-light title-bar-left size-lg">About us</h3>
                                <ul class="useful-link">
                                    <li>
                                        <a href="about.html">About us</a>
                                    </li>
                                    <li>
                                        <a href="#">Career</a>
                                    </li>
                                    <li>
                                        <a href="#">Terms &amp; Conditions</a>
                                    </li>
                                    <li>
                                        <a href="#">Privacy Policy</a>
                                    </li>
                                    <li>
                                        <a href="#">Sitemap</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-box">
                                <h3 class="title-medium-light title-bar-left size-lg">How to sell fast</h3>
                                <ul class="useful-link">
                                    <li>
                                        <a href="#">How to sell fast</a>
                                    </li>
                                    <li>
                                        <a href="#">Buy Now on Classipost</a>
                                    </li>
                                    <li>
                                        <a href="#">Membership</a>
                                    </li>
                                    <li>
                                        <a href="#">Banner Advertising</a>
                                    </li>
                                    <li>
                                        <a href="#">Promote your ad</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-box">
                                <h3 class="title-medium-light title-bar-left size-lg">Help &amp; Support</h3>
                                <ul class="useful-link">
                                    <li>
                                        <a href="#">Live Chat</a>
                                    </li>
                                    <li>
                                        <a href="faq.html">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="#">Stay safe on classipost</a>
                                    </li>
                                    <li>
                                        <a href="contact.html">Contact us</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-box">
                                <h3 class="title-medium-light title-bar-left size-lg">Follow Us On</h3>
                                <ul class="folow-us">
                                    <li>
                                        <a href="#">
                                            <img src="img/footer/follow1.jpg" alt="follow">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="img/footer/follow2.jpg" alt="follow">
                                        </a>
                                    </li>
                                </ul>
                                <ul class="social-link">
                                    <li class="fa-classipost">
                                        <a href="#">
                                            <img src="img/footer/facebook.jpg" alt="social">
                                        </a>
                                    </li>
                                    <li class="tw-classipost">
                                        <a href="#">
                                            <img src="img/footer/twitter.jpg" alt="social">
                                        </a>
                                    </li>
                                    <li class="yo-classipost">
                                        <a href="#">
                                            <img src="img/footer/youtube.jpg" alt="social">
                                        </a>
                                    </li>
                                    <li class="pi-classipost">
                                        <a href="#">
                                            <img src="img/footer/pinterest.jpg" alt="social">
                                        </a>
                                    </li>
                                    <li class="li-classipost">
                                        <a href="#">
                                            <img src="img/footer/linkedin.jpg" alt="social">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-center-mb">
                            <p>Copyright © classipost</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right text-center-mb">
                            <ul>
                                <li>
                                    <img src="img/footer/card1.jpg" alt="card">
                                </li>
                                <li>
                                    <img src="img/footer/card2.jpg" alt="card">
                                </li>
                                <li>
                                    <img src="img/footer/card3.jpg" alt="card">
                                </li>
                                <li>
                                    <img src="img/footer/card4.jpg" alt="card">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Area End Here -->
    </div>
    <!-- Combined Login/Register Modal -->
    <!-- Auth Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 rounded-3 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title w-100 text-center" id="authModalTitle">Login</h5>
                    <button type="button" class="close" onclick="closeAuthModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body pt-0">

                    <!-- Login Form -->
                    <div id="loginView">
                        <!-- Google Register (Optional same as login) -->
                        <div class="d-grid mb-3">
                            <a href="{{ url('/auth/google') }}" class="btn btn-outline-danger rounded-pill">
                                <i class="bi bi-google me-2"></i> Login with Google
                            </a>

                            <div class="text-center my-3 text-muted">
                                — or Login with email —
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                               

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                            </form>
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                            <div class="text-center">
                                <small class="text-muted">
                                    Don't have an account?
                                    <a href="#" class="text-primary" onclick="showRegister()">Register</a>
                                </small>
                            </div>
                        </div>
                        
                    </div>
                        <!-- Register Form -->
                        <div id="registerView" class="d-none">
                            <!-- Google Register (Optional same as login) -->
                            <div class="d-grid mb-3">
                                <a href="{{ url('/auth/google') }}" class="btn btn-outline-danger rounded-pill">
                                    <i class="bi bi-google me-2"></i> Register with Google
                                </a>
                            </div>

                            <div class="text-center my-3 text-muted">
                                — or register with email —
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-2">Register</button>
                            </form>
                            <div class="text-center">
                                <small class="text-muted">
                                    Already have an account?
                                    <a href="#" class="text-primary" onclick="showLogin()">Login</a>
                                </small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        



        <!-- Report Abuse Modal Start-->
        <div class="modal fade" id="report_abuse" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content report-abuse-area radius-none">
                    <div class="gradient-wrapper">
                        <div class="gradient-title">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="item-danger"><i class="fa fa-exclamation-triangle"
                                    aria-hidden="true"></i>There's
                                Something Wrong With This Ads?</h2>
                        </div>
                        <div class="gradient-padding reduce-padding">
                            <form id="report-abuse-form">
                                <div class="form-group">
                                    <label class="control-label" for="first-name">Your E-mail</label>
                                    <input type="text" id="first-name" class="form-control"
                                        placeholder="Type your mail here ...">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="control-label" for="first-name">Your Reason</label>
                                        <textarea placeholder="Type your reason..." class="textarea form-control" name="message" id="form-message"
                                            rows="7" cols="20" data-error="Message field is required" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="cp-default-btn-sm">Submit Now!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Abuse Modal End-->
        <!-- jquery-->
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <!-- jQuery Zoom -->
        <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
        <!-- Popper js -->
        <script src="{{ asset('js/popper.js') }}"></script>
        <!-- Bootstrap js -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- Owl Cauosel JS -->
        <script src="{{ asset('vendor/OwlCarousel/owl.carousel.min.js') }}"></script>
        <!-- Meanmenu Js -->
        <script src="{{ asset('js/jquery.meanmenu.min.js') }}"></script>
        <!-- Srollup js -->
        <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
        <!-- jquery.counterup js -->
        <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('js/waypoints.min.js') }}"></script>
        <!-- Select2 Js -->
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <!-- Isotope js -->
        <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
        <!-- Magnific Popup -->
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <!-- Custom Js -->
        <script src="{{ asset('js/main.js') }}"></script>
        <!-- Google Map js -->
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <!-- Validator js -->
        <script src="{{ asset('js/validator.min.js') }}"></script>

        @stack('scripts')


        <script>
            function handleProtectedAction(event, targetUrl) {
                event.preventDefault();

                @auth
                // If the user is logged in, redirect to the actual URL
                window.location.href = targetUrl;
            @else
                // If the user is not logged in, show login/register modal
                $('#authModal').modal('show');
                showLogin(); // show login view by default
            @endauth
            }
        </script>

        <script>
            function showLogin() {
                document.getElementById('loginView').classList.remove('d-none');
                document.getElementById('registerView').classList.add('d-none');
                document.getElementById('authModalTitle').innerText = 'Login';
            }

            function showRegister() {
                document.getElementById('registerView').classList.remove('d-none');
                document.getElementById('loginView').classList.add('d-none');
                document.getElementById('authModalTitle').innerText = 'Register';
            }
        </script>
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show modal using Bootstrap 4 (jQuery)
        $('#authModal').modal('show');

        @if (old('name') || old('password_confirmation'))
            showRegister();
        @else
            showLogin();
        @endif
    });

    function closeAuthModal() {
        if (confirm("Are you sure you want to close?")) {
            $('#authModal').modal('hide');
        }
    }
</script>
@endif


        <script>
            function closeAuthModal() {
                $('#authModal').modal('hide');
            }
        </script>

        <!-- to get subcategories in select option -->
        <script>
            $(document).ready(function() {
                $('#category').on('change', function() {
                    let categoryId = $(this).val();
                    let subcategorySelect = $('#subcategory');

                    // Clear old options
                    subcategorySelect.html('<option value="">Loading...</option>');

                    if (categoryId) {
                        $.ajax({
                            url: '/get-subcategories/' + categoryId,
                            type: 'GET',
                            success: function(data) {
                                subcategorySelect.empty();
                                subcategorySelect.append(
                                    '<option value="">Select Subcategory</option>');
                                $.each(data, function(key, value) {
                                    subcategorySelect.append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                            }
                        });
                    } else {
                        subcategorySelect.html('<option value="">Select Subcategory</option>');
                    }
                });
            });
        </script>
        <script>
            $('#subcategory').on('change', function() {
                let SubcategoryId = $(this).val();

                if (SubcategoryId) {
                    $.ajax({
                        url: '/get_subcategory_fields/' + SubcategoryId,
                        method: 'GET',
                        success: function(response) {
                            $('#dynamic-fields').html(response);
                        }
                    });
                } else {
                    $('#dynamic-fields').empty();
                }
            });
        </script>

        <script>
            // Safe init: only re-init if not already applied
            function initSelect2Fields(container = document) {
                $(container).find('select.select2').each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2({
                            width: '100%'
                        });
                    }
                });
            }

            // Call on page load
            $(document).ready(function() {
                initSelect2Fields();
            });

            // Call after AJAX
            $(document).ajaxSuccess(function(event, xhr, settings) {
                initSelect2Fields('#dynamic-fields');
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.cp-carousel').each(function() {
                    const $carousel = $(this);
                    const itemCount = $carousel.find('.product-box').length;

                    $carousel.owlCarousel({
                        loop: itemCount > 1, // disable looping if only one item
                        items: 5,
                        margin: 30,
                        autoplay: true,
                        autoplayTimeout: 5000,
                        smartSpeed: 2000,
                        dots: false,
                        nav: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                            576: {
                                items: 2
                            },
                            768: {
                                items: 3
                            },
                            992: {
                                items: 4
                            },
                            1200: {
                                items: 5
                            }
                        }
                    });
                });
            });
        </script>
</body>
</body>


<!-- Mirrored from radiustheme.com/demo/html/classipost/classipost/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Nov 2022 11:06:15 GMT -->

</html>
