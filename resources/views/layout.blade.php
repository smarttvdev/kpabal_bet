<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$basic->sitename}} </title>
    <!--Favicon add-->
    <link rel="icon" type="image/png" href="{{asset('assets/images/logo/favicon.png')}}" />
    <!--bootstrap Css-->
    <link href="{{asset('assets/front/css/bootstrap.min.css')}}" rel="stylesheet">
    <!--font-awesome Css-->
    <link href="{{asset('assets/front/css/font-awesome.min.css')}}" rel="stylesheet">
    <!--Swiper  Css-->
    <link href="{{asset('assets/front/css/swiper.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/front/css/toastr.min.css')}}" rel="stylesheet">
    <!--Style Css-->
    <link href="{{asset('assets/front/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/front/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/front/css/table.css')}}" rel="stylesheet">

    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/style.php')}}?color={{ $basic->color }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/bg_color.php')}}?bg_color={{ $basic->bg_color }}">

    <link href="{{asset('assets/front/css/responsive.css')}}" rel="stylesheet">
    <!--jquery script load-->
    <script src="{{asset('assets/front/js/jquery.js')}}"></script>
    <script src="{{asset('assets/front/js/jquery.countdown.js')}}"></script>

</head>

<body>
    <!--loader-->
    <div id="preloader">
        <div class="sk-circle">
            <div class="sk-circle1 sk-child"></div>
            <div class="sk-circle2 sk-child"></div>
            <div class="sk-circle3 sk-child"></div>
            <div class="sk-circle4 sk-child"></div>
            <div class="sk-circle5 sk-child"></div>
            <div class="sk-circle6 sk-child"></div>
            <div class="sk-circle7 sk-child"></div>
            <div class="sk-circle8 sk-child"></div>
            <div class="sk-circle9 sk-child"></div>
            <div class="sk-circle10 sk-child"></div>
            <div class="sk-circle11 sk-child"></div>
            <div class="sk-circle12 sk-child"></div>
        </div>
    </div>
    <!--loader-->

    <!--support bar  top start-->
    <div class="support-bar-top" id="raindrops-green">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <ul>
                            <li><a href="#"> <i class="fa fa-envelope email" aria-hidden="true"></i>{{ $basic->email }}</a></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i>{{ $basic->phone }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="contact-admin">
                        @if(!Auth::user())
                        <a href="{{route('login')}}"><i class="fa fa-user"></i> Login</a>
                        <a href="{{route('register')}}"><i class="fa fa-user-plus"></i> Registration</a>
                        @else
                            <a href=""><i class="fa fa-money"></i> Balance : {{number_format(Auth::user()->balance, $basic->decimal)}} {{$basic->currency}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--support bar  top end-->
    <header style="position: sticky;top: 0;z-index: 1;">
        <!-- Header bottom start -->
        <div class="header-bottom header header-wrapper sticky-top">
            <nav class="navbar navbar-default" style="background-color:#fff;border: none;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand " href="{{route('homepage')}}"><img src="{{asset('assets/images/logo/logo.png')}}" alt="logo"></a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="height:68px !important;">
                                <ul class="nav navbar-nav" id="header-menu">
                                    <li><a href="{{route('homepage')}}"> Home</a></li>
                                    <li><a href="{{url('soccer/news/feed')}}">Soccer News</a></li>
                                    <li><a href="{{route('homepage')}}">Soccer Betting</a></li>

                                    <li><a href="{{url('about-us')}}">ABout Us</a></li>
                                    <li><a href="{{url('/faqs')}}"> FAQS</a></li>
                                    <li><a href="{{url('/contact-us')}}"> Contact</a></li>

                                    @if(Auth::user())
                                        <li><a href="{{route('home')}}"> <strong>Dashboard</strong></a></li>
                                    @endif

                                </ul>

                            </div><!-- /.navbar-collapse -->

                        </div>
                    </div>
                </div>
            </nav><!-- nav -->
        </div>
        <!-- header-bottom end -->
    </header>
    <!-- header section end -->
    {{--<div class="clearfix"></div>--}}

    @yield('content')

    {{--<div class="clearfix"></div>--}}
    @include('partials.footer')

    <!--Bootstrap v3 script load here-->
    <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
    <!--Swiper script load-->
    <script src="{{asset('assets/front/js/swiper.min.js')}}"></script>
    <!--CounterUp script load-->
    <script src="{{asset('assets/front/js/jquery.counterup.min.js')}}"></script>
    <!--WayPoints script load-->
    <script src="{{asset('assets/front/js/waypoints.min.js')}}"></script>
    <!--Jquery Ui Slider script load-->
    <script src="{{asset('assets/front/js/jquery-ui-slider.min.js')}}"></script>
    <!-- Highlight script load-->
    <script src="{{asset('assets/front/js/highlight.min.js')}}"></script>
    <!--RainDrops script load-->
    <script src="{{asset('assets/front/js/toastr.min.js')}}"></script>

    <!--Main js file load-->
    <script src="{{asset('assets/front/js/main.js')}}"></script>

    @if (session('success'))
        <script type="text/javascript">
            $(document).ready(function () {
                swal("Success!", "{{ session('success') }}", "success");
            });
        </script>
    @endif

    @if (session('alert'))
        <script type="text/javascript">
            $(document).ready(function () {
                swal("Sorry!", "{{ session('alert') }}", "error");
            });
        </script>
    @endif


    <script type="text/javascript">
        @if(Session::has('message'))
            var type = "{{Session::get('alert-type','info')}}";
            switch (type) {
                case 'info':
                    toastr.info("{{Session::get('message')}}");
                    break;

                case 'warning':
                    toastr.warning("{{Session::get('message')}}");
                    break;

                case 'success':
                    toastr.success("{{Session::get('message')}}");
                    break;

                case 'error':
                    toastr.error("{{Session::get('message')}}");
                    break;

            }
        @endif
    </script>
</body>
</html>
