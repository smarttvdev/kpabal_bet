@extends('admin.layout.master')

@section('body')

    @php
    $totalusers = \App\User::count();
   $banusers = \App\User::where('status',0)->count();
   $activeusers = \App\User::where('status',1)->count();

    $events = \App\Event::whereStatus(1)->count();
    $now = Carbon\Carbon::now();
    $runningMatches = \App\Match::where('end_date','>', $now)->count();
    $endMatches = \App\Match::where('end_date','<', $now)->count();

    $deposit =  App\Gateway::count();
    $depositLog =  App\Deposit::whereStatus(1)->count();
    $withdrawMethod =  App\WithdrawMethod::count();
    $withdrawLog =  App\WithdrawLog::where('status','!=',0)->count();
    @endphp
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> {{$page_title}}
            </h3>
            <hr>


            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-users"></i> USERS STATISTICS </div>
                        </div>
                        <div class="portlet-body text-center">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="dashboard-stat blue">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{$totalusers}}">{{$totalusers}}</span>
                                            </div>
                                            <div class="desc"> Total Users </div>
                                        </div>
                                        <a class="more" href="{{route('users')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat purple">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{$activeusers}}">{{$activeusers}}</span>
                                            </div>
                                            <div class="desc"> Active Users </div>
                                        </div>
                                        <a class="more" href="{{route('users')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat red">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{$banusers }}">{{ $banusers }}</span>
                                            </div>
                                            <div class="desc"> Banned Users </div>
                                        </div>
                                        <a class="more" href="{{route('user.ban')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-play"></i> MATCH STATISTICS </div>
                        </div>
                        <div class="portlet-body text-center">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="dashboard-stat green">
                                        <div class="visual">
                                            <i class="fa fa-trophy"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{  $events }}">{{$events}}</span>
                                            </div>
                                            <div class="desc"> Running Events </div>
                                        </div>
                                        <a class="more" href="{{route('admin.events')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat yellow">
                                        <div class="visual">
                                            <i class="fa fa-play"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{ $runningMatches }}">{{ $runningMatches  }}</span>
                                            </div>
                                            <div class="desc"> Running Matches </div>
                                        </div>
                                        <a class="more" href="{{route('admin.matches')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat purple">
                                        <div class="visual">
                                            <i class="fa fa-play"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{  $endMatches}}">{{ $endMatches}}</span>
                                            </div>
                                            <div class="desc"> Close Matches </div>
                                        </div>
                                        <a class="more" href="{{route('close.matches')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box purple">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-money"></i> DEPOSITS & WITHDRAW STATISTICS </div>
                        </div>
                        <div class="portlet-body text-center">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="dashboard-stat blue">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{ $deposit}}">{{$deposit}}</span>
                                            </div>
                                            <div class="desc"> DEPOSIT METHODS </div>
                                        </div>
                                        <a class="more" href="{{route('gateway')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="dashboard-stat green">
                                        <div class="visual">
                                            <i class="fa fa-download"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{$depositLog  }}">{{$depositLog  }}</span>
                                            </div>
                                            <div class="desc"> DEPOSIT LOGS </div>
                                        </div>
                                        <a class="more" href="{{route('deposits')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat purple">
                                        <div class="visual">
                                            <i class="fa fa-google-wallet"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{  $withdrawMethod}}">{{ $withdrawMethod }}</span>
                                            </div>
                                            <div class="desc"> WITHDRAW METHODS</div>
                                        </div>
                                        <a class="more" href="{{route('withdraw')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat yellow">
                                        <div class="visual">
                                            <i class="fa fa-upload"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="{{$withdrawLog}}">{{$withdrawLog}}</span>
                                            </div>
                                            <div class="desc"> WITHDRAW LOGS</div>
                                        </div>
                                        <a class="more" href="{{route('withdraw.requests')}}"> View more
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>

@endsection