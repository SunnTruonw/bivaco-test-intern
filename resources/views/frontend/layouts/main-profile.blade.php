<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="noindex, nofollow, all" />
    <meta name="AUTHOR" content="Bivaco" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:image:alt" content="@yield('image')" />
    <meta name="google-site-verification" content="Rp0rKQX7aGO3qmBXosgmP6JK5pMpvmywzagSB1rqxpA" />

    <meta property="og:url" content="{{ makeLink('home') }}" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <link rel="canonical" href="{{ makeLink('home') }}" />
    <link rel="shortcut icon" href="{{URL::to('/favicon.ico')}}" />
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">
     {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet-2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/cart.css') }}">

    @yield('css')
    <style>
        #sidebar-profile{

        }
        .avatar{

        }
        .avatar h4{
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .avatar .media img{
            margin-top:0;
        }
        .avatar .media{
            align-items: center;
        }
        .wrap-profile-container{
            background-color: #f4f6f9;
            padding: 30px 0;
        }
        #sidebar-profile nav .nav-item{
            white-space: nowrap;
            border-bottom: 1px solid #e5e5e5;
        }
        #sidebar-profile nav .nav-item:last-child{
            border: unset;
        }
        .bg-left{
            background-color: #fff;
        }
        #sidebar-profile nav .nav-item .nav-link{
            white-space: nowrap;
            overflow: hidden;
        }
        #sidebar-profile nav .nav-item .nav-link p   {
            display: inline-block;
           margin: 0;
        }
        #sidebar-profile nav .nav-item .nav-link i{
            margin-right: 5px;
        }
        h1{
            font-size: 25px;
            font-weight: bold;
            margin-top: 0;
        }
        .card-title{
            margin: 0;
        }
        .card-title h3{
            margin: 0;
            font-size: 25px;
            font-weight: bold;
        }
    </style>
</head>

<body class="template-search">
    <div class="wrapper home">

        <!-- Navbar -->
        @include('frontend.partials.header')
        <!-- /.navbar -->
        <div class="wrap-profile-container">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 bg-left">
                        <div id="sidebar-profile" class="pt-3 pb-3">
                            <div class="avatar text-center p-3">
                               <a href="{{ route('profile.index') }}">
                                <img src="{{ $user->avatar_path?$user->avatar_path: $shareFrontend['userNoImage'] }}" alt="{{ $user->name }}" class="mb-3 rounded-circle" style="width:100px;">
                                <h4>{{ $user->name }}</h4>
                               </a>
                            </div>

                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.editInfo') }}">
                                            <i class="fas fa-edit"></i>
                                            <p> Chỉnh sửa thông tin</p>
                                        </a>
                                    </li>
                                    {{--
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listRose') }}">
                                            <i class="fas fa-list"></i>
                                            <p>  Danh sách hoa hồng</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.listMember') }}">
                                            <i class="fas fa-user-friends"></i>
                                            <p> Danh sách thành viên</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.createMember') }}">
                                            <i class="fas fa-user-plus"></i>
                                            <p> Thêm thành viên</p>
                                        </a>
                                    </li>
                                    --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.history') }}">
                                            <i class="fas fa-cart-plus"></i>
                                            <p>Quản lý đơn hàng</p>
                                        </a>
                                    </li>
                                </ul>
                             </nav>

                        </div>
                    </div>
                    <div class="col-sm-9">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>


        @include('frontend.partials.footer')


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
    <script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('lib/components/js/Cart.js') }}"></script>
    <script src="{{ asset('lib/components/js/Compare.js') }}"></script>
    <script>
        new WOW().init();
        $(function() {
            $(document).on('click','.pt_icon_right',function(){
                event.preventDefault();
                $(this).parent('a').parent('li').children("ul").slideToggle();
                $(this).parent('a').parent('li').toggleClass('active');
            });
            $(document).on('click','.btn-sb-toogle',function(){
                $(this).parents('.box-list-fill').find('.fill-list-item').slideToggle();
                $(this).toggleClass('active');
            });
        })
    </script>
    
    @yield('js')
</body>

</html>
