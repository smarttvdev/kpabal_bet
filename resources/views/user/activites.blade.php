@extends('user')
@section('content')

    @include('partials.breadcrumb')

    <section class="about-section section-padding-2 section-bg-clr1" id="min-height-activity">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{$page_title}}
                            </div>

                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Match</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Threat</th>
                                    <th scope="col"> Bet Amount</th>
                                    <th scope="col"> Return Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invests as $k=>$data)
                                    <tr>
                                        <td  data-label="SL">{{++$k}}</td>
                                        <td  data-label="Match">
                                            @php
                                                $slug =$data->match->slug
                                            @endphp
                                            <a href="{{url('match/'.$data->match->id.'/'.str_slug($data->match->name))}}">
                                            {{$data->match->name or 'N/A'}}
                                            </a>
                                        </td>
                                        @php
                                            $question = App\BetQuestion::whereId($data->betoption->question_id)->first();
                                        @endphp
                                        <td  data-label="Question">{!! $question->question  or 'N/A' !!}</td>
                                        <td  data-label="Threat">{!! $data->betoption->option_name  or 'N/A' !!} </td>
                                        <td  data-label="Bet Amount">{!! $data->invest_amount  or 'N/A' !!} {!! $basic->currency !!}</td>
                                        <td  data-label="Return Amount">{!! $data->	return_amount  or 'N/A' !!} {!! $basic->currency !!}</td>

                                        <td  data-label="Status">
                                            @if($data->status  == 1)
                                            <b class="btn btn-sm btn-success">Win</b>
                                                @elseif($data->status  == -1)
                                                <b class="btn btn-sm btn-danger">Lose</b>
                                            @elseif($data->status  == 0)
                                                <b class="btn btn-sm btn-warning">Processing</b>
                                                @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $invests->links()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Hostonion End -->



    <script>
        (function($){
            $(window).on('resize',function(){
                var bodyHeight = $(window).height();
                $('#min-height-activity').css('min-height',parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-activity').css('min-height',parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>


@stop