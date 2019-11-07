<section class="user_profile">
    <div class="wrapper border_shadow">
        <div class="title_block">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon</metadata>
                <g>
                    <path fill="white"
                          d="M643.4,540.1c84.4-49.4,141.2-140.7,141.2-245.5C784.6,137.4,657.2,10,500,10c-157.2,0-284.6,127.4-284.6,284.6c0,104.8,56.8,196.2,141.2,245.5c-174,59.6-299.3,224.2-299.3,418.4c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5h0.2C120.5,748.9,290.4,579,500,579c209.6,0,379.5,169.9,379.5,379.5h0.2c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5C942.6,764.3,817.4,599.7,643.4,540.1z M500,515.9c-10.1,0-19.9,0.9-29.8,1.5c-108.1-14.9-191.5-108.8-191.5-222.8c0-124.3,99.1-225.1,221.3-225.1c122.2,0,221.3,100.8,221.3,225.1c0,114-83.4,208-191.5,222.8C519.9,516.7,510.1,515.9,500,515.9z"/>
                </g>
            </svg>
            <p class="title_text">Профиль пользователя</p>
        </div>
        <div class="userInfo_block">
            <div class="row">
                <div class="col-xl-4 col-4 container_img">
                    <img class="img-fluid" src="{{ asset($user->avatar) }}" alt="avatar">
                    <div class="icon_img">
                        @if(Auth::id() == $user->id)
                            <a href="#" title="Мои сообщения">
                                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="comment-dots"
                                     class="svg-inline--fa fa-comment-dots fa-w-16" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"></path>
                                </svg>
                            </a>
                            <a href="{{route('user.friends_list')}}" title="Мои друзья">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-friends"
                                     class="svg-inline--fa fa-user-friends fa-w-20" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path fill="currentColor"
                                          d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-xl-8 col-8 container_information">
                    <div class="userText_block">
                        <span class="title night_text">{{ $user->name }}</span>
                    @if($user->isOnline())
                        <!-- if online displays this -->
                            <span class="date">
                                online
                            </span>
                    @else
                        <!-- if INACTIVE displays this -->
                            <div class="date">
                                {{\Carbon\Carbon::parse($user->activity_at)->diffForHumans()}}
                            </div>
                        @endif
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Статус:</span></div>
                        <div class="right_block night_text">
                            <span>{{$user->getUserStatus($user->points)}} {{ $user->points }} pts</span></div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>ДР:</span></div>
                        <div class="right_block night_text">
                            @if($user->birthday)
                                <span>{{$user->birthday}}</span>
                            @else
                                <span>Не указано</span>
                            @endif

                        </div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Страна:</span></div>
                        <div class="right_block night_text">
                            @if($user->countries->name)
                                <span>{{$user->countries->name}}</span>
                            @else
                                <span>Не указано</span>
                            @endif
                        </div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Раса:</span></div>
                        <div class="right_block night_text">
                            @if($user->races->title)
                                <span>{{ $user->races->title }}</span>
                            @else
                                <span>Не указано</span>
                            @endif
                        </div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Репутация:</span></div>
                        <div class="right_block night_text"><a
                                href="{{route('user-rating-list.index',['id'=>$user->id])}}"
                                title="Репутация"><span class="blue">{{$user->positive_count - $user->negative_count}} кг</span></a>
                        </div>
                    </div>
                </div>
                @if(Auth::id() != $user->id)
                    <a href="{{route('user.add_friend',['id'=>$user->id])}}" class="button button__download-more">ДОБАВИТЬ</a>
                    <a href="#" class="button button__download-more">НАПИСАТЬ</a>
                @endif
            </div>
        </div>

        <div class="block_userInformation">
            <div class="row">
                <div class="col-xl-6 col-lg-6  col-md-6 col-12 container_left">
                    <div class="title_top_userProfile change_gray">
                        <p class="title_Text">Список друзей</p>
                    </div>
                    @if(isset($friends) && count($friends) > 0)
                        <div class="friends_block">
                            @foreach($friends as $friend)
                                @if(!empty($friend))
                                    <div class="friends">
                                        <div class="left_block">
                                            <a href="{{route('user_profile',['id' => $friend->id])}}">
                                                <img src="http://reps.loc/images/newsAvatar.png" alt="avatar"
                                                     class="author__avatar img-fluid">
                                                <span class="name_player">{{$friend->name}}</span>
                                            </a>
                                        </div>
                                        <div class="right_block">
                                            <img src="{{asset($friend->countries->flag)}}"
                                                 class="info__flag" alt="flag">
                                            <img
                                                src="{{asset('images/default.game-races/'.$friend->races->title.'.png')}}"
                                                class="info__cube"
                                                alt="race">
                                        </div>
                                    </div>
                                    {{--<a href="{{route('user_profile',['id' => $friend->id])}}">
                                        @if($friend->country_id)
                                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$friend->country_id]->code)}}"></span>
                                        @else
                                            <span>NO</span>
                                        @endif
                                        <span>{{$friend->name}}</span>
                                    </a>--}}

                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>Список пуст</p>
                    @endif


                    <div class="title_top_userProfile change_gray">
                        <p class="title_Text">В друзьях</p>
                    </div>

                    @if(isset($friendly) && count($friendly) > 0)
                        <div class="friends_block">
                            @foreach($friendly as $friend)
                                @if(!empty($friend))
                                    <div class="friends">
                                        <div class="left_block">
                                            <a href="{{route('user_profile',['id' => $friend->id])}}">
                                                <img src="http://reps.loc/images/newsAvatar.png" alt="avatar"
                                                     class="author__avatar img-fluid">
                                                <span class="name_player">{{$friend->name}}</span>
                                            </a>
                                        </div>
                                        <div class="right_block">
                                            @isset($friend->countries)
                                                <img src="{{ asset($friend->countries->flag) }}" class="info__flag"
                                                     title="{{$friend->countries->name}}" alt="flag">
                                            @endisset
                                            @isset($friend->races)
                                                <img
                                                    src="{{asset('images/default/game-races/'.$friend->races->title.'.png') }}"
                                                    class="info__cube"
                                                    title="{{$friend->races->title}}" alt="race">
                                            @endisset
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>Список пуст</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6  col-md-6 col-12  container_right">
                    <div class="title_top_userProfile change_gray">
                        <p class="title_Text">Информация</p>
                    </div>
                    <div class="wrapper_information">
                        <div class="block_inform">
                            <div class="left_block"><span>Темы:</span></div>
                            <div class="right_block"><a href="{{route('user-topics.index',['id' => $user->id])}}"><span
                                        class="blue" title="Темы">{{$user->topics_count}}</span></a></div>
                        </div>
                        <div class="block_inform">
                            <div class="left_block"><span>Посты:</span></div>
                            <div class="right_block"><a
                                    href="{{route('user-comments.index',['id' => $user->id])}}"><span
                                        class="blue" title="Посты">{{$user->comments_count}}</span></a>
                            </div>
                        </div>
                        <div class="block_inform">
                            <div class="left_block"><span>Профессиональные реплеи:</span></div>
                            <div class="right_block"><a
                                    href="{{route('user-replay.index',['id' => $user->id, 'type' => 'user'])}}"><span
                                        class="blue" title="Профессиональные реплеи">{{$user->gosu_replay_count}}</span></a>
                            </div>
                        </div>
                        <div class="block_inform">
                            <div class="left_block"><span>Пользовательские реплеи:</span></div>
                            <div class="right_block"><a
                                    href="{{route('user-replay.index',['id' => $user->id, 'type' => 'pro'])}}"><span
                                        class="blue" title="Пользовательские реплеи">{{$user->user_replay_count}}</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="title_top_userProfile change_gray">
                        <p class="title_Text">Контакты</p>
                    </div>
                    <div class="wrapper_contacts">
                        <div class="block_contact">
                            <div class="left_block"><span>E-mail:</span></div>
                            <div class="right_block">
                                @if(Auth::id() == $user->id)
                                    <span class="night_text">{{$user->email ?? 'не указано'}}</span>
                                @else
                                    <span class="night_text">{{'Скрыт' ?? 'не указано'}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="block_contact">
                            <div class="left_block"><span>Сайт:</span></div>

                            <div class="right_block">
                                @if(!$user->checkUserLink($user->homepage))
                                    <span>{{$user->homepage ?? 'не указано'}}</span>
                                @else
                                    <a href="{{$user->checkUserLink($user->homepage)}}"><span
                                            class="small">{{$user->homepage}}</span></a>
                                @endif
                            </div>
                        </div>
                        <div class="block_contact">
                            <div class="left_block"><span>Discord:</span></div>
                            <div class="right_block"><span class="night_text">{{$user->isq ?? 'не указано'}}</span>
                            </div>
                        </div>
                        <div class="block_contact">
                            <div class="left_block"><span>Skype:</span></div>
                            <div class="right_block"><span class="night_text">{{$user->skype ?? 'не указано'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>