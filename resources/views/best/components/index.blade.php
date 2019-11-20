@inject('checkFile', 'App\Services\ServiceAssistants\PathHelper')
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
                <p class="title_text ">{{__('Лучшие')}}</p>
            </div>
        </div>
        <div class="title_players change_gray">
            <p class="title_playersText change_gray">{{__('Top-100 pts')}}</p>
        </div>
        <div class="container_players">
            @if(isset($points) && !empty($points))
                @foreach($points as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item['id']])}}">
                                @auth()
                                    @if(auth()->user()->userViewAvatars())
                                        @if(!empty($item['avatar']) && $checkFile::checkFileExists($item['avatar']))
                                            <img src="{{asset($item['avatar'])}}" alt="avatar"
                                                 class="author__avatar img-fluid">
                                        @else
                                            <img src="{{asset('images/default/avatar/avatar.png')}}"
                                                 class="author__avatar img-fluid" alt="avatar">
                                        @endif
                                    @endif
                                @else
                                    @if(!empty($item['avatar']) && $checkFile::checkFileExists($item['avatar']))
                                        <img src="{{asset($item['avatar'])}}" alt="avatar"
                                             class="author__avatar img-fluid">
                                    @else
                                        <img src="{{asset('images/default/avatar/avatar.png')}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @endauth
                                <span class="name_player" title="{{$item['name']}}">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag"
                                 title="{{$item['countryName']}}">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="race"
                                 title="{{$item['raceTitle']}}">
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item['max'].' pts'}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 кг')}}</p>
        </div>
        <div class="container_players">
            @if(isset($rating) && !empty($rating))
                @foreach($rating as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item['id']])}}">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player" title="{{$item['name']}}">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag"
                                 title="{{$item['countryName']}}">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="race"
                                 title="{{$item['raceTitle']}}">
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item['max'].' кг'}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{--top-100-news--}}
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 news')}}</p>
        </div>
        <div class="container_players">
            @if(isset($news) && !empty($news))
                @foreach($news as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'.$loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item['id']])}}">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player" title="{{$item['name']}}"
                                      title="{{$item['name']}}">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag"
                                 title="{{$item['countryName']}}">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="race"
                                 title="{{$item['raceTitle']}}">
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item['max']}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{--top-100-replays--}}
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 replays')}}</p>
        </div>
        <div class="container_players">
            @if(isset($replay) && !empty($replay))
                @foreach($replay as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item['id']])}}">
                                <img src="{{asset($item['avatar'])}}" alt="avatar"
                                     class="author__avatar img-fluid">
                                <span class="name_player" title="{{$item['name']}}">{{$item['name']}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            <img src="{{asset($item['countryFlag25x20'])}}" class="info__flag" alt="flag"
                                 title="{{$item['countryName']}}">
                            <img src="{{asset($item['raceIcon'])}}" class="info__cube" alt="race"
                                 title="{{$item['raceTitle']}}">
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item['max']}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
