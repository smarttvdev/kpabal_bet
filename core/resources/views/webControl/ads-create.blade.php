@extends('admin.layout.master')
@section('css')
@stop
@push('nic', ' ')
@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="lotn-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Ads Create</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form action="{{route('advertisement.store')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="add_type"> Select Advertisement Type</label>
                            <select name="add_type" class="form-control" id="add_type">
                                <option value="0" selected>Select Advertise Type</option>
                                <option value="1">Banner</option>
                                <option value="2">Script</option>
                            </select>
                            @if($errors->has('add_type'))
                                <p class="alert alert-danger">{{$errors->first('add_type')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="add_size"> Select Advertisement Size</label>
                            <select name="add_size" class="form-control"  id="add_size">
                                <option value="0">Select Size</option>
                                <option value="1">300x250</option>
                                <option value="2">728x90</option>
                                <option value="3">300x600</option>
                            </select>
                            @if($errors->has('add_size'))
                                <p class="alert alert-danger">{{$errors->first('add_size')}}</p>
                            @endif
                        </div>
                        <div id="load_form_for_add">

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function(){
            /**====================================================
             * Dynamicaly Change the form by the advertise type
             * =================================================**/
            $(document).on('change','#add_type',function(){
                var id = $(this).val();
                //alert(id);
                if ( id == 0 ) {

                    $('#load_form_for_add').html("");

                }else if ( id ==1 ) {
                    $('#load_form_for_add').html("");
                    $('#load_form_for_add').append(
                        '<div class="form-group">' +
                        '<label for="redirect_url"> Redirect Url</label>' +
                        '<input type="text" name="redirect_url" placeholder="http://thesoftking.com" class="form-control">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="add_picture">Banner</label>' +
                        '<input type="file" name="add_picture">' +
                        '</div>');
                }else{
                    $('#load_form_for_add').html("");
                    $('#load_form_for_add').append('<div class="form-group">' +
                        '<label for="script"> Script</label>'+
                        '<textarea name="script" id="script" cols="30" rows="10" class="form-control" placeholder="Script will be here"></textarea>' +
                        '</div>');
                }
            });
        });
    </script>
@endsection