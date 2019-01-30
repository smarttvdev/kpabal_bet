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

                    <button type="button" class="btn green btn-md pull-right"
                            data-toggle="modal" data-target="#AddOption">
                        <i class="fa fa-plus"></i> Add Option
                    </button>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Thread </th>
                            <th>Ratio</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($betoption as $k=>$data)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{!! $data->option_name !!}</td>
                                <td><strong>
                                        {!! $data->ratio1	 !!} :
                                        {!! $data->ratio2 !!}</strong></td>



                                <td>
                                    <b class="btn btn-sm btn-{{ $data->status ==0 ? 'warning' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</b>
                                </td>
                                <td>
                                    <button type="button" class="btn purple btn-sm edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-act="Edit"
                                            data-name="{{$data->option_name}}"
                                            data-invest="{{$data->invest_amount}}"
                                            data-minamo="{{$data->min_amo}}"
                                            data-retrunamo="{{$data->return_amount}}"
                                            data-ratio1="{{$data->ratio1}}"
                                            data-ratio2="{{$data->ratio2}}"
                                            data-bet="{{$data->bet_ratio}}"
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


    <!-- Modal for Add button -->
    <div class="modal fade" id="AddOption" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add Option </h4>
            </div>
            <form method="post" action="{{route('createNewOption')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><strong>Option Name</strong></label>

                        <input class="" type="hidden" value="{{$ques->id}}" name="ques_id">
                        <input class="" type="hidden" value=" {{$ques->match->id}}" name="match_id">
                        <input class="form-control input-lg " type="text" name="option_name"  required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Minimum Bet Amount</strong></label>
                        <input class="form-control input-lg " name="min_amo" step="any" type="number" required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Ratio</strong></label>
                        <br>
                        <input type="number" style="float: left; width: 45%"  class="form-control input-lg" step="0.01" name="ratio1"  required>
                        <span style="color: red; font-size: 22px; float: left">:</span>

                        <input style="float: left; width: 45%; padding-left: 5px"  type="number" class="form-control input-lg " step="0.01" name="ratio2"  required>
                    </div>

                    <div class="form-group">
                        <br><br>
                        <label for=""><strong>Status</strong></label>
                        <select name="status" class="form-control input-lg" required>
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Save </button>
                </div>
            </form>
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
                        <label for=""><strong>Option Name</strong></label>
                        <input class="form-control ronnie_id" type="hidden" name="id">
                        <input class="form-control input-lg ronnie_question" type="text" name="option_name"  required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Minimum Bet Amount</strong></label>
                        <input class="form-control input-lg ronnie_minamo" name="min_amo" step="any" type="number" required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Ratio</strong></label>
                        <br>
                        <input type="number" style="float: left; width: 45%"  class="form-control input-lg   ronnie_ratio1" step="0.01" name="ratio1"  required>
                        <span style="color: red; font-size: 22px; float: left">:</span>

                        <input style="float: left; width: 45%; padding-left: 5px"  type="number" class="form-control input-lg  ronnie_ratio2 " step="0.01" name="ratio2"  required>
                    </div>

                    <div class="form-group">
                        <br><br>
                        <label for=""><strong>Status</strong></label>
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
                var bet_ratio = $(this).data('bet');
                var status = $(this).data('status');
                var minamo = $(this).data('minamo');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_question").val(name);
                $(".ronnie_invest_amount").val(invest_amount);
                $(".ronnie_return_amount").val(return_amount);
                $(".ronnie_ratio1").val(ratio1);
                $(".ronnie_ratio2").val(ratio2);

                $(".ronnie_ratio").val(bet_ratio);
                $(".ronnie_minamo").val(minamo);
                $(".ronnie_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });


            $(document).on('keypress keyup','.invest_amount,.return_amount',function(){
                var tr =  $(this).parent().parent();
                var investAmount = parseInt(tr.find('.invest_amount').val());
                var returnAmount = parseInt(tr.find('.return_amount').val());
                var ratio  = returnAmount / investAmount;
                if(ratio>0){
                    tr.find('.bet_ratio').val('1:'+ratio);
                }
            });
        });
    </script>
@endsection