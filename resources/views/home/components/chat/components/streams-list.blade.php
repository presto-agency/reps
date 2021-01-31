<section class="streams_list stream-list-wrapper night_modal">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @if(isset($streamList) && $streamList->isNotEmpty())
                @foreach($streamList as $item)
                    <div class="widget-stream-lists">
                        <button type="button" class="js-stream-selector"
                                data-src="{{$item->getSrcIframe()}}"
                                data-img-flag="@if(!is_null($item->countries)){{asset($item->countries->flagOrDefault())}} @endif"
                                data-name-flag="{{optional($item->countries)->name}}"
                                data-img-race="{{asset('images/default/game-races/'.optional($item->races)->title)}}.png"
                                data-title-race="{{optional($item->races)->title}}"
                                data-stream-title="{{$item->title}}">
                            @if($item->countries)
                                <img class="margin-left-5" src="{{asset($item->countries->flagOrDefault())}}"
                                     alt="flag" title="{{$item->countries->name}}">
                            @endif
                            <img class="margin-left-5" alt="race" title="{{optional($item->races)->title}}"
                                 src="{{asset('images/default/game-races/'.optional($item->races)->title)}}.png">
                            <span class="color-blue night_text" title="{{$item->title}}">{{$item->title}}</span>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@if(isset($streamList) && $streamList->isNotEmpty())
    @push('scripts')
        <script type="text/javascript" src="{{ mix('js/assets/streamSelect.js') }}" defer></script>
    @endpush
@endif
