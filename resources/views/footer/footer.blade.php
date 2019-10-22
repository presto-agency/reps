<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer__logo col-xl-3 col-lg-3 col-md-6 col-sm-12 order-1">
                <img src="{{ url('/images/logo.png') }}" class="logo__img img-fluid" alt="logo">
                <p class="logo__text">Everything about StarCraft®: Remastered</p>
            </div>
            <div
                class="footer__link col-xl-2 offset-xl-1 col-lg-2 mt-lg-0 offset-lg-1 col-md-12 col-sm-12 col-6 order-2 mt-4">
                <a class="link-list__item" href="/">Главная</a>
                <a class="link-list__item" href="/forum">Форум</a>
                <a class="link-list__item" href="/replay">Госу реплеи</a>
                <a class="link-list__item" href="/replay">Реплеи</a>
                <a class="link-list__item" href="/news">Новости</a>
            </div>
            <div class="footer__info col-xl-2 col-lg-2  mt-lg-0 col-md-6 col-sm-12  order-5 mt-4 ">
                <div class="footer__text">
                    {!! $footerData['footer'] !!}
                </div>
            </div>
            <div class="footer__our-birthday col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-sm-12 col-12 col-6 order-4 mt-4">
                <h2 class="info__title footer__title">Наши именинники:</h2>
                <div class="row">
                    @foreach($footerData['footerUsers'] as $item)
                        <div class="col-4">
                            <p class="our-birthday__nickname">{{$item->name}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="footer__useful col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-6 order-3 col-sm-12 mt-4">
                <h2 class="info__title footer__title">Полезное:</h2>
                @foreach($footerData['footerUrl'] as $item)
                    <a href="{{$item->url}}" class="useful__link" title="{{$item->title}}">{{$item->title}}</a>
                @endforeach
            </div>
            <div class="produced order-last col-12">
                <p>produced by:</p>
                <a class="devloop__link" href="https://devloop.pro">DevLoop
                    <svg fill="#DDDDDD" class="small-logo" width="40px" height="20px" viewBox="0 0 1023 837"
                         version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <polygon class="st0" points="126,293.8 711.2,483.5 317.2,633.1 "></polygon>
                        <polygon class="st1" points="667.7,609.8 711.2,483.5 317.2,633.1 "></polygon>
                        <polygon class="st2" points="776,560.7 711.2,483.5 667.7,609.8 "></polygon>
                        <polygon class="st3" points="888.2,226.9 711.2,483.5 776,560.7 "></polygon>
                        <polygon class="st4" points="553.8,84.1 731,454.8 711.2,483.5 553.8,432.5 "></polygon>
                        <polygon class="st5" points="549.9,84.9 411.5,386.3 549.9,431.2 "></polygon>
                        <polygon class="st6" points="888.2,226.9 664.2,315.3 731,454.8 "></polygon>
                        <polygon class="st7" points="549.9,84.9 553.8,84.1 553.8,432.5 549.9,431.2 "></polygon>
                    </svg>
                </a>
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

