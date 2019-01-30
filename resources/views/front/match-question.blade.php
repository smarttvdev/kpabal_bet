@extends('layout')

@section('content')

    <div class="bet-section" id="min-height-match-ques">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <aside class="widget card widget--sidebar widget-standings">
                        @include('partials.event')
                        {!!  show_add(1)!!}
                    </aside>
                </div>
                <div class="col-md-6">
                    <div class="panel custom-panel-bg panel-default widget-content panel-content" style="margin-bottom:15px;">

                        <div class="panel-heading">
                            <div class="widget_title1" style="background-color: #008ae6;">
                                <h4>{!! $match->name !!}</h4>
                            </div>
                        </div>
<style>
    .videoWrapper,iframe{
        width:100%;
        
    }
</style>
                        <div class="panel-body bet-body">
                            @if($match->src != null)
                                <div class="col-md-12">
                                    <div class="videoWrapper">
                                        {!! $match->src !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <button class="btn btn-block bs-callout  bs-callout-info " style="background-color: #004466;">
                                    Match will Expire in <span id="counting{{$match->id}}"></span>
                                </button>
                            </div>
                            <script>
                                // Set the date we're counting down to
                                var countDownDate = new Date("{{$match->end_date}}").getTime();

                                // Update the count down every 1 second
                                var x = setInterval(function () {

                                    // Get todays date and time
                                    var now = new Date().getTime();

                                    // Find the distance between now an the count down date
                                    var distance = countDownDate - now;

                                    // Time calculations for days, hours, minutes and seconds
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    // Output the result in an element with id="demo"
                                    document.getElementById("counting{{$match->id}}").innerHTML = days + " Day  " + hours + "h "
                                        + minutes + "m " + seconds + "s ";

                                    // If the count down is over, write some text
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("counting{{$match->id}}").innerHTML = "EXPIRED";
                                    }
                                }, 1000);
                            </script>


                                @php
                                    $now = \Carbon\Carbon::now();
                                    $q = \App\BetQuestion::where('end_time','<', $now)->get();
                                    foreach ($q as $d) {
                                        $d->status = 2;
                                        $d->save();
                                    }
                                @endphp


                            @if(count($question) > 0)
                                <div class="col-md-12">
                                    <h6 class="bet-q"><b> Bet Questions :</b></h6>
                                    <br>
                                </div>
                                @foreach($question as $data)
                                    @if($data->end_time > \Carbon\Carbon::now())
                                    @php
                                        $slug =str_slug($data->question);
                                    @endphp
                                    <div class="col-md-12">
                                        <a href="{{url('option/'.$data->id."/$slug")}}"
                                           class="btn btn-block bs-callout bs-callout-warning bet-option  white" style="background-color: #ffff00;color:black;">{!! $data->question !!}</a>
                                    </div>
                                    @else
                                            <div class="col-md-12">
                                        <strong>No question found!!</strong>
                                            </div>
                                        @endif
                                @endforeach
                            @endif


                        </div>

                    </div>
                    <br>
                    {!!  show_add(2)!!}


                </div>

                <aside>
                    <div class="col-md-3">
                        {!!  show_add(3)!!}

                    </div>
                </aside>

            </div>
        </div>

    </div>


    <script>
        (function ($) {
            $(window).on('resize', function () {
                var bodyHeight = $(window).height();
                $('#min-height-match-ques').css('min-height', parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-match-ques').css('min-height', parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>


@stop

