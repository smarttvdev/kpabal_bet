@extends('admin.layout.master')

@section('body')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }
    </style>
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

                <button href="" class="btn btn-success btn-md pull-right edit_button"
                        data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i> Add Withdraw Method
                </button>
            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Withdraw Methods</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover order-column" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Charge</th>
                            <th>Processing Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($withdarws as $k=>$data)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->withdraw_min}} - {{$data->withdraw_max}} {{$basic->currency}}</td>
                                <td>{{$data->fix}} + {{$data->percent}}%</td>
                                <td>{{$data->duration}} Days</td>
                                <td>
                                    @if($data->status == 1)
                                        <a class="btn btn-outline btn-circle btn-sm green">Active </a>
                                    @else
                                        <a class="btn btn-outline btn-circle btn-sm red">DeActve </a>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline btn-circle btn-sm blue"
                                            data-toggle="modal" data-target="#editModal{{$data->id}}"
                                            data-act="Edit">
                                        Edit </button>
                                </td>
                            </tr>



                            <!-- Modal for Edit button -->
                            <div class="modal fade editModal" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Edit <strong>{{$data->name}}</strong> </h4>
                                    </div>
                                    <form method="post" action="{{route('update.wsettings')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <input class="form-control abir_id" value="{{$data->id}}" type="hidden" name="id">
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="{{ asset('assets/images') }}/{{$data->image}}" alt="" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 150px;"> </div>
                                                    <div>
            <span class="btn btn-success btn-file">
                <span class="fileinput-new"> Change Logo </span>
                <span class="fileinput-exists"> Change </span>
                <input type="file" name="image"> </span>
                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><strong>Method Name</strong></h5>
                                                        <input type="text" value="{{$data->name}}" class="form-control" id="name" name="name" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 for="minamo"><strong>Minimum Amount</strong></h5>
                                                        <div class="input-group">
                                                            <input type="number" value="{{$data->withdraw_min}}" class="form-control" id="minamo" name="withdraw_min" step="0.01">
                                                            <span class="input-group-addon">
                                                                <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 for="maxamo"><strong>Maximum Amount</strong></h5>
                                                        <div class="input-group">
                                                            <input type="number" value="{{$data->withdraw_max}}" class="form-control" id="maxamo" name="withdraw_max" step="0.01">
                                                            <span class="input-group-addon">
                                                               <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 for="chargefx"><strong>Fixed Charge</strong></h5>
                                                        <div class="input-group">
                                                            <input type="number" value="{{$data->fix}}" class="form-control" id="chargefx" name="fix" step="0.01">
                                                            <span class="input-group-addon">
                                                               <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 for="chargepc"><strong>Charge in Percentage (%)</strong></h5>
                                                        <div class="input-group">
                                                        <input type="number" value="{{$data->percent}}" class="form-control" id="chargepc" name="percent" step="0.01">
                                                            <span class="input-group-addon">
                                                               <strong>%</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                    <h5 for="val1"><strong>processing time</strong></h5>
                                                    <div class="input-group">
                                                    <input type="text" value="{{$data->duration}}" class="form-control" id="val1" name="duration" >
                                                        <span class="input-group-addon"><strong>Days</strong></span>
                                                    </div>
                                                </div>


                                            <div class="form-group">
                                                <h5 for="status"><strong>Status</strong></h5>
                                                <select class="form-control" name="status">
                                                    <option value="1" {{ $data->status == "1" ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $data->status == "0" ? 'selected' : '' }}>Deactive</option>
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
                        @endforeach
                        <tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal for Edit button -->
    <div class="modal fade editModal" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><strong> Add Method </strong> </h4>
            </div>
            <form method="post" action="{{route('add.withdraw.method')}}" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="modal-body">

                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="" alt="" /> </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 150px;"> </div>
                            <div>
            <span class="btn btn-success btn-file">
                <span class="fileinput-new"> Change Logo </span>
                <span class="fileinput-exists"> Change </span>
                <input type="file" name="image"> </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <h5><strong>Method Name</strong></h5>
                                <input type="text"  class="form-control" id="name" name="name" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 for="minamo"><strong>Minimum Amount</strong></h5>
                                <div class="input-group">
                                    <input type="number" value="" class="form-control" id="minamo" name="withdraw_min" step="0.01" >
                                    <span class="input-group-addon">
                                                                <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 for="maxamo"><strong>Maximum Amount</strong></h5>
                                <div class="input-group">
                                    <input type="number" value="" class="form-control" id="maxamo" name="withdraw_max" step="0.01" >
                                    <span class="input-group-addon">
                                                               <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 for="chargefx"><strong>Fixed Charge</strong></h5>
                                <div class="input-group">
                                    <input type="number"  class="form-control" id="chargefx" name="fix" step="0.01" >
                                    <span class="input-group-addon">
                                                               <strong>{{ $basic->currency }}</strong>
                                                            </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 for="chargepc"><strong>Charge in Percentage (%)</strong></h5>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="chargepc" name="percent" step="0.01" >
                                    <span class="input-group-addon">
                                                               <strong>%</strong>
                                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <h5 for="val1"><strong>processing time</strong></h5>
                        <div class="input-group">
                            <input type="text" class="form-control" id="val1" name="duration" >
                            <span class="input-group-addon"><strong>Days</strong></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <h5 for="status"><strong>Status</strong></h5>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
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



@endsection