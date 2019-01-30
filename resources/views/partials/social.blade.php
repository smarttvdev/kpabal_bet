<div class="support-bar-social-links">
    @foreach($social as $data)
    <a href="{{url($data->link)}}" >{!! $data->code !!}</a>
        @endforeach
</div>