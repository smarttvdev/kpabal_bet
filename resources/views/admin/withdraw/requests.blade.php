@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                     Withdraw Request
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover order-column"
                                           id="">
                                        <thead>
                                        <tr>
                                            <th> User </th>
                                            <th> Transaction  </th>
                                            <th> Method </th>
                                            <th> Request Amount </th>
                                            <th> Total Amount </th>
                                            <th> Status </th>
                                            <th> Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bits as $data)
                                            <tr>
                                                <td>
                                                    <a href="{{route('user.single',$data->user->id)}}">
                                                        {{$data->user->username}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$data->transaction_id}}
                                                </td>
                                                <td> <strong>
                                                    {!! $data->method->name !!}</strong>
                                                </td>
                                                <td> <strong>
                                                    {!! $data->amount !!} {{$basic->currency}}</strong>
                                                </td>
                                                <td> <strong>
                                                    {!! $data->net_amount !!} {{$basic->currency}}</strong>
                                                </td>

                                                <td>
                                                    @if($data->status == 2)
                                                        <button  class="btn btn-outline btn-circle btn-sm green"> Approved </button>
                                                    @elseif($data->status == 1)
                                                        <button class="btn btn-outline btn-circle btn-sm yellow">Pending </button>
                                                    @elseif($data->status == 3)
                                                        <button class="btn btn-outline btn-circle btn-sm purple">Refund </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->status == 2)
                                                        <button  class="btn btn-outline btn-circle btn-sm green"> Completed </button>
                                                        @elseif($data->status == 3)
                                                        <button  class="btn btn-outline btn-circle btn-sm purple"> Refunded </button>
                                                        @else
                                                    <a href="" class="btn btn-outline btn-circle btn-sm green"
                                                       data-toggle="modal" data-target="#Modal{{$data->id}}">
                                                        <i class="fa fa-check"></i> Approve </a>

                                                    <a href="" class="btn btn-outline btn-circle btn-sm red"
                                                       data-toggle="modal" data-target="#DelModal{{$data->id}}">
                                                        <i class="fa fa-check"></i> Refund </a>
                                                        @endif
                                                </td>

                                            </tr>


                                            <!-- Modal for Edit button -->
                                            <div class="modal fade" id="DelModal{{$data->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-content">
                                                    <form role="form" method="post"
                                                          action="{{ route('withdraw.refund')}}"
                                                          enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">

                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="black">X</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                <b class="abir_act"></b> <i class="fa fa-trash"></i> Remove </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>Are You Sure wan't to Refund this ??</h4>
                                                            <input type="hidden" name="net_amount" value="{{$data->net_amount}}">
                                                            <input type="hidden" name="id" value="{{$data->id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"> No </button>
                                                            <button type="submit" class="btn  btn-danger "> Yes </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                            <!-- Modal for Edit button -->
                                            <div class="modal fade" id="Modal{{$data->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-content">
                                                    <form role="form" method="POST"
                                                          action="{{route('withdraw.approve',$data->id)}}"
                                                          enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        {{method_field('put')}}
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true"><span class="black">X</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel"><b
                                                                        class="abir_act"></b> <i class="fa fa-check-circle-o"></i> Approve </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="net_amount" value="{{$data->net_amount}}">
                                                            <h4>Are You Sure Want To Approve this Withdraw Request?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"> No </button>
                                                            <button type="submit" class="btn  btn-success "> Yes </button>
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


                </div>
            </div>

        </div>
    </div>

@endsection