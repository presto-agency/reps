<section class="Page_gameBest">
    <div class="wrapper border_shadow">
        <div class="title_block">
            <div class="left_content">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 475.1 475.1" style="enable-background:new 0 0 475.1 475.1;" xml:space="preserve">
                    <path d="M475.1,186.6c0-7-5.3-11.4-16-13.1l-143.3-20.8L251.5,22.7c-3.6-7.8-8.3-11.7-14-11.7c-5.7,0-10.4,3.9-14,11.7l-64.2,129.9
                        L16,173.4c-10.7,1.7-16,6.1-16,13.1c0,4,2.4,8.6,7.1,13.7l103.9,101.1L86.5,444.1c-0.4,2.7-0.6,4.6-0.6,5.7c0,4,1,7.4,3,10.1
                        c2,2.8,5,4.1,9,4.1c3.4,0,7.2-1.1,11.4-3.4l128.2-67.4l128.2,67.4c4,2.3,7.8,3.4,11.4,3.4c7.8,0,11.7-4.8,11.7-14.3
                        c0-2.5-0.1-4.4-0.3-5.7L364,301.4l103.6-101.1C472.6,195.3,475.1,190.8,475.1,186.6z M324.6,288.5l20.6,120.2l-107.6-56.8
                        l-107.9,56.8l20.8-120.2l-87.4-84.8L183.6,186l54-109.1l54,109.1L412,203.7L324.6,288.5z"/>
                </svg>
                <p class="title_text">Лучшие</p>
            </div>
        </div>
        {{--best-100--}}
        <div class="title_players">
            <p class="title_playersText">Top-100 pts</p>
        </div>
        <div class="container_players">
            @isset($top100Points)
                @foreach($top100Points as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number">#{{$item['id']}}</span>
                            <a href="#">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     ` class="author__avatar img-fluid">
                                <span class="name_player">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="game">
                        </div>
                        <div class="right_block">
                            <p>{{$item['max']}} pts</p>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        {{--top-100-reputation--}}
        <div class="title_players">
            <p class="title_playersText">Top-100 kg</p>
        </div>
        <div class="container_players">
            @isset($top100Rating)
                @foreach($top100Rating as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number">#{{$item['id']}}</span>
                            <a href="#">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="game">
                        </div>
                        <div class="right_block">
                            <p>{{$item['max']}} kg</p>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        {{--top-100-news--}}
        <div class="title_players">
            <p class="title_playersText">Top-100 news</p>
        </div>
        <div class="container_players">
            @isset($top100News)
                @foreach($top100News as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number">#{{$item['id']}}</span>
                            <a href="#">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="game">
                        </div>
                        <div class="right_block">
                            <p>{{$item['max']}} news</p>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        {{--top-100-replays--}}
        <div class="title_players">
            <p class="title_playersText">Top-100 replays</p>
        </div>
        <div class="container_players">
            @isset($top100Replay)
                @foreach($top100Replay as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number">#{{$item['id']}}</span>
                            <a href="#">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="game">
                        </div>
                        <div class="right_block">
                            <p>{{$item['max']}} replays</p>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</section>
