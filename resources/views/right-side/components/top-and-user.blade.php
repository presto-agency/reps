{{--@isset($banners)--}}
{{--    <section class="banner">--}}
{{--        <div class="wrapper">--}}
{{--            @foreach($banners as $baner)--}}
{{--                <div class="block_content">--}}
{{--                    <a href="#">--}}
{{--                        <img src="{{url('images\logo.png')}}"/>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </section>--}}
{{--@endisset--}}
<section class="block_top">
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
            <p class="title_text">Новые пользователи</p>
        </div>
        <div class="block_topUsers">
            @isset($newUsers)
                @foreach($newUsers as $item)
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_code">
                            <p class="night_text">#{{$item['id']}}</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_img">
                            <img class="icon_bars" src="{{asset($item['countryFlag25x20'])}}" alt="flag"
                                 title="{{$item['countryName']}}"/>
                            <img class="icon_bars" src="{{asset($item['raceIcon'])}}" alt="race"
                                 title="{{$item['raceTitle']}}"/>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-3 content_login">
                            <a href="#">
                                <p title="{{$item['name']}}">{{$item['name']}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="title_block_gray change_gray">
            <a href="{{route('best.index')}}"><p class="title_text night_text">Top 10 кг</a>
        </div>
        <div class="block_topUsers">
            @isset($top10Rating)
                @foreach($top10Rating as $item)
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_code">
                            <p class="night_text">{{$item['max']}} кг</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_img">
                            <img class="icon_bars" src="{{asset($item['countryFlag25x20'])}}" alt="flag"
                                 title="{{$item['countryName']}}"/>
                            <img class="icon_bars" src="{{asset($item['raceIcon'])}}" alt="race"
                                 title="{{$item['raceTitle']}}"/>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-3 content_login">
                            <a href="#">
                                <p title="{{$item['name']}}">{{$item['name']}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="title_block_gray change_gray">
            <a href="{{route('best.index')}}"><p class="title_text night_text">TOP 10 pts</p></a>
        </div>
        <div class="block_topUsers">
            @isset($top10Points)
                @foreach($top10Points as $item)
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_code">
                            <p class="night_text">{{$item['max']}} pts</p>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-3 content_img">
                            <img class="icon_bars" src="{{asset($item['countryFlag25x20'])}}" alt="flag"
                                 title="{{$item['countryName']}}"/>
                            <img class="icon_bars" src="{{asset($item['raceIcon'])}}" alt="race"
                                 title="{{$item['raceTitle']}}"/>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-3 content_login">
                            <a href="#">
                                <p title="{{$item['name']}}">{{$item['name']}}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</section>
