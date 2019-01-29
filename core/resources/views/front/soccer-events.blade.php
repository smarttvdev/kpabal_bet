@extends('layout')

@section('content')

    <div class="bet-section" id="min-height-event">
        <div class="container">
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
                    @php $i =0 ;@endphp
                    @foreach($matches as $data)
                    <?php   $name = getcompetitorName($data->match_id);
                            $dataName = unserialize($name->competitors);
                            $competitorId = $dataName[0]->name.'-vs-'.$dataName[1]->name;
                            $competitorName = $dataName[0]->name.' vs '.$dataName[1]->name;
                    ?>
                        @php
                         $i++;
                         
                        @endphp
                        <div class="panel custom-panel-bg panel-default widget-content panel-content" style="margin-bottom:15px;">
                            <div class="panel-heading">
                                <div class="widget_title1">
                                    <a href="{{url('/soccer-match/'.$data->match_id.'/'.str_slug($competitorId))}}">
                                     
                                        <h4>{{$competitorName}}</h4>
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

                                <!--<div class="col-md-4 col-md-offset-2">-->
                                <!--    <a href="{{url('match/'.$data->id.'/'.str_slug($data->name))}}"-->
                                <!--       class="btn btn-block bs-callout bs-callout-warning bet-option text-center white">Continue... </a>-->
                                <!--</div>-->

                            </div>
                        </div>

                                                  
                        
                        
                    @endforeach


                </div>


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

