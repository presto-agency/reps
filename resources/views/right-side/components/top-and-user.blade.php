<section class="block_top">
    <div class="wrapper border_shadow">
        <div class="title_block">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px"
                 y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon</metadata>
                <g>
                    <path fill="white"
                          d="M643.4,540.1c84.4-49.4,141.2-140.7,141.2-245.5C784.6,137.4,657.2,10,500,10c-157.2,0-284.6,127.4-284.6,284.6c0,104.8,56.8,196.2,141.2,245.5c-174,59.6-299.3,224.2-299.3,418.4c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5h0.2C120.5,748.9,290.4,579,500,579c209.6,0,379.5,169.9,379.5,379.5h0.2c0,17.4,14.1,31.5,31.5,31.5c17.4,0,31.5-14.1,31.5-31.5C942.6,764.3,817.4,599.7,643.4,540.1z M500,515.9c-10.1,0-19.9,0.9-29.8,1.5c-108.1-14.9-191.5-108.8-191.5-222.8c0-124.3,99.1-225.1,221.3-225.1c122.2,0,221.3,100.8,221.3,225.1c0,114-83.4,208-191.5,222.8C519.9,516.7,510.1,515.9,500,515.9z"/>
                </g>
            </svg>
            <p class="title_text">{{__('Новые пользователи')}}</p>
        </div>
        <div class="block_topUsers">
            @if(isset($newUsers) && $newUsers->isNotEmpty() )
                @foreach($newUsers as $item)
                    <div class="row row_container">
                        <div class="col-xl-5 col-lg-4 col-md-4 col-4 content_code">
                            <p class="night_text">{{'#'.$item->id}}</p>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-3 content_img">
                            @if($item->countries)
                                <img class="icon_bars" title="{{$item->countries->name}}" alt="flag"
                                     src="{{asset($item->countries->flagOrDefault())}}"/>
                            @endif
                            @if($item->races)
                                <img class="icon_bars" title="{{$item->races->title}}" alt="race"
                                     src="{{asset("images/default/game-races/" . $item->races->title . ".png")}}"/>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-4 content_login">
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                <p title="{{$item->name}}">{{$item->name}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_block_gray change_gray">
            <a href="{{route('best.index')}}">
                <p class="title_text night_text">{{__('Top 10 supply')}}</p>
            </a>
        </div>
        <div class="block_topUsers">
            @if(isset($top10Rating) && $top10Rating->isNotEmpty())
                @foreach($top10Rating as $item)
                    <div class="row row_container">
                        <div class="col-xl-5 col-lg-4 col-md-4 col-4 content_code">
                            <p class="night_text">{{$item->rating.' s'}} </p>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-3 content_img">
                            @if($item->countries)
                                <img class="icon_bars" src="{{asset($item->countries->flagOrDefault())}}" alt="flag"
                                     title="{{$item->countries->name}}"/>
                            @endif
                            @if($item->races)
                                <img class="icon_bars"
                                     src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}" alt="race"
                                     title="{{$item->races->title}}"/>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-4 content_login">
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                <p title="{{$item->name}}">{{$item->name}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_block_gray change_gray">
            <a href="{{route('best.index')}}"><p class="title_text night_text">{{__('TOP 10 minerals')}}</p></a>
        </div>
        <div class="block_topUsers">
            @if(isset($top10Points) && $top10Points->isNotEmpty())
                @foreach($top10Points as $item)
                    <div class="row row_container">
                        <div class="col-xl-5 col-lg-4 col-md-4 col-4 content_code">
                            <p class="night_text">{{$item->comments_count .' m'}}</p>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-3 content_img">
                            @if($item->countries)
                                <img class="icon_bars" src="{{asset($item->countries->flagOrDefault())}}" alt="flag"
                                     title="{{$item->countries->name}}"/>
                            @endif
                            @if($item->races)
                                <img class="icon_bars"
                                     src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}" alt="race"
                                     title="{{$item->races->title}}"/>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-4 content_login">
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                <p title="{{$item->name}}">{{$item->name}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="title_block_gray change_gray">
            <a href="{{route('best.index')}}"><p class="title_text night_text">{{__('TOP 10 gas')}}</p></a>
        </div>
        <div class="block_topUsers">
            @if(isset($top10Gas) && $top10Gas->isNotEmpty())
                @foreach($top10Gas as $item)
                    <div class="row row_container">
                        <div class="col-xl-5 col-lg-4 col-md-4 col-4 content_code">
                            <p class="night_text">{{$item->gas_balance .' g'}}</p>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-3 content_img">
                            @if($item->countries)
                                <img class="icon_bars" src="{{asset($item->countries->flagOrDefault())}}" alt="flag"
                                     title="{{$item->countries->name}}"/>
                            @endif
                            @if($item->races)
                                <img class="icon_bars"
                                     src="{{asset('images/default/game-races/'.$item->races->title.'.png')}}" alt="race"
                                     title="{{$item->races->title}}"/>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-4 content_login">
                            <a href="{{route('user_profile',['id'=>$item->id])}}">
                                <p title="{{$item->name}}">{{$item->name}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
