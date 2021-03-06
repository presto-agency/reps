<section class="Page_gameBest">
    <div class="wrapper border_shadow">
        <div class="title_block">
            <div class="left_content">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     x="0px" y="0px"
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
            <p class="title_playersText change_gray">{{__('Top-100')}} </p>
            <img  alt="minerals" class="minerals_icons" src="{{asset('images/minerals_icons/min.png') }}">
        </div>
        <div class="container_players">
            @if(isset($points) && $points->isNotEmpty())
                @foreach($points as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'. $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                @auth
                                    @if(auth()->user()->userViewAvatars())
                                        <img src="{{asset($item->avatarOrDefault())}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @else
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                <span class="name_player" title="{{$item->name}}">{{$item->name}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            @if(!empty($item->countries))
                                <img src="{{asset($item->countries->flagOrDefault())}}"
                                     title="{{$item->countries->name}}"
                                     class="info__flag" alt="flag">
                            @endif
                            @if(!empty($item->races))
                                <img src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}"
                                     title="{{$item->races->title}}" class="info__cube" alt="race">
                            @endif
                        </div>
                        <div class="right_block">
                            <span class="night_text">{{$item->comments_count}}</span>
                            <img alt="minerals" class="minerals_icons" src="{{asset('images/minerals_icons/min.png') }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100')}}</p>
            <img alt="supply" class="minerals_icons" src="{{asset('images/minerals_icons/supp.png') }}">
        </div>
        <div class="container_players">
            @if(isset($rating) && $rating->isNotEmpty())
                @foreach($rating as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'. $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                @auth
                                    @if(auth()->user()->userViewAvatars())
                                        <img src="{{asset($item->avatarOrDefault())}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @else
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                <span class="name_player" title="{{$item->name}}">{{$item->name}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            @if(!empty($item->countries))
                                <img src="{{asset($item->countries->flagOrDefault())}}"
                                     title="{{$item->countries->name}}"
                                     class="info__flag" alt="flag">
                            @endif
                            @if(!empty($item->races))
                                <img src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}"
                                     title="{{$item->races->title}}" class="info__cube" alt="race">
                            @endif
                        </div>
                        <div class="right_block">
                            <span class="night_text">{{$item->rating}}</span>
                            <img alt="supply" class="minerals_icons" src="{{asset('images/minerals_icons/supp.png') }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{--        new gaz--}}
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 gas')}}</p>
            <img alt="gas" class="minerals_icons" src="{{asset('images/minerals_icons/gaz.png') }}">
        </div>
        <div class="container_players">
            @if(isset($gas) && $gas->isNotEmpty())
                @foreach($gas as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'. $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                @auth
                                    @if(auth()->user()->userViewAvatars())
                                        <img src="{{asset($item->avatarOrDefault())}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @else
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                <span class="name_player" title="{{$item->name}}">{{$item->name}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            @if(!empty($item->countries))
                                <img src="{{asset($item->countries->flagOrDefault())}}"
                                     title="{{$item->countries->name}}"
                                     class="info__flag" alt="flag">
                            @endif
                            @if(!empty($item->races))
                                <img src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}"
                                     title="{{$item->races->title}}" class="info__cube" alt="race">
                            @endif
                        </div>
                        <div class="right_block">
                            <span class="night_text">{{$item->gas_balance}}</span>
                            <img alt="gas" class="minerals_icons" src="{{asset('images/minerals_icons/gaz.png') }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{--        end new gaz--}}
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 news')}}</p>
        </div>
        <div class="container_players">
            @if(isset($news) && $news->isNotEmpty())
                @foreach($news as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'. $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                @auth
                                    @if(auth()->user()->userViewAvatars())
                                        <img src="{{asset($item->avatarOrDefault())}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @else
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                <span class="name_player" title="{{$item->name}}">{{$item->name}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            @if(!empty($item->countries))
                                <img src="{{asset($item->countries->flagOrDefault())}}"
                                     title="{{$item->countries->name}}"
                                     class="info__flag" alt="flag">
                            @endif
                            @if(!empty($item->races))
                                <img src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}"
                                     title="{{$item->races->title}}" class="info__cube" alt="race">
                            @endif
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item->news_count}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_players change_gray">
            <p class="title_playersText">{{__('Top-100 replays')}}</p>
        </div>
        <div class="container_players">
            @if(isset($replay) && $replay->isNotEmpty())
                @foreach($replay as $item)
                    <div class="players_content">
                        <div class="left_block">
                            <span class="number night_text">{{'#'. $loop->iteration }} {{-- Starts with 1 --}}</span>
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                @auth
                                    @if(auth()->user()->userViewAvatars())
                                        <img src="{{asset($item->avatarOrDefault())}}"
                                             class="author__avatar img-fluid" alt="avatar">
                                    @endif
                                @else
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                <span class="name_player" title="{{$item->name}}">{{$item->name}}</span>
                            </a>
                        </div>
                        <div class="center_block">
                            @if(!empty($item->countries))
                                <img src="{{asset($item->countries->flagOrDefault())}}"
                                     title="{{$item->countries->name}}"
                                     class="info__flag" alt="flag">
                            @endif
                            @if(!empty($item->races))
                                <img src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}"
                                     title="{{$item->races->title}}" class="info__cube" alt="race">
                            @endif
                        </div>
                        <div class="right_block">
                            <p class="night_text">{{$item->replays_count}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
