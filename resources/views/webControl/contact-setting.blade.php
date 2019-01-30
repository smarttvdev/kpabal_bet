@extends('admin.layout.master')
@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">


                    {!! Form::model($basic,['route'=>['contact-setting-update',$basic->id],'method'=>'PUT','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Contact Phone</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" name="phone" class="form-control bold input-lg" value="{{ $basic->phone }}" required>
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Contact Email</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" name="email" class="form-control bold input-lg" value="{{ $basic->email }}" required>
                                            <span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Contact Address</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" name="address" class="form-control bold input-lg" value="{{ $basic->address }}" required>
                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn blue btn-block btn-lg"><i class="fa fa-send"></i> UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

@stop