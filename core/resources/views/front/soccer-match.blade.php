@extends('layout')

@section('content')

    <div class="bet-section" id="min-height-match-ques">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                     <aside class="widget card widget--sidebar widget-standings">

                        <div class="widget-content">
        <div class="inplay_title">
            <h4>Soccer</h4>
        </div>


    <div class="widget__content card__content extar-margin">
        <div class="panel-group" id="accordions">
            @foreach($soccer as $data)
            <div class="panel pad1">
                <div class="panel-heading side-events-item">

                        <div class="left">
                            @php
                                $slug =$data->tournament_name
                            @endphp
                            <a href="{{url('/soccer-event/'.$data->id.'/'.str_slug($slug))}}"><b>{{$data->tournament_name}}</b></a>
                        </div>
                        <?php $competitors = unserialize($data->competitors); ?>
                              
                        @if(count( $competitors) > 0 )
                        <div class="right">
                            <a data-toggle="collapse" data-parent="#accordions"
                                              href="#collapses{{$data->id}}"><i class="fa fa-plus"></i>
                            </a>
                        </div>
                        @endif
                       
                </div>
                <div id="collapses{{$data->id}}" class="panel-collapse collapse">
                    <div class="panel-body live-match-body">
                        <div class="live-matches-sidebar">
                            <ul>
                                
                                <?php $getcompetitors = getcompetitors($data->tournament_name); 
                                foreach ($getcompetitors as $key => $value) {
                                    $data = unserialize($value->competitors);
                                    $name = getcompetitorName($value->match_id);
                                    $dataName = unserialize($name->competitors);
                                    $competitorId = $dataName[0]->name.'-vs-'.$dataName[1]->name;
                                    echo '<li><a><i class="fa fa-arrow-right"></i></a>';
                                    foreach ($data as $key => $dataval) { 
                                   ?>
                                                                   
                                    <a href="{{url('/soccer-match/'.$value->match_id.'/'.str_slug($competitorId))}}">
                                     
                                       @if($key==1)
                                       <span>vs</span>
                                       @endif{{$dataval->name}} </a>

                                <?php    
                                } echo '</li>';}
                                ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                    @endforeach
                            </div>
                        </div>

                    </div>

                    </aside>
                </div>
                <div class="col-md-6">
                    <div class="panel custom-panel-bg panel-default widget-content panel-content" style="margin-bottom:15px;">
                        <?php 
                        $name = getcompetitorName($match->match_id);
                                    $dataName = unserialize($name->competitors);
                                    $competitorName = $dataName[0]->name.' vs '.$dataName[1]->name;
                        ?>

                        <div class="panel-heading">
                            <div class="widget_title1" style="background-color: #008ae6;">
                                <h4>{!! $competitorName !!}</h4>
                            </div>
                        </div>

                        <div class="panel-body bet-body">
                           
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



                        </div>

                    </div>


                </div>


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

