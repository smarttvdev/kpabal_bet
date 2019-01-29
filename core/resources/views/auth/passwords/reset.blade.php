@extends('layout')

@section('content')
    @include('partials.breadcrumb')

    <!--login section start-->
    <div class="login-section section-padding-2 login-bg" >
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-admin login-admin1" id="min-height-reset">

                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('type') }} alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if (session()->has('status'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        <br>
                        <div class="login-form">
                            <form  method="POST" action="{{ route('user.password.request') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">
                            <input type="text" name="email" id="email"  value="{{$email}}" readonly/>
                                <input type="password" name="password" id="password" required placeholder="Enter your Password"/>
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm Password"/>
                                <input type="submit" value="Reset Password">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--login section end-->

    <script>
        (function($){
            $(window).on('resize',function(){
                var bodyHeight = $(window).height();
                $('#min-height-reset').css('min-height',parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-reset').css('min-height',parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>
@endsection
