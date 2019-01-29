<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{$basic->sitename}} | {{$page_title}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Abir - abir@thesoftking.com" name="author"/>
    <link rel="icon" type="image/png" href="{{asset('assets/images/logo/favicon.png')}}" />

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{asset('assets/admin/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{asset('assets/admin/css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{asset('assets/admin/css/plugins.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/layout.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{asset('assets/admin/css/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap-modal-bs3patch.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-fileinput.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>

    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        <div class="page-logo">
            <a href="{{route('admin.dashboard')}}">
                <img src="{{asset('assets/images/logo/logo.png')}}" alt="logo" class="logo-default"
                     style="width: 160px; height: 20px; filter: brightness(0) invert(1);"> </a>

            <div class="menu-toggler sidebar-toggler"></div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>

        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <img alt="" class="img-circle" src="{{asset('assets/admin/img/'.Auth::guard('admin')->user()->image)}}" />
                        <span class="username"> {{ Auth::guard('admin')->user()->username }}  </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li><a href="{{route('admin.changePass')}}"><i class="fa fa-cog"></i> Change Password </a></li>
                        <li><a href="{{route('admin.profile')}}"><i class="fa fa-user"></i> Profile Management </a></li>
                        <li><a href="{{route('admin.logout')}}"><i class="fa fa-sign-out"></i> Log Out </a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">

                <!-- <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler"> </div>


</li> -->

                <li class="nav-item start @if(request()->path() == 'admin/dashboard') active open @endif">
                    <a href="{{route('admin.dashboard')}}" class="nav-link "><i class="fa fa-home"></i><span
                                class="title">Dashboard</span></a>
                </li>


                <li class="nav-item start @if(request()->path() == 'admin/events') active open @endif">
                    <a href="{{route('admin.events')}}" class="nav-link "><i class="fa fa-trophy"></i><span
                                class="title">Manage Events</span></a>
                </li>
                <li class="nav-item start @if(request()->path() == 'admin/matches') active open @endif">
                    <a href="{{route('admin.matches')}}" class="nav-link "><i class="fa fa-play"></i><span
                                class="title">Manage Match</span></a>
                </li>

                <li class="nav-item start @if(request()->path() == 'admin/closed-matches') active open @endif">
                    <a href="{{route('close.matches')}}" class="nav-link "><i class="fa fa-play"></i><span
                                class="title">Bet Closed Match</span></a>
                </li>

                <li class="nav-item start @if(request()->path() == 'admin/winner') active open @endif">
                    <a href="{{route('awaiting.winner')}}" class="nav-link "><i class="fa fa-trophy"></i><span
                                class="title">Awaiting Winner</span></a>
                </li>


                <li class="nav-item @if(request()->path() == 'admin/users') active open
                @elseif(request()->path() == 'admin/user-banned') active open
                @elseif(request()->path() == 'admin/user/{user}') active open
                        @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title"> Manage User</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <a href="{{route('users')}}" class="nav-link ">
                                <i class="fa fa-users"></i>
                                <span class="title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('user.ban')}}" class="nav-link ">
                                <i class="fa fa-user"></i>
                                <span class="title">Banned User</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item @if(request()->path() == 'admin/gateway') active open
                @elseif(request()->path() == 'admin/deposits') active open

                        @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-credit-card"></i>
                        <span class="title"> Manage Deposit</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        <li class="nav-item  ">
                            <a href="{{route('deposits')}}" class="nav-link ">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Deposit Log</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('gateway')}}" class="nav-link ">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Deposit Method</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(request()->path() == 'admin/withdraw') active open
                @elseif(request()->path() == 'admin/withdraw/requests') active open
                        @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-credit-card"></i>
                        <span class="title"> Manage Withdraw</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <a href="{{route('withdraw.requests')}}" class="nav-link ">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Withdraw Request</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('withdraw')}}" class="nav-link ">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Withdraw Methods</span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item

                                @if(request()->path() == 'admin/general-settings') active open
                                @elseif(request()->path() == 'admin/template') active open
                                @elseif(request()->path() == 'admin/sms-api') active open
                                @elseif(request()->path() == 'admin/contact-setting') active open
                            @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-bars"></i>
                        <span class="title">Website Control</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.GenSetting')}}" class="nav-link"><i class="fa fa-cogs"></i> General
                                Setting </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('email.template')}}" class="nav-link"><i class="fa fa-envelope"></i> Email Setting </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sms.api')}}" class="nav-link"><i class="fa fa-mobile"></i> SMS Setting </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contact-setting')}}" class="nav-link"><i class="fa fa-phone"></i> Contact Setting </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item

                                @if(request()->path() == 'admin/manage-logo') active open
                                @elseif(request()->path() == 'admin/manage-footer') active open
                                @elseif(request()->path() == 'admin/manage-social') active open
                                @elseif(request()->path() == 'admin/menu-control') active open
                                @elseif(request()->path() == 'admin/manage-breadcrumb') active open
                                @elseif(request()->path() == 'admin/manage-about') active open
                                @elseif(request()->path() == 'admin/advertisement') active open
                                @elseif(request()->path() == 'admin/faqs-create') active open
                                @elseif(request()->path() == 'admin/faqs-all') active open
                            @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                        <span class="title">Interface  Control</span><span class="arrow"></span></a>
                    <ul class="sub-menu">

                        <li class="nav-item  ">
                            <a href="{{route('manage-logo')}}" class="nav-link ">
                                <i class="fa fa-photo"></i>
                                <span class="title">Logo & favicon  </span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('manage-footer')}}" class="nav-link ">
                                <i class="fa fa-file-text"></i>
                                <span class="title">Manage Footer</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('manage-social')}}" class="nav-link ">
                                <i class="fa fa-share-alt-square"></i>
                                <span class="title">Manage Social</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('menu-control')}}" class="nav-link ">
                                <i class="fa fa-desktop"></i>
                                <span class="title">Menu Control</span>
                            </a>
                        </li>

                        <li class="nav-item  ">
                            <a href="{{route('manage-breadcrumb')}}" class="nav-link ">
                                <i class="fa fa-apple"></i>
                                <span class="title">Manage Breadcrumb </span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{route('manage-about')}}" class="nav-link ">
                                <i class="fa fa-info-circle"></i>
                                <span class="title">Manage About </span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{url('admin/advertisement')}}" class="nav-link ">
                                <i class="fa fa-image"></i>
                                <span class="title">Manage Advertisement </span>
                            </a>
                        </li>


                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-arrows"></i>
                                <span class="title">Manage FAQS</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{route('faqs-create')}}" class="nav-link ">
                                        <i class="fa fa-plus"></i>
                                        <span class="title">New Question </span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{route('faqs-all')}}" class="nav-link ">
                                        <i class="fa fa-desktop"></i>
                                        <span class="title">All Question </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </li>

            </ul>
        </div>
    </div>


    @yield('body')


</div>
<div class="page-footer">
    <div class="page-footer-inner"> {{$basic->	copyright}}</div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>


<!-- JavaScripts -->
<script src="{{asset('assets/admin/js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.blockui.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/ui-toastr.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/js/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/table-datatables-buttons.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-fileinput.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/js/bootstrap-modalmanager.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-modal.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('assets/admin/js/components-date-time-pickers.min.js')}}"></script>

@yield('script')

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