@extends('admin.layout.master')

@section('body')
<div class="page-content-wrapper">
    <div class="page-content">
        
        <h3 class="page-title uppercase bold">  {{$page_title}}
            
        </h3>
        <hr>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">Payment {{$page_title}}</span>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Gateway Name</th>
                            <th>Name For User</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gateways as $k=>$gateway)
                        <tr>
                            <td>{{ ++$k }}</td>
                            <td>{{ $gateway->main_name }}</td>
                            <td>{{ $gateway->name }}</td>
                            <td>
                                @if($gateway->status == 1)
                                <a class="btn btn-outline btn-circle btn-sm green">Active </a>
                                @else
                                <a class="btn btn-outline btn-circle btn-sm red">DeActve </a>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-outline btn-circle btn-sm blue"
                                data-toggle="modal" data-target="#editModal{{$gateway->id}}"
                                data-act="Edit">
                                Edit </button>
                            </td>
                        </tr>
                        
                        
                        <!-- Modal for Edit button -->
                        <div class="modal fade editModal" id="editModal{{$gateway->id}}" tabindex="-1" role="dialog">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                        <button type="button" class="btn btn-default btn-xs pull-right" data-dismiss="modal">Close</button>
                                    <h4 class="modal-title" id="myModalLabel">Edit <strong>{{$gateway->name}}</strong> </h4>
                                </div>
                                <form method="post" action="{{route('update.gateway')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    
                                    <input class="form-control abir_id" value="{{$gateway->id}}" type="hidden" name="id">
                                    <div class="modal-body">
                                        {{ Session::get('modal_message_error') }}
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    <img src="{{ asset('assets/images/gateway') }}/{{$gateway->id}}.jpg" alt="*" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"> </div>
                                                    <div>
                                                        <span class="btn btn-success btn-file">
                                                            <span class="fileinput-new"> Change Logo </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="gateimg"> </span>
                                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5><strong>Name of Gateway</strong></h5>
                                                            <input type="text" value="{{$gateway->name}}" class="form-control" id="name" name="name" >
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5><strong>Rate</strong></h5>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <strong>1 USD =</strong>
                                                                </span>
                                                                <input type="text" value="{{$gateway->rate}}" class="form-control" id="rate" name="rate" >
                                                                <span class="input-group-addon">
                                                                    <strong> {{ $basic->currency }}</strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="panel panel-primary text-center">
                                                                <div class="panel-heading">
                                                                    Deposit Limit
                                                                </div>
                                                                <div class="panel-body">
                                                                    <h5 for="minamo"><strong>Minimum Amount</strong></h5>
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{$gateway->minamo}}" class="form-control" id="minamo" name="minamo" >
                                                                        <span class="input-group-addon">
                                                                            <strong>{{ $basic->currency }}</strong>
                                                                        </span>
                                                                    </div>
                                                                    <h5 for="maxamo"><strong>Maximum Amount</strong></h5>
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{$gateway->maxamo}}" class="form-control" id="maxamo" name="maxamo" >
                                                                        <span class="input-group-addon">
                                                                            <strong>{{ $basic->currency }}</strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="panel panel-primary text-center">
                                                                <div class="panel-heading">
                                                                    Deposit Charge
                                                                </div>
                                                                <div class="panel-body">
                                                                    <h5 for="chargefx"><strong>Fixed Charge</strong></h5>
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{$gateway->fixed_charge}}" class="form-control" id="chargefx" name="chargefx" >
                                                                        <span class="input-group-addon">
                                                                            <strong>{{ $basic->currency }}</strong>
                                                                        </span>
                                                                    </div>
                                                                    <h5 for="chargepc"><strong>Charge in Percentage</strong></h5>
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{$gateway->percent_charge}}" class="form-control" id="chargepc" name="chargepc" >
                                                                        <span class="input-group-addon">
                                                                            <strong>%</strong>
                                                                        </span>
                                                                    </div>                                                               
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                @if($gateway->id==101)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>PAYPAL BUSINESS EMAIL</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                @elseif($gateway->id==102)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>PM USD ACCOUNT</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>ALTERNATE PASSPHRASE</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                
                                                @elseif($gateway->id==103)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>SECRET KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>PUBLISHABLE KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==104)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>Marchant Email</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>Secret KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==501)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>API KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>XPUB CODE</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==502)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>API KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>API PIN</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==503)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>API KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>API PIN</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==504)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>API KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>API PIN</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==505)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>Private KEY</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @elseif($gateway->id==506)
                                                <div class="form-group">
                                                        <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                    </div>
                                                    <div class="form-group">
                                                        <h5 for="val2"><strong>Private KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                    </div>
                                                @elseif($gateway->id==507)
                                                <div class="form-group">
                                                        <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                    </div>
                                                    <div class="form-group">
                                                        <h5 for="val2"><strong>Private KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                    </div>
                                                @elseif($gateway->id==508)
                                                <div class="form-group">
                                                        <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                    </div>
                                                    <div class="form-group">
                                                        <h5 for="val2"><strong>Private KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                    </div>
                                                @elseif($gateway->id==509)
                                                <div class="form-group">
                                                        <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                    </div>
                                                    <div class="form-group">
                                                        <h5 for="val2"><strong>Private KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                    </div>
                                                @elseif($gateway->id==510)
                                                <div class="form-group">
                                                        <h5 for="val1"><strong>Public  KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                    </div>
                                                    <div class="form-group">
                                                        <h5 for="val2"><strong>Private KEY</strong></h5>
                                                        <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                    </div>
                                                @elseif($gateway->id==513)
                                                <div class="form-group">
                                                    <h5 for="val1"><strong>API Key</strong></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                <div class="form-group">
                                                    <h5 for="val2"><strong>API ID</strong></h5>
                                                    <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
                                                </div>
                                                @else
                                                <div class="form-group">
                                                    <h5 for="val1"><storng>Payment Details</storng></h5>
                                                    <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                </div>
                                                @endif
                                                
                                                <div class="form-group">
                                                    <h5 for="status"><strong>Status</strong></h5>
                                                    <select class="form-control" name="status">
                                                        <option value="1" {{ $gateway->status == "1" ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ $gateway->status == "0" ? 'selected' : '' }}>Deactive</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                            
                                                <button type="submit" class="btn btn-success btn-block">Save changes</button>
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
                
                
                
                
                
                
                @endsection