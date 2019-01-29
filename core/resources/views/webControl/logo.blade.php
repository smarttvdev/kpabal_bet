@extends('admin.layout.master')
@section('import-css')
    <link href="{{ asset('assets/admin/css/jquery.fileupload.css') }}" rel="stylesheet">
@stop
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
                    <form role="form" method="POST" action="{{route('manage-logo')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-primary minh-185">
                                    <div class="panel-heading">Present Logo</div>
                                    <div class="panel-body">
                                        <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-responsive"
                                             width="" height="120px">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                            <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                            <span> Upload New Logo </span>
                                            <input type="file" name="logo" class="form-control input-lg"> </span>
                                    @if ($errors->has('logo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-primary minh-185">
                                    <div class="panel-heading">Present Icon</div>
                                    <div class="panel-body">
                                        <img src="{{ asset('assets/images/logo/favicon.png') }}" class="img-responsive"
                                             width="" height="120px">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('favicon') ? ' has-error' : '' }}">
                                    <span class="btn green fileinput-button">
                                        <i class="fa fa-plus"></i>
                                        <span> Upload New Icon </span>
                                        <input type="file" name="favicon" class="form-control input-lg" >
                                    </span>
                                    @if ($errors->has('favicon'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('favicon') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-actions right col-md-12">
                                <button type="submit" class="btn blue btn-lg btn-block">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@stop

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop