<div class="container">
    <div class="row">
        <div class="col-md-5">
            <p>{{__('Название:')}}{{ $stream->title }}</p>
            <p>{{__('Страна:')}}{{ $stream->countries->name }}</p>
            <p>{{__('Раса:')}}{!! $stream->races->title !!}</p>
            <p>{{__('Подтвержден:')}}{!! $stream->approved == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-minus'></i>"!!}</p>
            <p>{{__('Коментарий:')}}{!! ParserToHTML::toHTML($stream->content,'size') !!}</p>
            <p>{{__('Stream:url')}} = {{$stream->stream_url}}</p>
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

