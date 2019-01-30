@extends('admin.layout.master')
@section('import-css')

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
                        <span class="caption-subject bold uppercase">Questions LIST</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body form">
                    @foreach($service->chunk(2) as $data)
                        <div class="row">
                            @foreach($data as $m)
                                <div class="col-md-5 col-md-offset-1">
                                    <div class="text-center" style="font-size: 50px"><b>{!! $m->icon !!}</b></div>
                                    <br>
                                    <p class="text-center">
                                        {!! $m->details !!}
                                    </p>
                                    <a href="{{ route('service-edit',$m->id) }}" class="btn blue btn-block margin-top-20"><i class="fa fa-edit"></i> Edit  </a>

                                </div>
                            @endforeach
                        </div>
                        <br><br>
                    @endforeach
                </div>
            </div>

        </div>
    </div>


@stop

@section('script')
    
@stop