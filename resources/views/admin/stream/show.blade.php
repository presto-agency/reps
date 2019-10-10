<div class="container">
    <div class="row">
        <div class="col-md-5">
            <p>Название: {{$stream->title}}</p>
            <p>Страна: {{$stream->countries->name}}</p>
            <p>Раса: {{$stream->races->title}}</p>
            <p>
                Подтвержден: {!! $stream->approved == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-minus'></i>"!!}</p>
            <p>Коментарий: {!! $stream->content !!}</p>
        </div>
        <div class="col-md-7">
{{--            <div class="video-link-wrapper">--}}
{{--                {!! $stream->stream_url !!}--}}
{{--            </div>--}}
        </div>
    </div>
</div>

