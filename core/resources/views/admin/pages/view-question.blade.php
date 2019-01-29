@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Questions LIST</span>
                    </div>
                    <a href="{{route('add.question',$match_id->id)}}" class="btn btn-success btn-md pull-right edit_button">
                        <i class="fa fa-plus"></i> Add More Question
                    </a>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Question</th>
                            <th>Options</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $k=>$data)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{!! $data->question !!}</td>
                                <td>
                                    <a href="{{route('view.option', $data->id )}}" class="btn btn-info btn-md edit_button" title="View Question">
                                        <strong>{{$data->options()->count()}}</strong>
                                    </a>
                                </td>
                                <td>
                                    <b class="btn btn-sm btn-{{ $data->status ==0 ? 'warning' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</b>
                                </td>
                                <td>
                                    <button type="button" class="btn purple btn-sm edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-act="Edit"
                                            data-name="{{$data->question}}"
                                            data-datetime="{{$data->end_time}}"
                                            data-status="{{$data->status}}"
                                            data-id="{{$data->id}}"
                                            data-mid="{{$data->match_id}}">
                                        <i class="fa fa-edit"></i> EDIT
                                    </button>
                                    <a href="{{route('view.option',$data->id)}}" class="btn blue btn-sm edit_button">
                                        <i class="fa fa-eye"></i> View Option
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $questions->links()!!}
                </div>
            </div>

        </div>
    </div>


    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Questions </h4>
            </div>
            <form method="post" action="{{route('update.question')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            <strong>Question</strong>
                        </label>
                        <input class="form-control ronnie_id" type="hidden" name="id">
                        <input class="form-control input-lg ronnie_question" name="question"  required>
                        <br>
                        <input class="form-control input-lg ronnie_match_id" name="match_id"  type="hidden" >
                    </div>
                    <div class="form-group">
                        <label for="">
                            <strong>End Date</strong>
                        </label>
                        <input class="form-control input-lg datepicker ronnie_end_time" name="end_time"  required>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="">
                            <strong>Status</strong>
                        </label>
                        <select name="status" class="form-control input-lg ronnie_status" required>
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
                        <br>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var name = $(this).data('name');
                var end_time = $(this).data('datetime');
                var status = $(this).data('status');
                var mid = $(this).data('mid');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_question").val(name);
                $(".ronnie_match_id").val(mid);
                $(".ronnie_end_time").val(end_time);
                $(".ronnie_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });
        });
    </script>
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
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            });
        });
    </script>
@stop
