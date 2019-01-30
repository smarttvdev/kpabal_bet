@extends('layout')

@section('content')
    @include('partials.breadcrumb')

    <!--login section start-->
    <div class="login-section section-padding-2 login-bg section-background">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-admin login-admin1" id="min-height-email">
                        <div class="login-form">


                            <form method="POST" action="{{ route('user.password.email') }}">
                                {{ csrf_field() }}
                                <input type="text" name="email" id="email" required placeholder="Enter your Email"/>

                                <input type="submit" value=" Send Password Reset Link">

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
                $('#min-height-email').css('min-height',parseInt(bodyHeight) - 550);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-email').css('min-height',parseInt(bodyHeight) - 550);
            console.log(bodyHeight)


        }(jQuery))
    </script>

@endsection
