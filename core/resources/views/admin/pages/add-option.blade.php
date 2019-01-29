@extends('admin.layout.master')

@section('body')

    <style>
        input[type='number'] {
            -moz-appearance:textfield;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>

    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> {{$page_title}}
                <a href="{{route('admin.matches')}}" class="btn btn-success btn-md pull-right edit_button">
                    <i class="fa fa-eye"></i> View Matches
                </a>
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form action="{{route('store.option')}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Match </span>
                                <input type="text" value="{{$match_id->name}}" class="form-control" readonly>
                                <input type="hidden" name="match_id" value="{{$match_id->id}}" class="form-control"
                                       readonly>

                            </div>
                        </div>

                        <div class="form-group  ">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">Question</span>
                                <select name="question_id" id="" class="form-control">
                                    <option value="">Select Question</option>
                                    @foreach($questions as $data)
                                        <option value="{{$data->id}}">{{$data->question}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('question_id'))
                                <div class="error">{{ $errors->first('question_id') }}</div>
                            @endif
                        </div>



                        <div class="form-group">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="col-md-3">Minimum Bet Amount</th>
                                    <th  class="col-md-4">Ratio </th>
                                    <th >Action</th>

                                </tr>
                                </thead>
                                <tbody class="option_table">


                                <tr id="planDescriptionContainer" class="remove_tr">
                                    <td><input type="text" class="form-control option_name" name="option_name[]"
                                               required></td>
                                    <td><input type="number" class="form-control min_amo" name="min_amo[]"
                                               required step="any"></td>
                                    <td>
                                        <input style="float: left; width: 100px"  type="number" class="form-control invest_amount " name="ratio1[]"
                                               step="any" required>
                                        <span style="color: red; font-size: 22px; float: left">:</span>
                                    <input style="float: left; width: 100px; padding-left: 5px"  type="number" class="form-control return_amount" name="ratio2[]"
                                           step="any"  required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-block delete_desc"
                                                id="delete_option">Delete
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                                <div class="row">
                                    <div class="col-md-12 text-right ">
                                        <button id="btnAddDescription" type="button"
                                                class="btn btn-sm grey-mint pullri"><i class="fa fa-plus"></i> Add More Option
                                        </button>

                                        <br>
                                    </div>
                                </div>
                            </table>
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
                    format: 'YYYY-MM-DD HH:mm'
                });
            });
        });


        var max = 1;
        $(document).ready(function () {
            $("#btnAddDescription").on('click', function () {
                $('<tr id="planDescriptionContainer" class="remove_tr">\n' +
                    '                                    <td><input type="text" class="form-control option_name" name="option_name[]"\n' +
                    '                                               required></td>\n' +
                    '                                    <td><input type="number" class="form-control min_amo" name="min_amo[]"\n' +
                    '                                               required step="any"></td>\n' +
                    '                                    <td>\n' +
                    '                                        <input style="float: left; width: 100px"  type="number" class="form-control invest_amount " name="ratio1[]"\n' +
                    '                                               step="any" required>\n' +
                    '                                        <span style="color: red; font-size: 22px; float: left">:</span>\n' +
                    '                                    <input style="float: left; width: 100px; padding-left: 5px"  type="number" class="form-control return_amount" name="ratio2[]"\n' +
                    '                                           step="any"  required>\n' +
                    '                                    </td>\n' +
                    '                                    <td>\n' +
                    '                                        <button type="button" class="btn btn-danger btn-block delete_desc"\n' +
                    '                                                id="delete_option">Delete\n' +
                    '                                        </button>\n' +
                    '                                    </td>\n' +
                    '                                </tr>').appendTo('.option_table');
            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.remove_tr').remove();
            });
        });

    </script>
@stop
