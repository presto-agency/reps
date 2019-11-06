<div class="container">
    <div class="row">
        <div class="col-md-5">
            <p>Название: {{$stream->title}}</p>
            <p>Страна: {{$stream->countries->name}}</p>
            <p>Раса: {{$stream->races->title}}</p>
            <p>
                Подтвержден: {!! $stream->approved == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-minus'></i>"!!}</p>
            <p>Коментарий: {{ $stream->content }}</p>
            <p>iframe(src) = {{$stream->stream_url}}</p>
            <iframe src="{{$stream->stream_url_iframe}}"
                    allowfullscreen="true"
                    width="640"
                    height="360"
                    autoplay="1"
                    scrolling="no"
                    frameborder="0"
            ></iframe>

        </div>
    </div>
</div>

