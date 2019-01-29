@extends('layout')
@section('content')

    @include('partials.breadcrumb')

    <!--Contact Section-->
    <section class="contact-section contact-section1 section-padding section-background" id="min-height-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--Contact Info Tabs-->
                    <div class="contact-info">
                        <div class="row ">
                            <!-- contact-content Start -->
                            <div class="col-md-4">
                                <div class="contact-content">
                                    <div class="contact-header contact-form">
                                        <h2 class="white">Get In Touch</h2>
                                    </div>
                                    <div class="contact-list">
                                        <ul>
                                            <li>
                                                <div class="contact-thumb"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                                <div class="contact-text">
                                                    <p class="white">Address:<span class="white">{{ $basic->address }}</span></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact-thumb"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                                <div class="contact-text">
                                                    <p class="white">Call Us :<span class="white">{{ $basic->phone }}</span></p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact-thumb"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                                <div class="contact-text">
                                                    <p class="white">Mail Us :<span class="white">{{ $basic->email }}</span></p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- contact-content End -->
                            <!--Form Column-->
                            <div class="form-column col-md-8 col-sm-12 login-admin login-admin1">
                                <!-- Contact Form -->
                                <div class="contact-form ">
                                    <h2 class="white">Send Message Us</h2>

                                    <form action="{{ route('contact-submit') }}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="row clearfix">
                                            <div class="col-md-6  col-xs-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <input type="text" name="name" placeholder="Your Name*" required>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-6  col-xs-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input type="email" name="email" placeholder="Email Address*" required>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class=" col-md-12   form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                                <textarea name="message" placeholder="Your Message..." required></textarea>
                                                @if ($errors->has('message'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('message') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class=" col-md-12 form-group">
                                                <button class="theme-btn btn-style-one" type="submit" name="submit-form">Send Message</button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <!--End Comment Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Section-->


    <script>
        (function($){
            $(window).on('resize',function(){
                var bodyHeight = $(window).height();
                $('#min-height-contact').css('min-height',parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-contact').css('min-height',parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>

@stop