@extends('admin.layout.master')
@section('css')
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
                <div class="portlet-body">
                    {!! Form::open(['method'=>'post','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Slider Main Title</strong></label>
                                    <div class="col-md-12">
                                        <input name="title" type="text" class="form-control input-lg" placeholder="Slider  Title" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Slider Sub Title</strong></label>
                                    <div class="col-md-12">
                                        <input name="sub_title" type="text" class="form-control input-lg" placeholder="Slider Sub-title" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">SLIDER TEXT</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="description" id="area1" rows="5" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Slider Image</strong></label>
                                    <div class="col-md-12">
                                        <input name="image" type="file" class="form-control input-lg" required />
                                        <code><b style="color:red; font-weight: bold;margin-top: 10px">ONE IMAGE ONLY | Image Will Resized to 2100 x 1410 </b></code>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" onclick="nicEditors.findEditor('area1').saveContent();" class="btn blue btn-block bold btn-lg uppercase"><i class="fa fa-send"></i> Create Slider</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->
                    </div>
                    {!! Form::close() !!}


                    <div class="row">
                        @foreach($slider as $s)
                            <div class="col-md-6">
                                <div class="images">
                                    <img class="center-block" src="{{ asset('assets/images/slider') }}/{{ $s->image }}" alt="" style="margin-top: 20px;margin-bottom: 10px;width:100%;">
                                    <button type="button" class="btn btn-danger btn-block btn-lg delete_button"
                                            data-toggle="modal" data-target="#DelModal"
                                            data-id="{{ $s->id }}">
                                        <i class='fa fa-trash'></i> Delete Slider
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
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


                                </div>
                            </div>



                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>





    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('slider-delete') }}" class="form-inline">
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" class="abir_id" value="0">

                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>&nbsp;
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> DELETE</button>
                    </form>
                </div>

            </div>
        </div>
    </div>




@stop
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                $(".abir_id").val(id);
            });
        });
    </script>
@stop
