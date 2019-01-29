@extends('admin.layout.master')

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
                        <span class="caption-subject bold uppercase">Match LIST</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Event</th>
                            <th>End Time</th>
                            <th style="width: 15%;"> Bet Amount</th>
                            <th style="width: 15%;"> Return Amount</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($matches as $k=>$mac)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$mac->name or 'N/A'}}</td>
                                <td>
                                    <strong>{{$mac->event->name or 'N/A'}}</strong>
                                </td>

                                <td>
                                    {{Carbon\carbon::parse($mac->end_date)->format('d M Y H:i A') }}
                                </td>


                                <td>
                                    <button class="btn btn-success btn-md " >
                                        <strong>{{$mac->betInvests()->sum('invest_amount')}} {!! $basic->currency !!}</strong>
                                    </button>
                                </td>

                                <td>
                                    <button class="btn btn-warning btn-md " >
                                        <strong>{{$mac->betInvests()->sum('return_amount')}} {!! $basic->currency !!}</strong>
                                    </button>
                                </td>


                                <td>
                                    <b class="btn btn-md btn-{{ $mac->status ==2 ? 'danger' : 'success' }}">{{ $mac->status == 2 ? 'Closed' : 'Active' }}</b>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! $matches->links() !!}
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')

@endsection