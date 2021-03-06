<section class="user_friends">
    <div class="wrapper my-friends border_shadow">
        <div class="title_block">
            <p class="title_text">{{__('Список Ваших друзей')}}</p>
        </div>

        @if(isset($friends) && count($friends) > 0)
            <div class="row row_title">
                <div class="col-5  user_block">
                    <div class="col-3">
                        <span class="night_text">{{__('#')}}</span>
                    </div>
                    <div class="col-5">
                        <span class="night_text">{{__('Аватар')}}</span>
                    </div>
                    <div class="col-4">
                        <span class="night_text">{{__('Имя')}}</span>
                    </div>
                </div>
                <div class="col-3 offset-1"><span class="night_text">{{__('Дата')}}</span></div>
                <div class="col-3"><span class="night_text">{{__('Действие')}}</span></div>
            </div>
            <div class="wrapper_table">
                @foreach($friends as $item)
                    <div class="row row_users">
                        <div class="col-5  user_block">
                            <div class="col-3">
                                <span class="night_text">{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                            </div>
                            <div class="col-5">
                                @if(auth()->check() && auth()->user()->userViewAvatars())
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                @guest()
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endguest()
                            </div>
                            <div class="col-4">
                                <a href="{{route('user_profile',['id'=>$item->id])}}" title="name_user"><span
                                        class="name_user">{{ $item->name }}</span></a>
                            </div>
                        </div>

                        <div class="col-3 offset-1"><span
                                class="night_text">{{$item->friendly_data->format('H:i d.m.Y')}}</span></div>
                        <div class="col-3 block_action">
                            <a href="{{route('user.remove_friend',['id' => $item->id])}}">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                     viewBox="0 0 729.837 729.838" style="enable-background:new 0 0 729.837 729.838;"
                                     xml:space="preserve">
                                <path d="M589.193,222.04c0-6.296,5.106-11.404,11.402-11.404S612,215.767,612,222.04v437.476c0,19.314-7.936,36.896-20.67,49.653
                            c-12.733,12.734-30.339,20.669-49.653,20.669H188.162c-19.315,0-36.943-7.935-49.654-20.669
                            c-12.734-12.734-20.669-30.313-20.669-49.653V222.04c0-6.296,5.108-11.404,11.403-11.404c6.296,0,11.404,5.131,11.404,11.404
                            v437.476c0,13.02,5.37,24.922,13.97,33.521c8.6,8.601,20.503,13.993,33.522,13.993h353.517c13.019,0,24.896-5.394,33.498-13.993
                            c8.624-8.624,13.992-20.503,13.992-33.498V222.04H589.193z"/>
                                    <path d="M279.866,630.056c0,6.296-5.108,11.403-11.404,11.403s-11.404-5.107-11.404-11.403v-405.07
                            c0-6.296,5.108-11.404,11.404-11.404s11.404,5.108,11.404,11.404V630.056z"/>
                                    <path d="M376.323,630.056c0,6.296-5.107,11.403-11.403,11.403s-11.404-5.107-11.404-11.403v-405.07
                            c0-6.296,5.108-11.404,11.404-11.404s11.403,5.108,11.403,11.404V630.056z"/>
                                    <path d="M472.803,630.056c0,6.296-5.106,11.403-11.402,11.403c-6.297,0-11.404-5.107-11.404-11.403v-405.07
                            c0-6.296,5.107-11.404,11.404-11.404c6.296,0,11.402,5.108,11.402,11.404V630.056L472.803,630.056z"/>
                                    <path d="M273.214,70.323c0,6.296-5.108,11.404-11.404,11.404c-6.295,0-11.403-5.108-11.403-11.404
                            c0-19.363,7.911-36.943,20.646-49.677C283.787,7.911,301.368,0,320.73,0h88.379c19.339,0,36.92,7.935,49.652,20.669
                            c12.734,12.734,20.67,30.362,20.67,49.654c0,6.296-5.107,11.404-11.403,11.404s-11.403-5.108-11.403-11.404
                            c0-13.019-5.369-24.922-13.97-33.522c-8.602-8.601-20.503-13.994-33.522-13.994h-88.378c-13.043,0-24.922,5.369-33.546,13.97
                            C278.583,45.401,273.214,57.28,273.214,70.323z"/>
                                    <path d="M99.782,103.108h530.273c11.189,0,21.405,4.585,28.818,11.998l0.047,0.048c7.413,7.412,11.998,17.628,11.998,28.818
                            v29.46c0,6.295-5.108,11.403-11.404,11.403h-0.309H70.323c-6.296,0-11.404-5.108-11.404-11.403v-0.285v-29.175
                            c0-11.166,4.585-21.406,11.998-28.818l0.048-0.048C78.377,107.694,88.616,103.108,99.782,103.108L99.782,103.108z
                             M630.056,125.916H99.782c-4.965,0-9.503,2.02-12.734,5.274L87,131.238c-3.255,3.23-5.274,7.745-5.274,12.734v18.056h566.361
                            v-18.056c0-4.965-2.02-9.503-5.273-12.734l-0.049-0.048C639.536,127.936,635.021,125.916,630.056,125.916z"/>
                            </svg>
                            </a>
                            <a href="{{ route('user.messages', ['id' => $item->id]) }}">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="telegram-plane"
                                     class="svg-inline--fa fa-telegram-plane fa-w-14" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row row_title">
                <p>{{__('Список пуст')}}</p>
            </div>
        @endif
    </div>
</section>
<section class="user_friends">
    <div class="wrapper my-friends border_shadow">
        <div class=" title_block">
            <p class="title_text">{{__('Вас добавили в друзья')}}</p>
        </div>

        @if(isset($friendly) && count($friendly) > 0)
            <div class="row row_title">
                <div class="col-5  user_block">
                    <div class="col-3">
                        <span class="night_text">{{__('#')}}</span>
                    </div>
                    <div class="col-5">
                        <span class="night_text">{{__('Аватар')}}</span>
                    </div>
                    <div class="col-4">
                        <span class="night_text">{{__('Имя')}}</span>
                    </div>
                </div>
                <div class="col-3 offset-1"><span class="night_text">{{__('Дата')}}</span></div>
                <div class="col-3"><span class="night_text">{{__('Действие')}}</span></div>
            </div>
            <div class="wrapper_table">
                @foreach($friendly as $item)
                    <div class="row row_users">
                        <div class="col-5  user_block">
                            <div class="col-3">
                                <span class="night_text">{{ $loop->iteration }}</span>
                            </div>
                            <div class="col-5">
                                @if(auth()->check() && auth()->user()->userViewAvatars())
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endif
                                @guest()
                                    <img src="{{asset($item->avatarOrDefault())}}" alt="avatar"
                                         class="author__avatar img-fluid">
                                @endguest()
                            </div>
                            <div class="col-4">
                                <a href="{{route('user_profile',['id'=>$item->id])}}" title="name_user"><span
                                        class="name_user">{{ $item->name }}</span></a>
                            </div>
                        </div>
                        <div class="col-3 offset-1"><span
                                class="night_text">{{$item->friendly_data->format('H:i d.m.Y')}}</span></div>
                        <div class="col-3 block_action">
                            <a href="{{route('user.add_friend',['id' => $item->id])}}">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus"
                                     class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('user.messages', ['id' => $item->id]) }}">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="telegram-plane"
                                     class="svg-inline--fa fa-telegram-plane fa-w-14" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row row_title">
                <p>{{__('Список пуст')}}</p>
            </div>
        @endif
    </div>
</section>
