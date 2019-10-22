<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer__logo col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <img src="{{ url('/images/logo.png') }}" class="logo__img img-fluid" alt="logo">
                <p class="logo__text">Everything about StarCraft®: Remastered</p>
            </div>
            <div class="footer__link col-xl-2 offset-xl-1 col-lg-2 mt-lg-0 offset-lg-1 col-md-6 col-sm-12 mt-4">
                <a class="link-list__item" href="/">Главная</a>
                <a class="link-list__item" href="/forum">Форум</a>
                <a class="link-list__item" href="/replay">Госу реплеи</a>
                <a class="link-list__item" href="/replay">Реплеи</a>
                <a class="link-list__item" href="/news">Новости</a>
            </div>
            <div class="footer__info col-xl-2 col-lg-2  mt-lg-0 col-md-6 col-sm-12 mt-4">
                <div class="footer__text">
                    {!! $footerData['footer'] !!}
                </div>

                {{--                <p class="footer__text">Этот сайт предназначен для посетителей старше 21 года.</p>--}}
                {{--                <h2 class="info__title footer__title">По всем вопросам:</h2>--}}
                {{--                <a class="footer__mail" href="mailto:treasury@reps.ru">--}}
                {{--                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"--}}
                {{--                         viewBox="0 0 550.795 550.795" style="enable-background:new 0 0 550.795 550.795;"--}}
                {{--                         xml:space="preserve">--}}
                {{--		                    <path d="M501.613,491.782c12.381,0,23.109-4.088,32.229-12.16L377.793,323.567c-3.744,2.681-7.373,5.288-10.801,7.767--}}
                {{--                                c-11.678,8.604-21.156,15.318-28.434,20.129c-7.277,4.822-16.959,9.737-29.045,14.755c-12.094,5.024-23.361,7.528-33.813,7.528--}}
                {{--                                h-0.306h-0.306c-10.453,0-21.72-2.503-33.813-7.528c-12.093-5.018-21.775-9.933-29.045-14.755--}}
                {{--                                c-7.277-4.811-16.75-11.524-28.434-20.129c-3.256-2.387-6.867-5.006-10.771-7.809L16.946,479.622--}}
                {{--                                c9.119,8.072,19.854,12.16,32.234,12.16H501.613z"/>--}}
                {{--                            <path d="M31.047,225.299C19.37,217.514,9.015,208.598,0,198.555V435.98l137.541-137.541--}}
                {{--                                C110.025,279.229,74.572,254.877,31.047,225.299z"/>--}}
                {{--                            <path d="M520.059,225.299c-41.865,28.336-77.447,52.73-106.75,73.195l137.486,137.492V198.555--}}
                {{--                                C541.98,208.396,531.736,217.306,520.059,225.299z"/>--}}
                {{--                            <path d="M501.613,59.013H49.181c-15.784,0-27.919,5.33-36.42,15.979C4.253,85.646,0.006,98.97,0.006,114.949--}}
                {{--                                c0,12.907,5.636,26.892,16.903,41.959c11.267,15.061,23.256,26.891,35.961,35.496c6.965,4.921,27.969,19.523,63.012,43.801--}}
                {{--                                c18.917,13.109,35.368,24.535,49.505,34.395c12.05,8.396,22.442,15.667,31.022,21.701c0.985,0.691,2.534,1.799,4.59,3.269--}}
                {{--                                c2.215,1.591,5.018,3.61,8.476,6.107c6.659,4.816,12.191,8.709,16.597,11.683c4.4,2.975,9.731,6.298,15.985,9.988--}}
                {{--                                c6.249,3.685,12.143,6.456,17.675,8.299c5.533,1.842,10.655,2.766,15.367,2.766h0.306h0.306c4.711,0,9.834-0.924,15.368-2.766--}}
                {{--                                c5.531-1.843,11.42-4.608,17.674-8.299c6.248-3.69,11.572-7.02,15.986-9.988c4.406-2.974,9.938-6.866,16.598-11.683--}}
                {{--                                c3.451-2.497,6.254-4.517,8.469-6.102c2.057-1.476,3.605-2.577,4.596-3.274c6.684-4.651,17.1-11.892,31.104-21.616--}}
                {{--                                c25.482-17.705,63.01-43.764,112.742-78.281c14.957-10.447,27.453-23.054,37.496-37.803c10.025-14.749,15.051-30.22,15.051-46.408--}}
                {{--                                c0-13.525-4.873-25.098-14.598-34.737C526.461,63.829,514.932,59.013,501.613,59.013z"/>--}}
                {{--                    </svg>--}}
                {{--                    treasury@reps.ru</a>--}}
                {{--                <a class="footer__mail" href="mailto:Rus_Brain#6290">Rus_Brain#6290</a>--}}

            </div>
            <div class="footer__our-birthday col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-sm-12 col-12 mt-4">
                <h2 class="info__title footer__title">Наши именинники:</h2>
                <div class="row">
                    <div class="col-4">
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        @foreach($footerData['footerUsers'] as $item)
                            <p class="our-birthday__nickname">{{$item->name}}</p>
                        @endforeach
                    </div>
                    <div class="col-4">
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        @foreach($footerData['footerUsers'] as $item)
                            <p class="our-birthday__nickname">{{$item->name}}</p>
                        @endforeach
                    </div>
                    <div class="col-4">
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        <p class="our-birthday__nickname">bgfhjk</p>
                        @foreach($footerData['footerUsers'] as $item)
                            <p class="our-birthday__nickname">{{$item->name}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="footer__useful col-xl-2 col-lg-2 mt-lg-0 col-md-6 col-sm-12 mt-4">
                <h2 class="info__title footer__title">Полезное:</h2>
                <a href="#" class="useful__link" title="Файловый архив">Файловый архив</a>
                <a href="#" class="useful__link" title="Файловый архив">Файловый архив</a>
                <a href="#" class="useful__link" title="Файловый архив">Файловый архив</a>
                @foreach($footerData['footerUrl'] as $item)
                    <a href="{{$item->url}}" class="useful__link">{{$item->title}}</a>
                @endforeach
            </div>
            <div class="produced col-12">
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

