@extends('admin.layout.master')

@section('body')
    <style>
        input[type='number'] {
            -moz-appearance:textfield;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Option LIST</span>
                    </div>
                    <a href="{{url()->previous()}}" class="btn btn-success btn-md pull-right edit_button">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="{{route('add.option',$match->id)}}" class="btn btn-success btn-md pull-right edit_button" style="margin-right: 10px">
                        <i class="fa fa-plus"></i> Add Betoption
                    </a>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Question</th>
                            <th>Thread</th>
                            <th>Minimum Bet</th>
                            <th>Ratio</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($betoption as $k=>$data)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$data->question->question}}</td>
                                <td>{!! $data->option_name !!}</td>
                                <td>{!! $data->min_amo !!} {!! $basic->currency !!}</td>
                                <td>
                                    <strong>
                                        {!! $data->ratio1 !!} : {!! $data->ratio2!!}
                                    </strong>
                                </td>


                                <td>
                                    <b class="btn btn-sm btn-{{ $data->status ==0 ? 'warning' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</b>
                                </td>
                                <td>
                                    <button type="button" class="btn purple btn-sm edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-act="Edit"
                                            data-name="{{$data->option_name}}"
                                            data-invest="{{$data->invest_amount}}"
                                            data-retrunamo="{{$data->return_amount}}"
                                            data-ratio1="{{$data->ratio1}}"
                                            data-ratio2="{{$data->ratio2}}"
                                            data-minamo="{{$data->min_amo}}"

                                            data-status="{{$data->status}}"
                                            data-id="{{$data->id}}">
                                        <i class="fa fa-edit"></i> EDIT
                                    </button>


                                </td>
                            </tr>
                        @endforeach
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
                <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Option </h4>
            </div>
            <form method="post" action="{{route('update.option')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><strong>Option Name </strong></label>
                        <input class="form-control ronnie_id" type="hidden" name="id">
                        <input class="form-control input-lg ronnie_question" type="text" name="option_name"  required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Minimum Bet Amount</strong></label>
                        <input class="form-control input-lg ronnie_minamo" name="min_amo" step="any" type="number" required>
                    </div>

                    <div class="form-group">
                        <label for=""> <strong>Ratio</strong></label>
                        <br>
                        <input type="number" style="float: left; width: 45%"  class="form-control input-lg  invest_amount ronnie_ratio1" step="0.01" name="ratio1"  required>
                        <span style="color: red; font-size: 22px; float: left">:</span>

                        <input style="float: left; width: 45%; padding-left: 5px"  type="number" class="form-control input-lg  ronnie_ratio2 return_amount" step="0.01" name="ratio2"  required>
                    </div>

                    <div class="form-group">

                        <br>
                        <br>
                        <label for=""> <strong>Select Status</strong></label>
                        <select name="status" class="form-control input-lg ronnie_status" required>
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
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
                var invest_amount = $(this).data('invest');
                var return_amount = $(this).data('retrunamo');
                var ratio1 = $(this).data('ratio1');
                var ratio2 = $(this).data('ratio2');
                var minamo = $(this).data('minamo');
                var bet_ratio = $(this).data('bet');
                var status = $(this).data('status');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_question").val(name);
                $(".ronnie_invest_amount").val(invest_amount);
                $(".ronnie_return_amount").val(return_amount);
                $(".ronnie_ratio1").val(ratio1);
                $(".ronnie_ratio2").val(ratio2);
                $(".ronnie_minamo").val(minamo);
                $(".ronnie_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);
            });

        });
    </script>
@endsection