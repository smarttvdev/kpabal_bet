@extends('user')
@section('content')


    @include('partials.breadcrumb')
    <section class="about-section section-padding-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{$page_title}}
                            </div>
                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Trx</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invests as $k=>$data)
                                    <tr>
                                        <td  data-label="SL">{{++$k}}</td>
                                        <td  data-label="#Trx">{{$data->trx or '-'}}</td>
                                        <td  data-label="Details">{!! $data->gateway->name  or '-' !!}</td>
                                        <td  data-label="Amount">{!! $data->amount  or '-' !!} {!! $basic->currency !!}</td>
                                        <td  data-label="Time">{!! $data->created_at  or '-' !!} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $invests->links()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Hostonion End -->




@stop