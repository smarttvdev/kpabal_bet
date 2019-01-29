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

            <h3 class="page-title uppercase bold"> {{$page_title}}</h3>
            <hr>
            <div class="row">
                <div class="col-md-8">


                    <div class="portlet-body">

                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>Update Profile
                                </div>
                            </div>
                            <div class="portlet-body">
                                <form id="form" method="POST" action="{{route('user.balance.update')}}"
                                      enctype="multipart/form-data" name="editForm">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label> Name</label>
                                            <input data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" data-on=" <i class='fa fa-plus'></i> Add Money" data-off="<i class='fa fa-minus'></i> Substruct Money"  data-width="100%" data-height="46" type="checkbox" name="operation">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Amount</label>
                                            <div class="input-group ">
                                            <input type="number" name="amount" class="form-control input-lg" step="0.01">
                                                <span class="input-group-addon">{{$basic->currency}}</span>
                                            </div>
                                            @if ($errors->has('amount'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12 ">
                                            <label> Message</label>
                                            <textarea name="message" id="" class="form-control"  rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption uppercase bold">
                                <i class="fa fa-money"></i> Current Balance
                            </div>
                        </div>

                        <div class="portlet-body text-center" style="overflow:hidden;">
                            @if( $user->image == null)
                                <img src=" {{url('assets/user/images/user-default.png')}} " class="img-responsive propic" alt="Profile Pic">
                            @else
                                <img src=" {{url('assets/user/images/'.$user->image)}} " class="img-responsive propic" alt="Profile Pic">
                            @endif

                            <h4 class="bold">User Name : {{ $user->username }}</h4>
                            <h4 class="bold">Name : {{ $user->name }}</h4>
                            <h4 class="bold">BALANCE : {{number_format(floatval($user->balance), $basic->decimal, '.', '')}} {{$basic->currency}}</h4>
                            <hr>
                            <p><strong>Last Login : {{ Carbon\Carbon::parse($user->login_time)->diffForHumans() }}</strong> <br></p>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>



@endsection

