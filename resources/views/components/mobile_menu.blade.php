<section class="mob_menu">
    <nav class=" nav-wrapper" id="nav-mobile">
        <div class="main_punkt">
            <div class="btn-round">
                <span class="close"></span>
            </div>
            <ul class="punct">
                <li><a class="nav_item" href="/">ГЛАВНАЯ</a></li>
                <li><a class="nav_item" href="/forum">ФОРУМ</a></li>
                <li><a class="nav_item" href="/replay">РЕПЛЕИ</a></li>
                <li><a class="nav_item" href="/news">НОВОСТИ</a></li>
                <li><a class="nav_item" href="/tournament">ТУРНИРЫ</a></li>
                <li><a class="nav_item" href="/best">ЛУЧШИЕ</a></li>
                <li><a class="nav_item" href="#">ФАЙЛЫ</a></li>
            </ul>
        </div>

        <div class="bottom_menu">
            @guest
                <button type="button" data-toggle="modal"
                        data-target="#authorizationModal"><p>{{ __('Login') }}</p></button>
                <button class="registration" type="button" data-toggle="modal"
                        data-target="#registrationModal"><p>{{ __('Register') }}</p></button>
            @else
                @include('layouts.components.header.components.user-bar-panel')
            @endguest
            {{--            <button>--}}
            {{--                <p>registration</p>--}}
            {{--            </button>--}}
            {{--            <button>--}}
            {{--                <p>login</p>--}}
            {{--            </button>--}}
        </div>
    </nav>
</section>


{{--        <label for="nav" class="nav-btn">--}}
{{--            <span>X</span>--}}

