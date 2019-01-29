@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> {{$page_title}}
                <a href="{{route('admin.matches')}}" class="btn btn-success  btn-md pull-right edit_button">
                    <i class="fa fa-eye"></i> View Matches
                </a>
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{route('update.match')}}" method="post" name="editForm">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$match->id}}">
                        <div class="form-group  ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Select Event</span>
                                <select name="event_id" id="" class="form-control">
                                    <option value="">Select Event</option>
                                    @foreach($events as $data)
                                        <option value="{{$data->id}}" @if($match->event_id == $data->id) selected @endif>{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('event_id'))
                                <div class="error">{{ $errors->first('event_id') }}</div>
                            @endif
                        </div>

                        <div class="form-group ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Match </span>
                                <input type="text" name="name" value="{{$match->name}}" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Youtube Video </span>
                                <input type="text" name="src" value="{{$match->src}}" class="form-control" placeholder="Youtube Embedded Code">
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="input-group input-group-lg ">
                                <span class="input-group-addon" id="sizing-addon1">Start Date</span>
                                <input type="text" value="{{Carbon\carbon::parse($match->start_date)->format('d-m-Y  H:i:s ')}}" class="form-control input-lg datepicker" id="start_date" name="start_date">
                                <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                            </div>
                            @if ($errors->has('start_date'))
                                <div class="error">{{ $errors->first('start_date') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-lg ">
                                <span class="input-group-addon" id="sizing-addon1">End Date</span>
                                <input type="text" value="{{Carbon\carbon::parse($match->end_date)->format('d-m-Y H:i:s')}}" class="form-control input-lg datepicker" id="start_date" name="end_date">
                                <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                            </div>
                            @if ($errors->has('end_date'))
                                <div class="error">{{ $errors->first('end_date') }}</div>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="" style="text-transform: uppercase; font-weight: bold">STATUS</label>
                            <input data-toggle="toggle" data-size="large" data-onstyle="success" data-offstyle="danger"
                                   data-width="100%" type="checkbox" data-on="Active" data-off="DeActive"
                                   name="status" {{ $match->status == "1" ? 'checked' : '' }}>

                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        

        $(document).ready(function () {
            $(function () {
                $('.datepicker').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
            });
        });
    </script>
@stop