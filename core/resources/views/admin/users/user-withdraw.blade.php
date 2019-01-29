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
                        <span class="caption-subject bold uppercase">{{$page_title}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover order-column" id="">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>#TRX</th>
                            <th>Gateway</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deposits as $data)
                            <tr>
                                <td>
                                    <a href="{{route('user.single', $data->user->id)}}">
                                        {{$data->user->username}}
                                    </a>
                                </td>

                                <td>{{$data->transaction_id}}</td>
                                <td>{{$data->method->name}}</td>
                                <td><strong>{{$data->amount}} {{$basic->currency}}</strong></td>
                                <td>
                                    @if($data->status == 1)
                                    <a href="" class="btn btn-outline btn-circle btn-sm green">
                                         Completed </a>
                                        @else
                                        <a href="" class="btn btn-outline btn-circle btn-sm red">
                                          Pending </a>
                                    @endif
                                </td>
                                <td>
                                    {{$data->updated_at}}
                                </td>
                            </tr>
                        @endforeach
                        <tbody>
                    </table>

                    {!! $deposits->links() !!}

                </div>
            </div>

        </div>
    </div>

@endsection