<div class="footer night_footer">
    <div class="container">
        <div class="row">
            <div class="footer__logo col-xl-3 col-lg-3 col-md-6 col-sm-6 order-1">
                <img src="{{ asset('/images/logo.png') }}" class="logo__img img-fluid" alt="logo">
                <p class="logo__text">{{__('Everything about StarCraft®: Remastered')}}</p>
            </div>
            <div
                class="footer__link col-xl-2 offset-xl-1 col-lg-2 mt-lg-0 offset-lg-1 col-md-6 col-sm-6 col-6 order-2 mt-4">
                <a class="link-list__item" href="{{route('home.index')}}" title="Главная">{{__('Главная')}}</a>
                <a class="link-list__item" href="{{route('forum.index')}}" title="Форум">{{__('Форум')}}</a>
                <a class="link-list__item" href="{{route('replay.index',['type' => 'user'])}}"
                   title="Реплеи">{{__('Реплеи')}}</a>
                <a class="link-list__item" href="{{route('news.index')}}" title="Новости">{{__('Новости')}}</a>
            </div>
            <div class="footer__info col-xl-2 col-lg-2  mt-lg-0 col-md-6 col-sm-12 col-12 order-5 mt-4 ">
                <div class="footer__text">
                    @if(!empty($footer))
                        {!! $footer !!}
                    @endif
                </div>
            </div>
            <div class="footer__our-birthday col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-sm-12 col-12 col-12 order-4 mt-4">
                <h2 class="info__title footer__title">{{__('Наши именинники:')}}</h2>
                <div class="row">
                    <div class="col-4">
                        @if(isset($footerUser) && $footerUser->isNotEmpty())
                            @foreach($footerUser as $item)
                                <a class="our-birthday__nickname" target="_blank"
                                   href="{{route('user_profile',['id'=>$item->id])}}">{{$item->name}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer__useful col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-6 order-3 col-sm-6 col-6 mt-4">
                <h2 class="info__title footer__title">{{__('Полезное:')}}</h2>
                @if(isset($footerUrl) && $footerUrl->isNotEmpty())
                    @foreach($footerUrl as $item)
                        <a href="{{$item->url}}" target="_blank" class="useful__link"
                           title="{{$item->title}}">{{$item->title}}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<div class="footer__copyright">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="copyright__text">2002-{{date("Y")}} Replay Cafe | 2018-{{date("Y")}} Reps2 | 1998-{{date("Y")}} StarCraft: Brood War by Blizzard Entertainment</p>
            </div>
        </div>
    </div>
</div>

