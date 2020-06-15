<section class="streams_list stream-list-wrapper night_modal">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @if(isset($streamList) && $streamList->isNotEmpty())
                @foreach($streamList as $item)
                    <div class="widget-stream-lists">
                        <button class="streamEvent" id="{{$loop->iteration }}"
                                data-src="{{$item->getSrcIframe()}}"
                                data-img-flag="@if(!is_null($item->countries)){{asset($item->countries->flagOrDefault())}} @endif"
                                data-name-flag="@if(!is_null($item->countries)){{$item->countries->name}} @endif"
                                data-img-race="@if(!is_null($item->races)){{asset('images/default/game-races/'.$item->races->title.'.png')}}@endif"
                                data-title-race="@if(!is_null($item->races)){{$item->races->title}}@endif"
                                data-stream-title="{{$item->title}}">
                            @if(!is_null($item->countries))
                                <img class="margin-left-5" src="{{asset($item->countries->flagOrDefault())}}" alt="flag"
                                     title="{{$item->countries->name}}">
                            @endif
                            @if(!is_null($item->races))
                                <img class="margin-left-5" alt="race" title="{{$item->races->title}}"
                                     src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}">
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
    @parent
    <script type="text/javascript" defer>
        $(document).ready(function () {
            const div = $('#streamOnline');
            const divName = $('#streamOnlineName');
            const divRace = $('#streamOnlineRace');
            const divFlag = $('#streamOnlineFlag');
            let element = document.getElementById("1");
            div.attr('src', element.getAttribute('data-src'));
            divFlag.attr('src', element.getAttribute('data-img-flag'));
            divFlag.attr('title', element.getAttribute('data-name-flag'));
            divRace.attr('src', element.getAttribute('data-img-race'));
            divRace.attr('title', element.getAttribute('data-title-race'));
            divName.attr('title', element.getAttribute('data-stream-title'));
            divName.text(element.getAttribute('data-stream-title'));

            $('.streamEvent').click(function () {
                div.attr('src', $(this).data('src'));
                divFlag.attr('src', $(this).data('img-flag'));
                divFlag.attr('title', $(this).data('name-flag'));
                divRace.attr('src', $(this).data('img-race'));
                divRace.attr('title', $(this).data('title-race'));
                divName.attr('title', $(this).data('stream-title'));
                divName.text($(this).data('stream-title'));
            });
        });

    </script>
@endsection
