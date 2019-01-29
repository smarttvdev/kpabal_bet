<div class="widget-content">
        <div class="inplay_title">
            <h4>In-Play</h4>
        </div>


    <div class="widget__content card__content extar-margin">
        <div class="panel-group" id="accordion">
            @foreach($events as $data)
            <div class="panel pad1">
                <div class="panel-heading side-events-item">

                        <div class="left">
                            @php
                                $slug =$data->slug
                            @endphp
                            <a href="{{url('events/'.$data->id."/$slug")}}"><b>{{$data->name}}</b></a>
                        </div>
                        @if(count( $data->inplayes) > 0 )
                        <div class="right">
                            <a data-toggle="collapse" data-parent="#accordion"
                                              href="#collapse{{$data->id}}"><i class="fa fa-plus"></i>
                            </a>
                        </div>
                        @endif

                </div>

                <div id="collapse{{$data->id}}" class="panel-collapse collapse">
                    <div class="panel-body live-match-body">
                        <div class="live-matches-sidebar">
                            <ul>
                                @foreach($data->inplayes as $match)
                                <li>
                                    @php $slug = str_slug($match->name)@endphp
                                    <a href="{{url('/match/'.$match->id.'/'.$slug)}}">
                                        <i class="fa fa-arrow-right"></i> {{$match->name}} </a>

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach
        </div>
    </div>

</div>

