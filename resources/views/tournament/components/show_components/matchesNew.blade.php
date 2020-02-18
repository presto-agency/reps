@foreach($data['round'] as $key => $item)
    <div class="title_players change_gray">
        <p class="title_playersText">{{$item['title']}}</p>
        @if(!empty($item['mapName']) && !empty($item['mapUrl']))
            @if(!empty($item['mapUrl']) && checkFile::checkFileExists($item['mapUrl']))
                <a href='{{asset($item['mapUrl'])}}' title='{{$item['mapName']}}'>{{$item['mapName']}}</a>
            @else
                <a href='{{asset('images/default/map/nominimap.png')}}'
                   title='{{$item['mapName']}}'>{{$item['mapName']}}</a>
            @endif
        @endif
    </div>
    @if(!empty($data['matches']))
        @foreach($data['matches'][$key] as $items)
            @if(isset($items) && $items->isNotEmpty())
                @foreach($items as $item)
                    @include('tournament.components.show_components.matchNew',['item'=>$item])
                @endforeach
            @endif
        @endforeach
    @endif
@endforeach
