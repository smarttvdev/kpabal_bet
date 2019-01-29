@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}
                <button type="button" class="btn btn-success btn-md pull-right edit_button"
                        data-toggle="modal" data-target="#myModal"
                        data-act="Add New"
                        data-name=""
                        data-id="0">
                    <i class="fa fa-plus"></i> ADD Event
                </button>
            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Event LIST</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($events as $k=>$mac)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$mac->name}}</td>
                                <td>
                                    <b class="btn btn-md btn-{{ $mac->status ==0 ? 'warning' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</b>
                                </td>
                                <td>
                                    <button type="button" class="btn purple btn-sm edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-act="Edit"
                                            data-name="{{$mac->name}}"
                                            data-status="{{$mac->status}}"
                                            data-id="{{$mac->id}}">
                                        <i class="fa fa-edit"></i> EDIT
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Event </h4>
            </div>
            <form method="post" action="{{route('update.events')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control abir_id" type="hidden" name="id">
                        <input class="form-control input-lg abir_name" name="name" placeholder="Event Name" required>
                        <br>
                    </div>
                    <div class="form-group">
                        <select name="status" id="event-status" class="form-control input-lg abir_status" required>
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
                var status = $(this).data('status');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".abir_id").val(id);
                $(".abir_name").val(name);
                $(".abir_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });
        });
    </script>
@endsection