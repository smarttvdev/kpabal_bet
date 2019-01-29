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
                        <span class="caption-subject bold uppercase">{{$page_title}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" role="form" action="" method="post">
                        @csrf
                        <div class="form-body">
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>Current Password</b></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="password" name="old_password" class="form-control input-lg" placeholder="Current Password">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>New Password</b></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="password" name="new_password" class="form-control input-lg" placeholder="New Password">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('new_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label"><b>Confirm Password</b></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control input-lg" placeholder="Confirm Password">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-8">
                                    <button type="submit" class="btn btn-block btn-lg green">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>


@stop