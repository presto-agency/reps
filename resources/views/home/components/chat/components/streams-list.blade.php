<section class="streams_list stream-list-wrapper night_modal">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @if(isset($streamList) && $streamList->isNotEmpty())
                @foreach($streamList as $item)
                    <div class="widget-stream-lists">
                        <button class="streamEvent" id="{{$loop->iteration }}"
                                data-src="{{$item->stream_url_iframe}}"
                                data-img-flag="@if($item->countries){{asset($item->countries->flagOrDefault())}} @endif"
                                data-name-flag="@if($item->countries){{$item->countries->name}} @endif"
                                data-img-race="@if($item->races){{asset('images/default/game-races/'.$item->races->title.'.png')}}@endif"
                                data-title-race="@if($item->races){{$item->races->title}}@endif"
                                data-stream-title="{{$item->title}}"
                                @php
                                    $checkTwitch =  parse_url(htmlspecialchars_decode($item->stream_url_iframe))['host'] == 'player.twitch.tv' ?
                                    "1" : "0";
                                if ($checkTwitch == "1"){
                                $chanel =   substr($item->stream_url_iframe, strpos($item->stream_url_iframe, "channel=") + 8);
                                }else{
                                $chanel = 0;
                                }
                                @endphp
                                data-check-twitch="{{$checkTwitch}}"
                                data-twitch-name="{{$chanel}}"
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
            @endif
        </div>
    </div>
</section>
@section('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            let element = document.getElementById("1");
            $('#streamOnline').attr('src', element.getAttribute('data-src'));
            $('#streamOnlineFlag').attr('src', element.getAttribute('data-img-flag'));
            $('#streamOnlineFlag').attr('title', element.getAttribute('data-name-flag'));
            $('#streamOnlineRace').attr('src', element.getAttribute('data-img-race'));
            $('#streamOnlineRace').attr('title', element.getAttribute('data-title-race'));
            $('#streamOnlineName').attr('title', element.getAttribute('data-stream-title'));
            $('#streamOnlineName').text(element.getAttribute('data-stream-title'));

        });
        $('.streamEvent').click(function () {
            $('#streamOnline').attr('src', $(this).data('src'));
            $('#streamOnlineFlag').attr('src', $(this).data('img-flag'));
            $('#streamOnlineFlag').attr('title', $(this).data('name-flag'));
            $('#streamOnlineRace').attr('src', $(this).data('img-race'));
            $('#streamOnlineRace').attr('title', $(this).data('title-race'));
            $('#streamOnlineName').attr('title', $(this).data('stream-title'));
            $('#streamOnlineName').text($(this).data('stream-title'));
            // if ($(this).data('check-twitch') == "1") {
            //
            //     let chatSrc = ' https://www.twitch.tv/embed/' + $(this).data('stream-title') + '/chat';
            //     console.log(chatSrc);
            //     $('#chatTwitch').attr('src', chatSrc);
            // }
        });
    </script>
@endsection
