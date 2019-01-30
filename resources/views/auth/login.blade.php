@extends('layout')

@section('content')
@include('partials.breadcrumb')

    <!-- Login Section Start -->
    <section class="register-section section-padding-form section-background" >
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="login-admin login-admin1" id="min-height-responive">
                        {{--<div class="login-header">--}}
                        {{--</div>--}}
                        <div class="login-form remove-margin-bottom">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <input type="text" name="username"
                                       class="{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                       value="{{ old('username') }}" placeholder=" Username">
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback red">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>
                                <input type="password" name="password" placeholder="Password"
                                       class="{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>
                                <input type="submit" value="Login">

                                <a href="{{ route('password.request') }}">Forget Password ??</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    (function($){
        $(window).on('resize',function(){
            var bodyHeight = $(window).height();
            $('#min-height-responive').css('min-height',parseInt(bodyHeight) - 650);
            console.log(bodyHeight)
        })
        var bodyHeight = $(window).height();
        $('#min-height-responive').css('min-height',parseInt(bodyHeight) - 650);
        console.log(bodyHeight)


    }(jQuery))
</script>
@endsection
