<section class="block_replay">
    <div class="wrapper">
        <div class="title_top">
            <p class="title_Text">РЕПЛЕИ</p>
        </div>
        <div class="row row_game">
            @foreach($replayPro as $item)
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4">
                    <div class="game_oneSection">
                        <a class="name_game" title="Busi v Last"><p>{{$item['firstName']." v ".$item['secondName']}}</p>
                        </a>
                        <div class="content_game">
                            <p class="text">Страны:</p>
                            <img class="icon_bars" src="{{asset($item['firstCountryFlag25x20'])}}"/>
                            <p class="text">vs</p>
                            <img class="icon_bars" src="{{asset($item['secondCountryFlag25x20'])}}"/>
                        </div>
                        <div class="content_game">
                            <p class="text">Матчап:</p>
                            <p class="text_matchap">{{$item['firstRace']}}</p>
                            <p class="text">vs</p>
                            <p class="text_matchap">{{$item['secondRace']}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container_btn">
            <button class="button button__download-more">Другие профессиональные реплеи</button>
        </div>
        <div class="row row_game">
            @foreach($replayPro as $item)
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-3 col-4">
                    <div class="game_oneSection">
                        <a class="name_game" title="Busi v Last"><p>{{$item['firstName']." v ".$item['secondName']}}</p>
                        </a>
                        <div class="content_game">
                            <p class="text">Страны:</p>
                            <img class="icon_bars" src="{{asset($item['firstCountryFlag25x20'])}}"/>
                            <p class="text">vs</p>
                            <img class="icon_bars" src="{{asset($item['secondCountryFlag25x20'])}}"/>
                        </div>
                        <div class="content_game">
                            <p class="text">Матчап:</p>
                            <p class="text_matchap">{{$item['firstRace']}}</p>
                            <p class="text">vs</p>
                            <p class="text_matchap">{{$item['secondRace']}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container_btn">
            <button class="button button__download-more">Другие пользовательские реплеи</button>
        </div>
    </div>
</section>
