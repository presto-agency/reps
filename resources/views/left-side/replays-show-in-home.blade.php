<section class="block_replay">
    <div class="wrapper border_shadow">
        <div class="title_block_gray change_gray">
            <p class="title_text">РЕПЛЕИ</p>
        </div>
        <div class="row row_game">
            @isset($replaysProLsHome)
                @foreach($replaysProLsHome as $item)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4 wrapper_game">
                        <div class="game_oneSection">
                            <a href="#" class="name_game" title="Busi v Last"><p>{{$item->title}}</p></a>
                            <div class="content_game">
                                <p class="text">Страны:</p>
                                <img class="icon_bars" src="{{asset($item->firstCountries->flag)}}" alt="country_flag"/>
                                <p class="text">vs</p>
                                <img class="icon_bars" src="{{asset($item->secondCountries->flag)}}"
                                     alt="country_flag"/>
                            </div>
                            <div class="content_game">
                                <p class="text">Матчап:</p>
                                <p class="text_matchap">{{$item->firstRaces->code}}</p>
                                <p class="text">vs</p>
                                <p class="text_matchap">{{$item->secondRaces->code}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="container_btn">
            <a href="{{route('replay_pro.index')}}" class="name_game" title="Replay pro">
                <button class="button button__download-more">Пользовательские реплеи</button>
            </a>
        </div>
        <div class="row row_game">
            @isset($replaysProLsHome)
                @foreach($replaysUserLsHome as $item)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4 wrapper_game">
                        <div class="game_oneSection">
                            <a href="#" class="name_game" title="Busi v Last"><p>{{$item->title}}</p></a>
                            <div class="content_game">
                                <p class="text">Страны:</p>
                                <img class="icon_bars" src="{{asset($item->firstCountries->flag)}}" alt="country_flag"/>
                                <p class="text">vs</p>
                                <img class="icon_bars" src="{{asset($item->secondCountries->flag)}}"
                                     alt="country_flag"/>
                            </div>
                            <div class="content_game">
                                <p class="text">Матчап:</p>
                                <p class="text_matchap">{{$item->firstRaces->code}}</p>
                                <p class="text">vs</p>
                                <p class="text_matchap">{{$item->secondRaces->code}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="container_btn">
            <a href="{{route('replay.index')}}" class="name_game" title="Replay">
                <button class="button button__download-more">Пользовательские реплеи</button>
            </a>
        </div>
    </div>
</section>
