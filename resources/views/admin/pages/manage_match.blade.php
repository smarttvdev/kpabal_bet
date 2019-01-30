@extends('admin.layout.master')

@section('body')
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$page_title}}

                <a href="{{route('add.match')}}" class="btn btn-success pull-right btn-md  edit_button">
                    <i class="fa fa-plus"></i> Add Match
                </a>
            </h3>
            <hr>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Match LIST</span>
                    </div>
                    <div class="tools"></div>
                    <div class="actions">
                        <form method="POST" class="form-inline" action="{{route('admin.search.matches')}}">
                            {{csrf_field()}}
                            <input type="text" name="search" class="form-control" placeholder="Search">
                            <button class="btn btn-outline btn-circle btn-sm green" type="submit"><i
                                        class="fa fa-search"></i></button>

                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Event</th>
                            <th>Questions</th>
                            <th>Options</th>
                            <th>STATUS</th>
                            <th style="width: 18%;">ACTION</th>
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
                                    <a href="{{route('view.question', $mac->id )}}" class="btn btn-info btn-md edit_button" title="View Question">
                                        <strong>{{$mac->questions()->count()}}</strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('view.allOption', $mac->id )}}" class="btn btn-warning btn-md edit_button" title="View Option">
                                        <strong>{{$mac->options()->count()}}</strong>
                                    </a>
                                </td>

                                <td>
                                    <b class="btn btn-sm btn-{{ $mac->status ==0 ? 'warning' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</b>
                                </td>
                                <td>
                                    <a href="{{route('edit.match', $mac->id )}}" class="btn purple btn-sm edit_button">
                                        <i class="fa fa-edit"></i> EDIT
                                    </a>
                                    {{--<a href="{{route('add.question', $mac->id )}}" class="btn blue btn-sm edit_button" title="Add Question">--}}
                                        {{--<i class="fa fa-plus"></i>--}}
                                    {{--</a>--}}

                                    <a href="{{route('view.question', $mac->id )}}" class="btn green btn-sm edit_button" title="View Question">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{route('add.option', $mac->id )}}" class="btn blue-dark btn-sm edit_button" title="Bet Option">
                                        <i class="fa fa-check-circle"></i>
                                    </a>

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