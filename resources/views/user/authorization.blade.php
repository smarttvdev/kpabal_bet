@extends('layout')
@section('content')

    @include('partials.breadcrumb')

    <!-- Login Section Start -->
    <section class="register-section section-padding-form section-background">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="login-admin login-admin1" id="min-height-authrization">

                        <div class="login-form remove-margin-bottom">

                            @if(Auth::user()->status == 0)

                                <h2 class="text-danger"> Your Account Has been Deactived</h2>
                                @endif


                            @if(Auth::user()->email_verify == 0 && Auth::user()->phone_verify == 0)
                                <form class="row contact-form" method="POST" action="{{route('user.send-emailVcode') }}">
                                    @csrf
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                        <p class="text-center">Your E-mail Address:<strong> {{Auth::user()->email}}</strong> </p>

                                        <div class="col-md-12 text-center">
                                            <button  type="submit" class="wow fadeInUp">Send Verification Code</button>
                                        </div>
                                    </div>
                                </form>
                                <br>


                                <form class="row contact-form" method="POST" action="{{ route('user.email-verify')}}">
                                    @csrf
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                        <div class="col-md-12">
                                            <input name="email_code" type="text" placeholder="Enter Verification Code"  required autofocus>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="wow fadeInUp">Submit</button>
                                        </div>
                                    </div>
                                </form>

                                @elseif(Auth::user()->email_verify == 0)
                                <form class="row contact-form" method="POST" action="{{route('user.send-emailVcode') }}">
                                    @csrf
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                        <p class="text-center">Your E-mail Address:<strong> {{Auth::user()->email}}</strong> </p>

                                        <div class="col-md-12 text-center">
                                            <button  type="submit" class="wow fadeInUp">Send Verification Code</button>
                                        </div>
                                    </div>
                                </form>
                                <br>

                                <form class="row contact-form" method="POST" action="{{ route('user.email-verify')}}">
                                    @csrf
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                        <div class="col-md-12">
                                            <input name="email_code" type="text" placeholder="Enter Verification Code"  required autofocus>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="wow fadeInUp">Submit</button>
                                        </div>
                                    </div>
                                </form>



                            @elseif(Auth::user()->phone_verify == 0)
                            <form class="row contact-form" method="POST" action="{{route('user.send-vcode') }}">
                                @csrf
                                <div class="col-md-8 col-md-offset-2">
                                    <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                    <p class="text-center">Your Mobile No:<strong> {{Auth::user()->phone}}</strong> </p>

                                    <div class="col-md-12 text-center">
                                        <button  type="submit" class="wow fadeInUp">Send Verification Code</button>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <form class="row contact-form" method="POST" action="{{ route('user.sms-verify')}}">
                                @csrf
                                <div class="col-md-8 col-md-offset-2">
                                    <input type="hidden"  name="id" value="{{Auth::user()->id}}">
                                    <div class="col-md-12">
                                        <input name="sms_code" type="text" placeholder="Enter Verification Code"  required autofocus>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="wow fadeInUp">Submit</button>
                                    </div>
                                </div>
                            </form>

                            @endif


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
                $('#min-height-authrization').css('min-height',parseInt(bodyHeight) - 650);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-authrization').css('min-height',parseInt(bodyHeight) - 650);
            console.log(bodyHeight)


        }(jQuery))
    </script>
@stop