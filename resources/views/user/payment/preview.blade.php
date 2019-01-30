@extends('user')
@section('content')

    @include('partials.breadcrumb')

    <!-- Blog Single Section Start -->
    <div class="blog-section blog-section2 section-padding section-background" id="min-height-home">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 ">
                    <div class="row">
                        @include('partials.flash-msg')
                        <div class="col-md-12 ">
                            <div class="panel panel-primary">
                                <div class="panel-title">
                                    <h5 class="panel-title-padding"><i class="fa fa-desktop"></i> DEPOSIT PREVIEW</h5>
                                </div>

                                <form class="contact-form" method="POST" action="{{route('deposit.confirm')}}">
                                    {{csrf_field()}}
                                    <div class="panel-body table-responsive text-center">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <img src="{{asset('assets/images/gateway')}}/{{$data->gateway_id}}.jpg" style="max-width:100px; max-height:100px; margin:0 auto;"/>
                                            </li>
                                            <li class="list-group-item"> Amount : {{$data->amount}}
                                                <strong>{{$basic->currency}}</strong>
                                            </li>

                                            <li class="list-group-item"> Charge : <strong>{{$data->charge}} </strong>{{ $basic->currency }}</li>
                                            <li class="list-group-item"> Payable :
                                                <strong>{{$data->charge + $data->amount}} </strong>{{ $basic->currency }}</li>


                                            <li class="list-group-item"> In USD :
                                                <strong>${{$data->usd_amo}}</strong>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"> Pay Now</button>
                                    </div>

                                </form>



                            </div>
                        </div>
                    </div>
                </div>
                <!--end left column-->

            </div>
        </div>
    </div>

    <!-- Blog Single Section End -->

    <div class="clearfix"></div>

@stop