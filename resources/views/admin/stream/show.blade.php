<div class="container">
    <div class="row">
        <div class="col-md-5">
            <p>Название: {{$stream->title}}</p>
            <p>Страна: {{$stream->countries->name}}</p>
            <p>Раса: {{$stream->races->title}}</p>
            <p>
                Подтвержден: {!! $stream->approved == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-minus'></i>"!!}</p>
            {{--            <p>Коментарий: {!! $stream->content !!}</p>--}}
            <p>Коментарий: {{ $stream->content }}</p>
            <iframe allowfullscreen="" frameborder="0" src="{{ $stream->stream_url }}"
                    width="640"
                    height="360"
                    autoplay="1"
            ></iframe>
            {{--            <p>{{ $stream->stream_url }}</p>--}}
        </div>
    </div>
</div>

