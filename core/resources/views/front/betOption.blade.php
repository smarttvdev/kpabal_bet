@extends('layout')

@section('content')
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }
    </style>

    <div class="bet-section" id="min-height-option">
        <div class="container">
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
                            <div class="betOption">
                                <h5>{{$ques->question}} </h5>
                                <small><b>{{$ques->match->name }}</b></small>
                            </div>
                        </div>

                        <div class="panel-body bet-body">

                            @if($ques->match->src != null)
                                <div class="rwo">
                                    <div class="col-md-12">
                                        <div class="videoWrapper">
                                            {!! $ques->match->src !!}
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if($ques->end_time >= Carbon\Carbon::now())
                                @php
                                    $now = Carbon\Carbon::now();
                                @endphp
                                @if($ques->match->end_date > $now)
                                    <div class="col-md-12">
                                        <button class="btn btn-block bs-callout bs-callout-warning  ">
                                            Bet will be expired in <span id="countTimer{{$ques->id}}"></span>
                                        </button>
                                    </div>
                                    @foreach($bets as $data)
                                        <div class="col-md-6">
                                            @if(Auth::user())
                                                <div class="bs-callout bs-callout-warning bet-option open_modal_for_bet"
                                                     data-toggle="modal" data-id="{{$data->id}}"
                                                     data-target="#myModal{{$data->id}}">
                                                    <b> {{$data->option_name}} <span class="pull-right">{{$data->ratio1}}
                                                            : {{$data->ratio2}} </span> </b>
                                                </div>
                                            @else
                                                <a href="{{route('login')}}">
                                                    <div class="bs-callout bs-callout-warning bet-option open_modal_for_bet">
                                                        <b> {{$data->option_name}} <span class="pull-right">{{$data->ratio1}}
                                                                : {{$data->ratio2}} </span> </b>
                                                    </div>
                                                </a>
                                            @endif
                                        </div>
                                        <!-- Modal for Edit button -->
                                        <div class="modal fade" id="myModal{{$data->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">&times;
                                                        </button>
                                                        <h4 class="modal-title">Bet Option </h4>
                                                    </div>
                                                    <form action="{{route('betByUser')}}" method="post">
                                                        {{csrf_field()}}
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                @if(Auth::user())
                                                                    <input type="hidden" value="{{Auth::user()->id}}"
                                                                           name="user_id">
                                                                @endif
                                                                <label><strong>Invest Amount </strong></label>
                                                                <input class="form-control ronnie_id" type="hidden"
                                                                       value="{{$data->id}}" name="betoption_id">

                                                                <input class="form-control ronnie_id" type="hidden"
                                                                       value="{{$ques->match->id}}" name="match_id">

                                                                <input class="form-control ratio1" type="hidden"
                                                                       value="{{$data->ratio1}}">
                                                                <input class="form-control ratio2" type="hidden"
                                                                       value="{{$data->ratio2}}">
                                                                <input type="text"
                                                                       class="form-control input-lg ronnie_bet get_amount_for_ratio"
                                                                       name="invest_amount" placeholder=" Amount"
                                                                       required>
                                                                <code>Minimum Bet
                                                                    Amount {{$data->min_amo}} {{$basic->currency}}</code>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><strong>Return Amount</strong> (If You
                                                                    win)</label>
                                                                <input class="form-control input-lg ronnie_ratio"
                                                                       name="return_amount" placeholder="Return Amount" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">No
                                                            </button>
                                                            <button type="submit" class="btn btn-success">Send</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                @else

                                    @php
                                        $dd = App\Match::find($ques->match->id);
                                       $dd->status = 2;
                                       $dd->save();
                                    @endphp
                                    <div class="col-md-12">
                                        <button class="btn btn-block bs-callout bs-callout-warning  ">
                                            Already Expired !!
                                        </button>
                                    </div>

                                @endif

                            @else
                                    <br>
                                <h5 class="red text-center">Bet  Time out</h5>
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
        // Set the date we're counting down to
        var countDownDate = new Date("{{$ques->end_time}}").getTime();

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
            document.getElementById("countTimer{{$ques->id}}").innerHTML = days + " Day " + hours + "h "
                + minutes + "m " + seconds + "s ";

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countTimer{{$ques->id}}").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('keyup', '.get_amount_for_ratio', function () {
                var $selector = $(this);
                setTimeout(function () {
                    let amount = $selector.val();
                    let ratio1 = $selector.siblings('.ratio1').val();
                    let ratio2 = $selector.siblings('.ratio2').val();
                    // console.log({'raton1':ratio1,'ratio2':ratio2,'amount':amount})
                    let finalRation = parseFloat((amount * ratio2) / ratio1).toFixed(2);
                    $selector.parent().parent().children().children('.ronnie_ratio').val(finalRation);
                }, 500);
            });
        });
    </script>

    <script>
        (function ($) {
            $(window).on('resize', function () {
                var bodyHeight = $(window).height();
                $('#min-height-option').css('min-height', parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-option').css('min-height', parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>


@stop

