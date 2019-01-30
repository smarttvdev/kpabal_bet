@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold">
                {{$ques->match->name}}
                <a href="{{url()->previous()}}" class="btn btn-success btn-md pull-right edit_button">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">
                {{$page_title}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Thread</th>
                            <th>Ratio</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($betoption) > 0)
                            @foreach($betoption as $k=>$data)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{!! $data->option_name !!}</td>
                                    <td><strong>{!! $data->ratio1	 !!} : {!! $data->ratio2 !!}</strong></td>
                                    <td>
                                        @if($data->status ==1)
                                            <b class="btn btn-sm btn-warning">Pending</b>
                                        @elseif($data->status ==2)
                                            <b class="btn btn-sm btn-success">win</b>
                                        @elseif($data->status ==0)
                                            <b class="btn btn-sm btn-info">DeActive</b>

                                        @elseif($data->status ==-2)
                                            <b class="btn btn-sm btn-info">Lost</b>
                                        @endif


                                    </td>
                                    <td>
                                        @if($data->status == 1)
                                            <button type="button" class="btn purple btn-sm edit_button"
                                                    data-toggle="modal" data-target="#myModal"
                                                    data-act=""
                                                    data-id="{{$data->id}}"
                                                    data-ques_id="{{$ques->id}}"
                                                    data-matchid="{{$data->match->id}}">
                                                <i class="fa fa-edit"></i> Make Winer
                                            </button>
                                        @elseif($data->status ==2)
                                            <button class="btn red btn-sm ">
                                                Completed
                                            </button>
                                        @elseif($data->status == -2)
                                            <button class="btn red btn-sm ">
                                                Completed
                                            </button>
                                        @endif

                                    </td>


                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="7"><strong>No Option Found!!</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $betoption->links()!!}
                </div>
            </div>

        </div>
    </div>



    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Make Winner </h4>
            </div>
            <form method="post" action="{{route('make.winner')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <strong>Are you sure want to Make winner this ??</strong>
                    <div class="form-group">
                        <input type="hidden" name="betoption_id" class="ronnie_id" >
                        <input type="hidden" name="match_id" class="ronnie_match_id" >

                        <input type="hidden" name="ques_id" class="ronnie_ques_id" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Yes</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var ques_id = $(this).data('ques_id');
                var match_id = $(this).data('matchid');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_match_id").val(match_id);
                $(".ronnie_ques_id").val(ques_id);
                $(".abir_act").text(act);

            });


        });
    </script>
@endsection