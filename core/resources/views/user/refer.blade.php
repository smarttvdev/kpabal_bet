@extends('user')
@section('content')


    @include('partials.breadcrumb')
    <section class="about-section section-padding-2 section-bg-clr1" id="min-height-trx">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">

                        <h6>Get {{$basic->refcom}}% interest per deposit </h6>
                            <div class="input-group reference-url">
                                <input class="btn btn-lg reference-input"  id="myInput"  type="text" value=" {{ route('refer.register',auth::user()->username) }}">
                                <button class="copy btn btn-primary btn-lg" type="button" onclick="myFunction()">Copy</button>
                            </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{$page_title}}
                            </div>
                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invests as $k=>$data)
                                    <tr class="greenbg">
                                        <td data-label="SL">{{++$k}}</td>
                                        <td data-label="Email">{{$data->username or 'sdf' }} </td>
                                        <td data-label="Email">{!! $data->email  or 'sdf' !!} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $invests->links()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Hostonion End -->



    <script>
        (function($){
            $(window).on('resize',function(){
                var bodyHeight = $(window).height();
                $('#min-height-trx').css('min-height',parseInt(bodyHeight) - 650);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-trx').css('min-height',parseInt(bodyHeight) - 650);
            console.log(bodyHeight)


        }(jQuery));


        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");

        }
    </script>
@stop