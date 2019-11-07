<div class="footer night_footer">
    <div class="container">
        <div class="row">
            <div class="footer__logo col-xl-3 col-lg-3 col-md-6 col-sm-6 order-1">
                <img src="{{ url('/images/logo.png') }}" class="logo__img img-fluid" alt="logo">
                <p class="logo__text">Everything about StarCraft®: Remastered</p>
            </div>
            <div class="footer__link col-xl-2 offset-xl-1 col-lg-2 mt-lg-0 offset-lg-1 col-md-6 col-sm-6 col-6 order-2 mt-4">
                <a class="link-list__item" href="{{route('home.index')}}" title="Главная">Главная</a>
                <a class="link-list__item" href="{{route('forum.index')}}" title="Форум">Форум</a>
                <a class="link-list__item" href="{{route('replay.index',['type' => 'user'])}}" title="Пользовательские реплеи">Пользовательские
                    реплеи</a>
                <a class="link-list__item" href="{{route('replay.index',['type' => 'pro'])}}" title="Профессиональные реплеи">Профессиональные
                    реплеи</a>
                <a class="link-list__item" href="{{route('news.index')}}" title="Новости">Новости</a>
            </div>
            <div class="footer__info col-xl-2 col-lg-2  mt-lg-0 col-md-6 col-sm-12 col-12 order-5 mt-4 ">
                <div class="footer__text">
                    {!! $footer !!}
                </div>
            </div>
            <div class="footer__our-birthday col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-sm-12 col-12 col-12 order-4 mt-4">
                <h2 class="info__title footer__title">Наши именинники:</h2>
                <div class="row">
                    <div class="col-4">
                        @foreach($footerUser as $item)
                            <p class="our-birthday__nickname">{{$item->name}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="footer__useful col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-6 order-3 col-sm-6 col-6 mt-4">
                <h2 class="info__title footer__title">Полезное:</h2>
                @foreach($footerUrl as $item)
                    <a href="{{$item->url}}" class="useful__link" title="{{$item->title}}">{{$item->title}}</a>
                @endforeach
            </div>

        </div>
    </div>
</div>

<div class="footer__copyright">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="copyright__text">2002-2019 Replay Cafe | 2018-2019 Reps2 | 1998-2019 StarCraft: Brood War by
                    Blizzard Entertainment</p>
            </div>
        </div>
    </div>
</div>
