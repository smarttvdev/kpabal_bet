@extends('layout')
@section('content')

  @include('partials.breadcrumb')

    <!--about us page content start-->
    <section class="section-padding about-us-page " id="min-height-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $menu->description !!}
                </div>
            </div>
        </div>
    </section>

  <script>
      (function($){
          $(window).on('resize',function(){
              var bodyHeight = $(window).height();
              $('#min-height-menu').css('min-height',parseInt(bodyHeight) - 500);
              console.log(bodyHeight)
          })
          var bodyHeight = $(window).height();
          $('#min-height-menu').css('min-height',parseInt(bodyHeight) - 500);
          console.log(bodyHeight)


      }(jQuery))
  </script>
@stop