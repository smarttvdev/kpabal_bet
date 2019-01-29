<div class="showadd">
@if($adds->type == 1)
    <a target="_blank" href="{{ url('/click-add/'.$adds->id) }}">
        <img src="{{url('/')}}/assets/images/ads/add-pic-{{$adds->id}}.{{$adds->src}}" class="img-responsive" alt="*" style="width: 100%">
    </a>
@else
    <a target="_blank" href="{{ url('/click-add/'.$adds->id) }}">
        {!! $adds->script !!}
    </a>
@endif
</div>