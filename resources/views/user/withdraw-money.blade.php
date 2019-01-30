@extends('user')
@section('content')


    @include('partials.breadcrumb')
    <section class="about-section section-padding-2 section-bg-clr1">
        <div class="container">


                            <div class="row">
                                <div class="col-md-12">

                                        <div class=" table-responsive">
                                            @foreach($withdrawMethod as $gate)
                                                <div class="col-md-3">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">{{$gate->name}}</h4>
                                                        </div>
                                                        <div class="panel-body text-center">
                                                            <img src="{{asset('assets/images/')}}/{{$gate->image}}" style="width:100%;"> <br><br>
                                                            <ul style="font-size: 15px;" class="list-group text-center">
                                                                <li class="list-group-item">Minimum - {{$gate->withdraw_min}} {{ $basic->currency }} </li>
                                                                <li class="list-group-item">Maximum - {{$gate->withdraw_max}} {{ $basic->currency }} </li>
                                                                <li class="list-group-item"> Charge - {{$gate->fix}} {{ $basic->currency }}+ {{$gate->percent}}%</li>
                                                                <li class="list-group-item">Processing Time - {{$gate->duration}} Days </li>
                                                            </ul>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#withdrawModal{{$gate->id}}">Select  </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Buy Modal -->
                                                <div id="withdrawModal{{$gate->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h6 class="modal-title">Withdraw via <strong>{{$gate->name}}</strong></h6>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{route('withdraw.preview') }}">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="method_id" value="{{$gate->id}}">
                                                                    <strong style="color: #0066cc; text-align: center;">Limit {{ $gate->withdraw_min }} {{ $basic->currency }} - {{ $gate->withdraw_max }} {{ $basic->currency}}</strong><br>
                                                                    <strong style="color: #0066cc; text-align: center;">Charge {{ $gate->fix }} {{ $basic->currency}} + {{ $gate->percent }}%</strong>
                                                                    <hr/>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" name="amount" class="form-control" id="amount" required>
                                                                            <span class="input-group-addon">
                                                                                {{$basic->currency}}
                                                                              </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary btn-block">
                                                                            Preview
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                </div>
                            </div>



        </div>
    </section>
    <!-- About Hostonion End -->




@stop