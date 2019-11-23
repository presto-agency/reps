<section class="user_reputation user_profile">
    <div class="wrapper border_shadow">
        <div class="title_block tb_reputation">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon</metadata>
                <g>
                    <path fill="white"
                          d="M643.4,540.1c84.4-49.4,141.2-140.7,141.2-245.5C784.6,137.4,657.2,10,500,10c-157.2,0-284.6,127.4-284.6,284.6c0,104.8,56.8,196.2,141.2,245.5c-174,59.6-299.3,224.2-299.3,418.4c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5h0.2C120.5,748.9,290.4,579,500,579c209.6,0,379.5,169.9,379.5,379.5h0.2c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5C942.6,764.3,817.4,599.7,643.4,540.1z M500,515.9c-10.1,0-19.9,0.9-29.8,1.5c-108.1-14.9-191.5-108.8-191.5-222.8c0-124.3,99.1-225.1,221.3-225.1c122.2,0,221.3,100.8,221.3,225.1c0,114-83.4,208-191.5,222.8C519.9,516.7,510.1,515.9,500,515.9z"/>
                </g>
            </svg>
            <p class="title_text" title="{{$user->name}}">Информация о пользователе {{$user->name}}</p>
        </div>
        <div class="userInfo_block">
            <div class="row">
                <div class="col-xl-4 col-4 container_img">
                    @if(auth()->check() && auth()->user()->userViewAvatars())
                        <img src="{{asset($user->avatarOrDefault())}}" alt="avatar">
                    @endif
                    @guest()
                        <img src="{{asset($user->avatarOrDefault())}}" alt="avatar">
                    @endguest()
                </div>
                <div class="col-xl-8 col-8 container_information">
                    <div class="userText_block">
                        <span class="title night_text">{{$user->name}}</span>
                        @if($user->isOnline())
                            <span class="date">online</span>
                        @else
                            <div class="date">{{\Carbon\Carbon::parse($user->activity_at)->diffForHumans()}}</div>
                        @endif
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Имя:</span></div>
                        <div class="right_block"><span class="night_text">{{$user->name}}</span></div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Страна:</span></div>
                        <div class="right_block"><span class="night_text">{{$user->countries->name}}</span></div>
                    </div>
                    <div class="information_block">
                        <div class="left_block"><span>Репутация:</span></div>
                        <div class="right_block"><span class="blue">{{$user->rating}} кг</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
