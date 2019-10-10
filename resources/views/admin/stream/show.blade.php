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
            <!-- Add a placeholder for the Twitch embed -->
            <div id="twitch-embed"></div>
{{--            <div class="video-link-wrapper">--}}
{{--                {!! $stream->stream_url !!}--}}
{{--            </div>--}}
        </div>
    </div>
</div>
<!-- Load the Twitch embed script -->
<script src="https://embed.twitch.tv/embed/v1.js"></script>

<!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
<script type="text/javascript">
    new Twitch.Embed("twitch-embed", {
        width: 854,
        height: 480,
        channel: "monstercat"
    });
</script>
