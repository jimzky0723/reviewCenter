<?php
    $user = Session::get('access');
    $title = isset($title) ? $title : 'Panel | '.$user->level;
    $img = 'admin.jpg';
    if($user->level==='center'){
        $img = 'center.jpg';
    }else if($user->level==='instructor'){
        if($user->sex=='Male'){
            $img = 'teacher_2.jpg';
        }else if($user->sex=='Female'){
            $img = 'teacher_1.jpg';
        }
    }else if($user->level==='reviewee'){
        if($user->sex=='Male'){
            $img = 'student_2.jpg';
        }else if($user->sex=='Female'){
            $img = 'student_1.jpg';
        }
    }
    $status = session('status');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('public/panel') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/panel') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('public/panel') }}/css/custom.min.css" rel="stylesheet">
    <style>
        .loading {
            opacity:0.4;
            background:#ccc url('{{ asset('public/img/spin.gif')}}') no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:999999999;
            display: none;
        }
        .modal-header {
            padding:5px 10px 5px 20px !important;
        }
        .modal-footer {
            padding:10px !important;
        }
        .text-strong {
            font-weight: bold;
        }
        .alert-default {
            border: 1px solid #ccc;
        }
        .badge {
            background: #2fa597 !important;
        }
    </style>
</head>

<body class="nav-md">
<div class="loading"></div>
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ asset('validate') }}" class="site_title"><img src="{{ url('public/img/small_logo.png') }}" width="35"> <span>PHERC</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{ asset('public/panel') }}/images/{{$img}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        @if($user->level=='center')
                            <h2>REVIEW CENTER</h2>
                        @elseif($user->level=='admin')
                            <h2>Administrator</h2>
                        @elseif($user->level=='reviewee')
                            <h2>STUDENT</h2>
                        @else
                            <h2>{{ strtoupper($user->level) }}</h2>
                        @endif

                    </div>
                </div>
                <!-- /menu profile quick info -->
                <div class="clearfix"></div>
                @if($user->level==='admin')
                    @include('nav.admin')
                @elseif($user->level==='center')
                    @include('nav.center')
                @elseif($user->level==='instructor')
                    @include('nav.instructor')
                @elseif($user->level==='reviewee')
                    @include('nav.reviewee')
                @endif



            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('public/panel') }}/images/{{ $img }}" alt="">{{ $user->fname }} {{ $user->lname }}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="{{ asset('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        @include('modal.delete')
        @include('modal.accept')
        @include('modal.deleteFile')

        @if($user->level==='reviewee')
            @include('modal.feedback')
        @endif
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Philippine Exam Review Centers by <a href="#">Geneboy</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('public/panel') }}/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/panel') }}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="{{ asset('public/panel') }}/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="{{ asset('public/panel') }}/vendors/nprogress/nprogress.js"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('public/panel') }}/js/custom.min.js"></script>
@yield('js')

@if($status==='feedbackSent')
<script>
    $('#feedbackStatusModal').modal('show');
</script>
@endif
@if($status==='testimonySent')
<script>
    $('#testimonialStatusModal').modal('show');
</script>
@endif
</body>
</html>
