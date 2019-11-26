<section class="streams_list stream-list-wrapper night_modal">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @isset($streamList)
                @foreach($streamList as $item)
                    <div class="widget-stream-lists">
                        <button class="streamEvent" id="{{$item->id}}"
                                data-src="{{$item->stream_url_iframe}}"
                                data-img-flag="@if($item->countries){{asset($item->countries->flagOrDefault())}} @endif"
                                data-name-flag="@if($item->countries){{$item->countries->name}} @endif"
                                data-img-race="@if($item->races){{asset('images/default/game-races/'.$item->races->title.'.png')}}@endif"
                                data-title-race="@if($item->races){{$item->races->title}}@endif"
                                data-stream-title="{{$item->title}}"
                        >
                            @if($item->countries)
                            <img class="margin-left-5" src="{{asset($item->countries->flagOrDefault())}}" alt="flag"
                                 title="{{$item->countries->name}}">
                            @endif
                             @if($item->races)
                            <img class
                                 ="margin-left-5"
                                 src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}" alt="race"
                                 title="{{$item->races->title}}">
                           @endif
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

        $('#streamOnlineFlag').attr('src', $(this).data('img-flag'));
        $('#streamOnlineFlag').attr('title', $(this).data('name-flag'));

        $('#streamOnlineRace').attr('src', $(this).data('img-race'));
        $('#streamOnlineRace').attr('title', $(this).data('title-race'));

        $('#streamOnlineName').attr('title', $(this).data('stream-title'));
        $('#streamOnlineName').text($(this).data('stream-title'));
    });
</script>
