<section class="user_bar">
    <div class="user_panel">
        <a href="{{route('user_profile',['id'=> Auth::id()])}}" class="user-avatar">
            @if(auth()->check() && auth()->user()->userViewAvatars() )
                <img src="{{asset(auth()->user()->avatarOrDefault())}}" alt="avatar">
            @endif
            @guest()
                <img src="{{asset(auth()->user()->avatarOrDefault())}}" alt="avatar">
            @endguest
        </a>
        <a href="{{route('user_profile',['id'=> Auth::id()])}}" class="user-nickname"
           title="{{Auth::user()->name}}">{{Auth::user()->name}}</a>
    </div>
    <div class="panel">
        <div class="block_svg">
            <a href="{{route('user.friends_list')}}" title="Мои друзья">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-friends"
                     class="svg-inline--fa fa-user-friends fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 640 512">
                    <path
                            d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z"></path>
                </svg>
            </a>
            <a href="{{ route('user.messages_all') }}" title="Мои сообщения">
                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="comments"
                     class="svg-inline--fa fa-comments fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 576 512">
                    <path d="M532 386.2c27.5-27.1 44-61.1 44-98.2 0-80-76.5-146.1-176.2-157.9C368.3 72.5 294.3 32 208 32 93.1 32 0 103.6 0 192c0 37 16.5 71 44 98.2-15.3 30.7-37.3 54.5-37.7 54.9-6.3 6.7-8.1 16.5-4.4 25 3.6 8.5 12 14 21.2 14 53.5 0 96.7-20.2 125.2-38.8 9.2 2.1 18.7 3.7 28.4 4.9C208.1 407.6 281.8 448 368 448c20.8 0 40.8-2.4 59.8-6.8C456.3 459.7 499.4 480 553 480c9.2 0 17.5-5.5 21.2-14 3.6-8.5 1.9-18.3-4.4-25-.4-.3-22.5-24.1-37.8-54.8zm-392.8-92.3L122.1 305c-14.1 9.1-28.5 16.3-43.1 21.4 2.7-4.7 5.4-9.7 8-14.8l15.5-31.1L77.7 256C64.2 242.6 48 220.7 48 192c0-60.7 73.3-112 160-112s160 51.3 160 112-73.3 112-160 112c-16.5 0-33-1.9-49-5.6l-19.8-4.5zM498.3 352l-24.7 24.4 15.5 31.1c2.6 5.1 5.3 10.1 8 14.8-14.6-5.1-29-12.3-43.1-21.4l-17.1-11.1-19.9 4.6c-16 3.7-32.5 5.6-49 5.6-54 0-102.2-20.1-131.3-49.7C338 339.5 416 272.9 416 192c0-3.4-.4-6.7-.7-10C479.7 196.5 528 238.8 528 288c0 28.7-16.2 50.6-29.7 64z"></path>
                </svg>
            </a>
            <a href="{{ route('home.index') }}" id='settings' title="Настройки">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog"
                     class="svg-inline--fa fa-cog fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path
                            d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path>
                </svg>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-home-front-1').submit();"
               title="Выход">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                <path
                        d="M990,499.3c0-11.9-4.1-22.8-11-31.5c-2.1-3.4-4.6-6.7-7.5-9.6L810.9,297.7c-19.8-19.8-51.9-19.8-71.7,0c-19.8,19.8-19.8,51.9,0,71.7l79.3,79.3l-387.4,0c-28,0-50.7,22.7-50.7,50.7c0,28,22.7,50.7,50.7,50.7l387.2,0l-76.5,76.5c-19.8,19.8-19.8,51.9,0,71.7c9.9,9.9,22.9,14.8,35.8,14.8c13,0,25.9-4.9,35.8-14.8l160.6-160.6c5-5,8.8-10.9,11.3-17.1C988.3,514,990,506.9,990,499.3z"/>
                    <path
                            d="M647.9,755.4c-28,0-50.7,22.7-50.7,50.7v81.7H111.4V112.2h485.8v97.6c0,28,22.7,50.7,50.7,50.7c28,0,50.7-22.7,50.7-50.7V91.3c0-44.4-36.1-80.5-80.5-80.5H90.5C46.1,10.8,10,46.9,10,91.3v817.3c0,44.4,36.1,80.5,80.5,80.5H618c44.4,0,80.5-36.1,80.5-80.5V806.1C698.6,778.1,675.9,755.4,647.9,755.4z"/>
                </svg>
            </a>
            <form id="logout-form-home-front-1" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <div id="settings_div" class="logged_links">
        <ul class="logged_active">
            <li>
                <a href="{{route('user_profile',['id' => auth()->id()])}}"
                   title="Мой аккаунт">{{__('Мой аккаунт')}}</a>
            </li>
            <li>
                <a href="{{route('user-gallery.index',['id' => auth()->id()]) }}"
                   title="Галерея">{{__('Галерея')}}</a>
            </li>
            <li>
                <a href="{{route('user-rating-list.index',['id' => auth()->id()]) }}"
                   title="Моя репутация">{{__('Моя репутация')}}</a>
            </li>
            <li>
                <a href="{{route('user-replay.create',['id' => auth()->id()])}}"
                   title="Отправить реплей">{{__('Отправить реплей')}}</a>
            </li>
            <li>
                <a href="{{route('edit_profile',['id' => auth()->id()])}}"
                   title="Настройки">{{__('Настройки')}}</a>
            </li>
        </ul>
    </div>

</section>
