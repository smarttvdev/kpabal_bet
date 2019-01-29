@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}</h3>
            @include('errors.error')
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title green">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{$page_title}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <form role="form" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Website Title</h4>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" value="{{$general->sitename}}"
                                           name="sitename">
                                    <span class="input-group-addon">
                                        <strong><i class="fa fa-file-text-o"></i></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h4>BASE COLOR CODE</h4>
                                <div class="input-group">
                                <input type="color" class="form-control input-lg" value="#{{$general->color}}"
                                       name="color">
                                    <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4>BACKFROUND  Color CODE</h4>
                                <div class="input-group">
                                <input type="color" class="form-control input-lg" value="#{{$general->bg_color}}"
                                       name="bg_color">
                                    <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <hr/>
                            <div class="col-md-3">
                                <h4>BASE CURRENCY </h4>
                                <div class="input-group">
                                <input type="text" class="form-control input-lg" value="{{$general->currency}}" name="currency">
                                    <span class="input-group-addon"><strong><i class="fa fa-money"></i></strong></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4>CURRENCY SYMBOL</h4>
                                <div class="input-group">
                                <input type="text" class="form-control input-lg" value="{{$general->currency_sym}}"
                                       name="currency_sym">
                                    <span class="input-group-addon"><strong><i
                                                    class="fa fa-exclamation-circle"></i></strong></span>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4>Decimal After Point</h4>
                                <div class="input-group">
                                <input type="text" class="form-control input-lg" value="{{$general->decimal}}"
                                       name="decimal">
                                    <span class="input-group-addon"><strong>Decimal</strong></span>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <h4>Referral Bonus</h4>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" value="{{$general->refcom}}"
                                           name="refcom">
                                    <span class="input-group-addon">
                                        <strong>%</strong>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <hr/>
                            <div class="col-md-4">
                                <h4>Registration</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="registration" {{$general->registration == "1" ? 'checked' : '' }}>
                            </div>

                            <div class="col-md-4">
                                <h4>EMAIL VERIFICATION</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="email_verification" {{ $general->email_verification == "1" ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-4">
                                <h4>SMS VERIFICATION</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="sms_verification" {{$general->sms_verification == "1" ? 'checked' : ''}}>
                            </div>
                        </div>
                        <div class="row">
                            <hr/>
                            <div class="col-md-4">
                                <h4>EMAIL NOTIFICATION</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="email_notification" {{ $general->email_notification == "1" ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-4">
                                <h4>SMS NOTIFICATION</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="sms_notification" {{ $general->sms_notification == "1" ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-4">
                                <h4>WITHDRAW STATUS</h4>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="withdraw_status" {{ $general->withdraw_status == "1" ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="row">
                            <hr/>
                            <div class="col-md-12 ">
                                <button class="btn blue btn-block btn-lg">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('script')

@stop