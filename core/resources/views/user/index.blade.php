@extends('user')
@section('content')


<section class="about-section section-padding section-bg-clr1">
    <div class="container">
        @include('partials.flash-msg')
        <div class="row">
            <div class="col-md-6">
                <div class="about-content">
                    <h3>About Loyalhost</h3>
                    <div class="about-desc">
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id  et dolorum fuga.</p>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id  et dolorum fuga.</p>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="about-thumb"><img src="{{asset('assets/front/img/about1.jpg')}}" alt="about"></div>
            </div>
        </div>
    </div>
</section>
<!-- About Hostonion End -->
@stop