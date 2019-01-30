@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}} </h3>
            <hr>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form action="{{route('admin.UpdateGenSetting')}}" method="post">
                        <strong>USER WILL GET </strong>
                        {{csrf_field()}}

                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1">BTC</span>

                            <input type="text" name="rate" class="form-control" value="{{$Gset->rate}}">

                            <span class="input-group-addon" id="sizing-addon1">Per Hour</span>
                        </div>


                        <br><br>
                        <button type="submit" class="btn btn-success btn-block">UPDATE</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection