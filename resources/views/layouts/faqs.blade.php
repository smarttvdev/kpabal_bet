@extends('layout')
@section('content')

    @include('partials.breadcrumb')

    <!--faq page content start-->
    <section class="faq-section section-padding section-background " id="min-height-faq">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="faq">
                        <div class="container">
                            <div class="faq-content">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="domainsTab">
                                        <div class="panel-group accordion" id="accordion4" >
                                            @foreach($faqs as $k => $f)
                                                <div class="panel panel-default  active faqmar">
                                                    <div class="panel-heading" role="tabpanel">

                                                        <h4 class="panel-title"> <a href="#domainsTabQ{{ $f->id }}"  style="color: #fff" role="button" data-toggle="collapse" data-parent="#accordion4"   aria-expanded="false"class="collapsed "> {{ $f->title }} <i class="fa fa-minus"></i> </a></h4>
                                                    </div>
                                                    <div id="domainsTabQ{{ $f->id }}" class="panel-collapse collapse @if($k == 0) in @endif" role="tabpanel" @if($k == 0) aria-expanded="true" @else  aria-expanded="false"  @endif   @if($k == 0) class="height-173" @else  class="height-173"@endif>
                                                        <div class="panel-body secondery">
                                                           {!!  $f->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                $('#min-height-faq').css('min-height',parseInt(bodyHeight) - 450);
                console.log(bodyHeight)
            })
            var bodyHeight = $(window).height();
            $('#min-height-faq').css('min-height',parseInt(bodyHeight) - 450);
            console.log(bodyHeight)


        }(jQuery))
    </script>
@stop