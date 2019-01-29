@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/table.css')}}">
@stop
@push('nic', ' ')
@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}</h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="lotn-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Ads Management</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('advertisement.create')}}" class="btn btn-success"><i class="fa fa-plus"></i>
                            Add New</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <thead>
                        <th scope="col">Ad Type</th>
                        <th scope="col">Banner/Script</th>
                        <th scope="col">Clicks</th>
                        <th scope="col">Action</th>
                        </thead>
                        <tbody>

                        @foreach($ads as $data)
                            <tr id="row_{{$data->id}}">
                                <td data-label="Ad Type">
                                    @if($data->type ==1)
                                        <strong>Banner</strong>
                                    @else
                                        <strong>Script</strong>
                                    @endif
                                </td>
                                <td data-label="Banner / Script">
                                    @if($data->size == 1)
                                        <h6>300x250</h6>
                                    @elseif($data->size == 2)
                                        <h6>728x90</h6>
                                    @else
                                        <h6>300x600</h6>
                                    @endif
                                </td>
                                <td data-label="Ad Size">
                                    <span href="" class="btn btn-success btn-sm">
                                         {!! $data->views !!}
                                    </span>
                                </td>
                                <td data-label="Action">
                                    <a class="btn btn-sm btn-info modal_button delete_button" data-toggle="modal"
                                       data-target="#small{{$data->id}}" value="3" data-src="{{$data->id}}"
                                       data-status="{{$data->id}}" data-sub="{{$data->id}}"><i class="fa fa-eye"></i>
                                        Show</a>
                                    <a class="btn btn-danger btn-sm" data-id="{{$data->id}}" href="#"
                                       data-toggle="modal" data-target="#advertise-delete-data{{ $data->id }}"
                                       id="advert_delete_btn">Delete</a>
                                </td>
                            </tr>



                            <!--advertise delete modal-->
                            <div class="modal fade" id="advertise-delete-data{{ $data->id }}" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Advertise Remove</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('advertisement.destroy', $data->id) }}"
                                          id="category_delete_form" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="modal-body">
                                            <input type="hidden" id="addvertise_id" value="{{ $data->id }}"
                                                   name="addvertise_id">
                                            <h6class="text text-danger"><strong>Are Your Sure To Delete This Advertise
                                                    ?</strong></h3>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn red" id="delete_confirm">Confirm Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="modal fade" id="small{{$data->id}}" role="dialog"
                                 aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h4 class="modal-title"><b class="text-uppercase"> <span id="modal-heading">Advertisment Show</span>
                                            </b></h4>
                                    </div>
                                    <div class="modal-body">
                                        @if($data->type ==1)
                                            @if(file_exists("assets/images/ads/add-pic-{$data->id}.{$data->src}"))
                                                <img src="{{url('/')}}/assets/images/ads/add-pic-{{$data->id}}.{{$data->src}}"
                                                     alt="Add Image" style="height: 300px; width: 400px;">
                                            @endif
                                        @else
                                            <p cols="10" rows="10">{{$data->script}}</p>
                                        @endif

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                                id="confirm_delete_subcategory">Close
                                        </button>
                                    </div>
                                </div>

                            </div>


                        @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $ads->links() !!}
            </div>

        </div>
    </div>



@endsection

@section('script')
    <script>
        $(document).ready(function () {
            /**====================================================
             * Dynamicaly Change the form by the advertise type
             * =================================================**/
            $(document).on('change', '#add_type', function () {
                var id = $(this).val();
                //alert(id);
                if (id == 0) {
                    $('#load_form_for_add').html("");

                } else if (id == 1) {
                    $('#load_form_for_add').html("");
                    $('#load_form_for_add').append('<div class="form-group">' +
                        '<label for="advertiser_name"> Advertiser Name</label>' +
                        '<input type="text" name="advertiser_name" placeholder="Advertiser Name" class="form-control">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="redirect_url"> Redirect Url</label>' +
                        '<input type="text" name="redirect_url" placeholder="http://thesoftking.com" class="form-control">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="add_picture">Banner</label>' +
                        '<input type="file" name="add_picture">' +
                        '</div>');
                } else {
                    $('#load_form_for_add').html("");
                    $('#load_form_for_add').append('<div class="form-group">' +
                        '<label for="script"> Advertiser Name</label>' +
                        '<textarea name="script" id="script" cols="30" rows="10" class="form-control" placeholder="Script will be here"></textarea>' +
                        '</div>');
                }
            });


        });
    </script>
@endsection