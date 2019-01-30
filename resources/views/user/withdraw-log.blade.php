@extends('user')
@section('content')


    @include('partials.breadcrumb')
    <section class="about-section section-padding-2 section-bg-clr1">
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
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Trx</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invests as $k=>$data)
                                    <tr>
                                        <td data-label="SL">{{++$k}}</td>
                                        <td data-label="#Trx">{{$data->transaction_id or 'N/A'}}</td>
                                        <td data-label="Method">{!! $data->method->name  or 'N/A' !!}</td>
                                        <td data-label="Amount">{!! $data->amount  or 'N/A' !!} {!! $basic->currency !!}</td>
                                        <td data-label="Charge">{!! number_format($data->charge, $basic->decimal) !!} {!! $basic->currency !!}</td>
                                        <td data-label="Status">
                                            @if($data->status == 1)
                                            <button class="btn yellow btn-sm edit_button" title="Bet Option">
                                                Pending
                                            </button>
                                            @elseif($data->status == 2)
                                            <button class="btn green btn-sm edit_button" title="Bet Option">
                                                Approved
                                            </button>
                                            @elseif($data->status == 3)
                                                <button class="btn red btn-sm edit_button" title="Bet Option">
                                                    Refunded
                                                </button>
                                                @endif

                                        </td>
                                        <td data-label="Time">{!! $data->created_at  or 'N/A' !!} </td>
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