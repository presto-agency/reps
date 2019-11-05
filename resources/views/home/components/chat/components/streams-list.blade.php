<section class="streams_list stream-list-wrapper night_modal">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @isset($streamList)
                @foreach($streamList as $item)
                    <div class="widget-stream-lists">
                        <button class="streamEvent" id="{{$item->id}}" data-src="{{$item->stream_url}}">
                            <img class="margin-left-5" src="{{asset($item->countries->flag)}}" alt="flag"
                                 title="{{$item->countries->name}}">
                            <img class="margin-left-5"
                                 src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}" alt="race"
                                 title="{{$item->races->title}}">
                            <span class="color-blue night_text" title="{{$item->title}}">{{$item->title}}</span>
                        </button>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</section>
<script>
    $('.streamEvent').click(function () {
        $('#streamOnline').attr('src', $(this).data('src'));
    });
</script>
