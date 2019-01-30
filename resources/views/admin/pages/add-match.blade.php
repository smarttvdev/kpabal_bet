@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> {{$page_title}}
                <a href="{{route('admin.matches')}}" class="btn btn-success btn-md pull-right edit_button">
                    <i class="fa fa-eye"></i> View Matches
                </a>
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="" method="post">
                        {{csrf_field()}}

                        <div class="form-group  ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Status</span>
                                <select name="event_id" id="" class="form-control">
                                    <option value="">Select Event</option>
                                    @foreach($events as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
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
                                <input type="text" name="name" class="form-control" placeholder="Match Name">
                            </div>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Youtube Video </span>
                                <input type="text" name="src" class="form-control" placeholder="Youtube Embedded Code">
                            </div>
                        </div>



                            <div class="form-group">
                                <div class="input-group input-group-lg ">
                                    <span class="input-group-addon" id="sizing-addon1">Start Date</span>
                                    <input type="text" class="form-control input-lg datepicker" id="start_date" name="start_date">
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
                                    <input type="text" class="form-control input-lg datepicker" id="start_date" name="end_date">
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
                            <input data-toggle="toggle" data-size="large" data-on="Active" data-off="DeActive" data-onstyle="success" data-offstyle="danger"
                                   data-width="100%" type="checkbox"
                                   name="status">
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
        $(function () {
            $('#datetimepicker2').datetimepicker({
                language: 'en',
                pick12HourFormat: true
            });
        });

        $(document).ready(function () {
            $(function () {
                $('.datepicker').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm'
                });
            });
        });
    </script>
@stop
