@extends('layout')

@section('content')
    @include('partials.breadcrumb')
    <!-- Register Section Start -->
    <section class="register-section section-padding-form section-background section-bg-clr1" id="min-height-signup">
        <div class="container">
            <div class="row">


                <div class="col-md-8 col-md-offset-2">
                    @if($basic->registration == 1)
                    <div class="login-admin">

                        <div class="login-form remove-margin-bottom">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                @if(isset($reference))
                                <input type="hidden" name="referBy"  value="{{$reference}}">
                                @endif
                                <input type="text" name="name" placeholder="Enter Your Name" class=" {{ $errors->has('name') ? ' is-invalid' : '' }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback error-color red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>
                                <input type="text" name="username" placeholder="Username" class=" {{ $errors->has('username') ? ' is-invalid' : '' }}">

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback error-color red">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>

                                <input type="email" name="email" placeholder="Enter your E-mail" class="{{ $errors->has('email') ? ' is-invalid' : '' }} ">
                                <div class="margin-bottom-26"></div>
                                @if ($errors->has('email'))
                                    <span class=" error-color red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                <input type="text" name="phone" placeholder="Contact Number" class="{{ $errors->has('phone') ? ' is-invalid' : '' }} ">

                                @if ($errors->has('phone'))
                                    <span class=" error-color red">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>
                                <input type="password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback error-color red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="margin-bottom-26"></div>
                                <input type="password" name="password_confirmation" placeholder="Re-Enter Password">


                                <input type="submit" value="SIGN UP">
                            </form>
                        </div>
                    </div>
                        @else
                        <h3 class="red text">Registration Has been Closed By Admin</h3>
                        @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Register Section End -->


    <script>
        (function($){
            $(window).on('resize',function(){
                var bodyHeight = $(window).height();
                $('#min-height-signup').css('min-height',parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-signup').css('min-height',parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>


@endsection
