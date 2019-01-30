@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> {{$page_title}}
                <a href="{{route('view.question',$match_id->id)}}"
                   class="btn btn-success btn-md pull-right edit_button">
                    <i class="fa fa-eye"></i> View Questions
                </a>
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{route('save.question')}}" method="post">
                        {{csrf_field()}}


                        <input type="hidden" name="match_id" value="{{$match_id->id}}" class="form-control">

                        <div class="form-group">
                            <h3> Add Question : </h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="description"
                                         style="width: 100%;border: 1px solid #ddd;padding: 10px;border-radius: 5px">
                                        <div class="row">
                                            <div class="col-md-12" id="planDescriptionContainer">
                                                <div class="input-group input-group-lg ">
                                                    <input name="description"
                                                           class="form-control  input-lg" type="text" required
                                                           placeholder="Add Question">
                                                    <span class="input-group-btn">
                                                     <button class="btn default" type="button">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                    </span>
                                                </div>

                                                <br>
                                                <div class="input-group input-group-lg  ">
                                                    <span class="input-group-addon " id="sizing-addon1">End Date</span>

                                                    <input type="text" class="form-control input-sm datepicker" id="end_time" name="end_time" required>
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success btn-lg btn-block">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')


    <script type="text/javascript">
        $(function () {
            $('#datetimepicker2').datetimepicker({
                language: 'en',
                pick12HourFormat: true
            });
        });

        $(document).ready(function () {
            $(function () {
                $('.datepicker').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
            });
        });
    </script>




@stop