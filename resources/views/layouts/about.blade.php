@extends('layout')
@section('content')

  @include('partials.breadcrumb')

    <!--about us page content start-->
    <section class="section-padding about-us-page ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $basic->about !!}
                </div>
            </div>
        </div>
    </section>
@stop