@extends('admin.layout.master')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>


            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-photo"></i> <strong>{{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption uppercase bold"><i class="fa fa-edit"></i> CHANGE Breadcrumb</div>
                                </div>
                                <div class="portlet-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">

                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Change Breadcrumb</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="input-group input-large">
                                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                <span class="fileinput-filename"> </span>
                                                            </div>
                                                            <span class="input-group-addon btn default btn-file">
                                                                    <span class="fileinput-new bold"> Change Breadcrumb </span>
                                                                    <span class="fileinput-exists bold"> Change </span>
                                                                    <input type="file" name="breadcrumb"> </span>
                                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                        </div>
                                                        <code>Breadcrumb Mimes Type : jpg | Resize 1400X300</code>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            </div>

                                            <br>
                                            <br>
                                            <br>
                                            <div class="form-group">
                                                <div class="col-sm-12"> <button type="submit" class="btn btn-primary bold btn-block"><i class="fa fa-send"></i> UPDATE</button></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption uppercase bold"><i class="fa fa-photo"></i> Current Image</div>
                                </div>
                                <div class="portlet-body">
                                    <img class="img-responsive" src="{{ asset('assets/images/logo/breadcrumb.png') }}" alt="logo">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop