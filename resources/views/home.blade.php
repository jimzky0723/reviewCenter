<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Parallax, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Grayrids">
    <title>Philippine Exam Review Centers</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/line-icons.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/owl.theme.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/nivo-lightbox.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/slicknav.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/main.css">
    <link rel="stylesheet" href="{{ asset('public') }}/css/responsive.css">

</head>
<body>

<!-- Header Section Start -->
<header id="hero-area" data-stellar-background-ratio="0.5">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar indigo">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a href="index.html" class="navbar-brand"><img class="img-fulid" src="{{ asset('public') }}/img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="lnr lnr-menu"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#hero-area">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#services">Goal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#features">Announcement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#portfolios">Review Centers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <?php $user = \Illuminate\Support\Facades\Session::get('access'); ?>
                        @if($user)
                            <a class="nav-link page-scroll" href="{{ asset('validate') }}">Login</a>
                        @else
                            <a class="nav-link page-scroll" href="#loginModal" data-toggle="modal">Login</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu Start -->
        <ul class="mobile-menu">
            <li>
                <a class="page-scroll" href="#hero-area">Home</a>
            </li>
            <li>
                <a class="page-scroll" href="#services">Goal</a>
            </li>
            <li>
                <a class="page-scroll" href="#features">Announcement</a>
            </li>
            <li>
                <a class="page-scroll" href="#portfolios">Review Centers</a>
            </li>
            <li>
                <a class="page-scroll" href="#contact">Contact</a>
            </li>
            <li>
                @if($user)
                    <a class="page-scroll" href="{{ asset('validate') }}">Login</a>
                @else
                    <a class="page-scroll" href="#loginModal" data-toggle="modal">Login</a>
                @endif
            </li>
        </ul>
        <!-- Mobile Menu End -->

    </nav>
    <!-- Navbar End -->
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="contents text-center">
                    <h1 class="wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="0.3s">Philippine Exam Review Centers</h1>
                    <p class="lead  wow fadeIn" data-wow-duration="1000ms" data-wow-delay="400ms">PHERC: A Software-As-A-Service for Philippine Exam Review Centers.</p>
                    <a data-toggle="modal" href="#subscribeModal" class="btn btn-common wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">Subscribe</a>
                    <a data-toggle="modal" href="#registerModal" class="btn btn-common wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">Register Now</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Services Section Start -->
<section id="services" class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Our Goals</h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, dignissimos! <br> Lorem ipsum dolor sit amet, consectetur.</p>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="item-boxes wow fadeInDown" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="lnr lnr-pencil"></i>
                    </div>
                    <h4>Information Portal</h4>
                    <p>To post announcements, provide module lessons with subject and topics for reviewers and reviewees.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="item-boxes wow fadeInDown" data-wow-delay="0.8s">
                    <div class="icon">
                        <i class="lnr lnr-code"></i>
                    </div>
                    <h4>Reliable</h4>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="item-boxes wow fadeInDown" data-wow-delay="1.2s">
                    <div class="icon">
                        <i class="lnr lnr-mustache"></i>
                    </div>
                    <h4>Mobile</h4>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Features Section Start -->
<section id="features" class="section" data-stellar-background-ratio="0.2">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Announcements</h2>
            <hr class="lines">
            <p class="section-subtitle"></p>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="container">
                    <div class="row">
                        <?php
                            $announcements = \App\Announcement::where('target','center')
                                ->orderBy('created_at','desc')
                                ->limit(4)
                                ->get();
                        ?>
                        @foreach($announcements as $row)
                        <div class="col-lg-6 col-sm-6 col-xs-12 box-item">
                            <span class="icon">
                              <i class="lnr lnr-calendar-full"></i>
                            </span>
                            <div class="text">
                                <h4>{{ date('M d, Y',strtotime($row->created_at)) }}</h4>
                                {!! nl2br($row->content) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12">
                <div class="show-box">
                    <img class="img-fulid" src="{{ asset('public') }}/img/features/feature.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features Section End -->

<!-- Portfolio Section -->
<section id="portfolios" class="section">
    <!-- Container Starts -->
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Registered Review Center</h2>
            <hr class="lines">
            <p class="section-subtitle">List of Review Centers registered from Luzon to Mindanao.</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Portfolio Controller/Buttons -->
                <div class="controls text-center">
                    <a class="filter active btn btn-common" data-filter="all">
                        All
                    </a>

                    @foreach($registered as $row)
                    <a class="filter btn btn-common" data-filter=".{{ $row->regCode }}">
                        {{ $row->desc }}
                    </a>
                    @endforeach
                </div>
                <!-- Portfolio Controller/Buttons Ends-->
            </div>
            <style>
                .info {
                    margin-top:30%;
                }
            </style>
            <!-- Portfolio Recent Projects -->
            <div id="portfolio" class="row">
                @foreach($centers as $row)
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix print {{ $row->regCode }}">
                    <div class="portfolio-item">
                        <div class="shot-item">
                            <img src="{{ asset('public') }}/img/portfolio/img1.jpg" alt="" />

                            <a class="overlay">
                                <div class="info">
                                    {{ $row->desc }}<br />
                                    Capacity: {{ $row->limit }} Students<br />
                                    <?php
                                        $count = \App\Reviewee::where('center_id',$row->id)->count();
                                        $available = $row->limit - $count;
                                    ?>
                                    Available: {{ $available }} Slots<br />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Container Ends -->
</section>
<!-- Portfolio Section Ends -->

<!-- Counter Section Start -->
<div class="counters section" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">

            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="facts-item">
                    <div class="icon">
                        <i class="lnr lnr-home"></i>
                    </div>
                    <div class="fact-count">
                        <h3><span class="counter">{{ $countCenter }}</span></h3>
                        <h4>Review Centers</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="facts-item">
                    <div class="icon">
                        <i class="lnr lnr-briefcase"></i>
                    </div>
                    <div class="fact-count">
                        <h3><span class="counter">{{ $countInstructor }}</span></h3>
                        <h4>Instructor</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="facts-item">
                    <div class="icon">
                        <i class="lnr lnr-user"></i>
                    </div>
                    <div class="fact-count">
                        <h3><span class="counter">{{ $countReviewee }}</span></h3>
                        <h4>No. of Students</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="facts-item">
                    <div class="icon">
                        <i class="lnr lnr-heart"></i>
                    </div>
                    <div class="fact-count">
                        <h3><span class="counter">{{ $countSatisfied }}</span></h3>
                        <h4>Satisfied Students</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Counter Section End -->

<!-- Contact Section Start -->
<section id="contact" class="section" data-stellar-background-ratio="-0.2">
    <div class="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="contact-us">
                        <h3>Contact With us</h3>
                        <div class="contact-address">
                            <p>Centerville Road, DE 19808, US </p>
                            <p class="phone">Phone: <span>(+94 123 456 789)</span></p>
                            <p class="email">E-mail: <span>(contact@mate.com)</span></p>
                        </div>
                        <div class="social-icons">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="contact-block">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required data-error="Please enter your name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Your Email" id="email" class="form-control" name="name" required data-error="Please enter your email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" placeholder="Your Message" rows="8" data-error="Write your message" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="submit-button text-center">
                                        <button class="btn btn-common" id="submit" type="submit">Send Message</button>
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
</section>
<!-- Contact Section End -->

<!-- Footer Section Start -->
<footer>
    <div class="container">
        <div class="row">
            <!-- Footer Links -->
            <div class="col-xs-12">
                <div class="copyright">
                    <p>All copyrights reserved &copy; 2018 - Designed & Developed by <a rel="nofollow" href="#">PHERC</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Go To Top Link -->
<a href="#" class="back-to-top">
    <i class="lnr lnr-arrow-up"></i>
</a>

<div id="loader">
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<?php
$status = session('status');
?>
@include('modal.register')
@include('modal.subscribe')
@include('modal.login')
@include('modal.status')
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="{{ asset('public') }}/js/jquery-min.js"></script>
<script src="{{ asset('public') }}/js/popper.min.js"></script>
<script src="{{ asset('public') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public') }}/js/jquery.mixitup.js"></script>
<script src="{{ asset('public') }}/js/nivo-lightbox.js"></script>
<script src="{{ asset('public') }}/js/owl.carousel.js"></script>
<script src="{{ asset('public') }}/js/jquery.stellar.min.js"></script>
<script src="{{ asset('public') }}/js/jquery.nav.js"></script>
<script src="{{ asset('public') }}/js/scrolling-nav.js"></script>
<script src="{{ asset('public') }}/js/jquery.easing.min.js"></script>
<script src="{{ asset('public') }}/js/smoothscroll.js"></script>
<script src="{{ asset('public') }}/js/jquery.slicknav.js"></script>
<script src="{{ asset('public') }}/js/wow.js"></script>
<script src="{{ asset('public') }}/js/jquery.vide.js"></script>
<script src="{{ asset('public') }}/js/jquery.counterup.min.js"></script>
<script src="{{ asset('public') }}/js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('public') }}/js/waypoints.min.js"></script>
<script src="{{ asset('public') }}/js/form-validator.min.js"></script>
<script src="{{ asset('public') }}/js/contact-form-script.js"></script>
<script src="{{ asset('public') }}/js/main.js"></script>

@include('script.login')
@include('script.location')
@include('script.center_list')
@include('script.sub_location')

@if($status)
<script>
    $('#statusModal').modal('show');

</script>
@endif
</body>
</html>