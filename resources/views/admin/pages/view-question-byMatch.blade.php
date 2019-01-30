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
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Question</th>
                            <th>Options</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $k=>$data)
                            <tr @if($data->result == 1) class="danger" @endif>
                                <td>{{++$k}}</td>
                                <td>{!! $data->question !!}</td>
                                <td>
                                    <a href="{{route('view.option.endtime', $data->id )}}" class="btn btn-info btn-md edit_button" title="View Question">
                                        <strong>{{$data->options()->count()}}</strong>
                                    </a>
                                </td>
                                <td>
                                    
                                    <a href="{{route('view.option.endtime',$data->id)}}" class="btn blue btn-sm edit_button">
                                        <i class="fa fa-eye"></i> View Option
                                    </a>

                                    @if($data->result == 1)
                                    <button class="btn red btn-sm edit_button">
                                        completed
                                    </button>
                                        @endif

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


@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var name = $(this).data('name');
                var status = $(this).data('status');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_question").val(name);
                $(".ronnie_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });
        });
    </script>
@endsection