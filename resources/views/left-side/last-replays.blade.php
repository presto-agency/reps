<section class="block_replay">
    <div class="wrapper border_shadow">
        <div class="title_block_gray change_gray">
            <p class="title_text">{{__('Реплеи')}}</p>
        </div>
        <div class="row row_game">
            @isset($replaysProLsHome)
                @foreach($replaysProLsHome as $item)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4 wrapper_game">
                        <div class="game_oneSection">
                            <a href="{{route('replay.show',['replay'=>$item->id, 'type' => 'pro'])}}" class="name_game"
                               title="{!! strip_tags(ParserToHTML::toHTML($item->title,'size')) !!}">{!! ParserToHTML::toHTML($item->title,'size') !!}</a>
                            <div class="content_game">
                                <p class="text">Страны:</p>
                                @isset($item->firstCountries)
                                    <img class="icon_bars" src="{{asset($item->firstCountries->flagOrDefault())}}"
                                         alt="flag" title="{{$item->firstCountries->name}}"/>
                                @endisset
                                <p class="text">vs</p>
                                @isset($item->secondCountries)
                                    <img class="icon_bars" src="{{asset($item->secondCountries->flagOrDefault())}}"
                                         alt="flag" title="{{$item->secondCountries->name}}"/>
                                @endisset
                            </div>
                            <div class="content_game">
                                <p class="text">Матчап:</p>
                                @isset($item->firstRaces)
                                    <p class="text_matchap"
                                       title="{{$item->firstRaces->title}}">{{$item->firstRaces->code}}</p>
                                @endisset
                                <p class="text">vs</p>
                                @isset($item->secondRaces)
                                    <p class="text_matchap"
                                       title="{{$item->secondRaces->title}}">{{$item->secondRaces->code}}</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="container_btn">
            <a href="{{route('replay.index',['type' =>'pro'])}}" class="name_game" title="ДРУГИЕ ГОСУ РЕПЛЕИ">
                <button class="button button__download-more">{{__('ДРУГИЕ ГОСУ РЕПЛЕИ')}}</button>
            </a>
        </div>
        <div class="row row_game">
            @isset($replaysUserLsHome)
                @foreach($replaysUserLsHome as $item)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4 wrapper_game">
                        <div class="game_oneSection">
                            <a href="{{route('replay.show',['replay'=>$item->id, 'type' => 'user'])}}" class="name_game"
                               title="{!! strip_tags(ParserToHTML::toHTML($item->title,'size')) !!}">{!! ParserToHTML::toHTML($item->title,'size') !!}</a>
                            <div class="content_game">
                                <p class="text">{{__('Страны:')}}</p>
                                @isset($item->firstCountries)
                                    <img class="icon_bars" src="{{asset($item->firstCountries->flagOrDefault())}}"
                                         alt="flag" title="{{$item->firstCountries->name}}"/>
                                @endisset
                                <p class="text">{{__('vs')}}</p>
                                @isset($item->secondCountries)
                                    <img class="icon_bars" src="{{asset($item->secondCountries->flagOrDefault())}}"
                                         alt="flag" title="{{$item->secondCountries->name}}"/>
                                @endisset
                            </div>
                            <div class="content_game">
                                <p class="text">{{__('Матчап:')}}</p>
                                @isset($item->firstRaces)
                                    <p class="text_matchap"
                                       title="{{$item->firstRaces->title}}">{{$item->firstRaces->code}}</p>
                                @endisset
                                <p class="text">{{__('vs')}}</p>
                                @isset($item->secondRaces)
                                    <p class="text_matchap"
                                       title="{{$item->secondRaces->title}}">{{$item->secondRaces->code}}</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="container_btn">
            <a href="{{route('replay.index',['type' =>'user'])}}" class="name_game">
                <button class="button button__download-more">{{__('Пользовательские реплеи')}}</button>
            </a>
        </div>
    </div>
</section>
