@extends('layout')

@section('content')

    <div class="bet-section" id="min-height-event">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="widget card widget--sidebar widget-standings">
                        {!!  show_add(1)!!}
                        @include('partials.event')
                        {!!  show_add(3)!!}
                    </aside>
                </div>
                <div class="col-md-6">
                    @php $i =0 ;@endphp
                    @foreach($matches as $data)
                        @php
                         $i++;
                            $slug =$data->slug
                        @endphp
                        <div class="panel custom-panel-bg panel-default widget-content panel-content" style="margin-bottom:15px;">
                            <div class="panel-heading">
                                <div class="widget_title1">
                                    <a href="{{url('match/'.$data->id.'/'.str_slug($data->name))}}">
                                        <h4>{!! $data->name !!}</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body bet-body">
                                <div class="col-md-8">
                                    <button class="btn btn-block bs-callout bs-callout-warning  ">
                                        Expire in

                                        <span id="tsk{{$data->id}}">@php
                                                if($data->end_date){
                                                      $edate = Carbon\Carbon::parse($data->end_date);
                                                      $now = Carbon\Carbon::now();
                                                      $coutd = $edate->diffInSeconds($now);
                                                      $iid = "tsk".$data->id;
                                                      echo "<script>
                                                            $(function () {
                                                                var etm = $coutd;
                                                                var $iid = $('#$iid'),
                                                               ts = (new Date()).getTime() + etm * 1000;

                                                                $('#countdown').countdown({
                                                                    timestamp: ts,
                                                                    callback: function (days, hours, minutes, seconds) {

                                                                        var message = \"\";
                                                                        if (days>0) {
                                                                        message += days + \"Day  \" + \" \";
                                                                    }
                                                                        message += hours + \"h \" + \" \";
                                                                        message += minutes + \"m\" + \" \";
                                                                        message += seconds + \"s \" + \" \";
                                                                        $iid.html(message);
                                                                    }
                                                                });

                                                            });
                                                        </script>";
                             
                                                }else{
                                                echo "Date Expired";
                                                }
                                            @endphp</span>
                                    </button>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{url('match/'.$data->id.'/'.str_slug($data->name))}}"
                                       class="btn btn-block bs-callout bs-callout-warning bet-option text-center white">{{$data->questionsEndTime()->count()}}
                                        Bet Available </a>
                                </div>
                                <!--<div class="col-md-4 col-md-offset-2">-->
                                <!--    <a href="{{url('match/'.$data->id.'/'.str_slug($data->name))}}"-->
                                <!--       class="btn btn-block bs-callout bs-callout-warning bet-option text-center white">Continue... </a>-->
                                <!--</div>-->

                            </div>
                        </div>

                                                                            
                                                    @if($i%2==0)
                            {!!  show_add(2)!!}
                                                    @endif
                        
                        
                    @endforeach


                </div>

                <aside>
                    <div class="col-md-3">
                        {!!  show_add(1) !!}
                        {!!  show_add(1) !!}
                        {!!  show_add(3) !!}
                        {!!  show_add(1)!!}
                    </div>
                </aside>

            </div>
        </div>

    </div>

    <script>
        (function ($) {
            $(window).on('resize', function () {
                var bodyHeight = $(window).height();
                $('#min-height-event').css('min-height', parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-event').css('min-height', parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>
@stop

