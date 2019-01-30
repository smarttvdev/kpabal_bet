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
                        <span class="caption-subject bold uppercase">Banned User List</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                        <tr>
                            <th scope="col"> Name</th>
                            <th scope="col"> Email</th>
                            <th scope="col"> Username</th>
                            <th scope="col"> Phone</th>
                            <th scope="col"> Balance</th>
                            <th scope="col">Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td data-label="Name">
                                    {{$user->name}}
                                </td>
                                <td data-label="Email">
                                    {{$user->email}}
                                </td>
                                <td data-label="Username">
                                    {{$user->username}}
                                </td>
                                <td data-label="Phone">
                                    {{$user->phone}}
                                </td>
                                <td data-label="Balance">
                                    {{number_format(floatval($user->balance), $basic->decimal, '.', '')}} {{$basic->currency_symbol}}
                                </td>
                                <td data-label="Details">
                                    <a href="{{route('user.single', $user->id)}}"
                                       class="btn btn-outline btn-circle btn-sm green">
                                        <i class="fa fa-eye"></i> View </a>
                                </td>
                            </tr>
                        @endforeach
                        <tbody>
                    </table>
                    <?php echo $users->render(); ?>

                </div>
            </div>

        </div>
    </div>



@endsection