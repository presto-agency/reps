<section class="mob_menu">
    <nav class=" nav-wrapper" id="nav-mobile">
        <div class="main_punkt">
            <div class="btn-round">
                <span class="close"></span>
            </div>
            <ul class="punct">
                <li><a class="nav_item" href="{{route('home.index')}}" title="{{__('ГЛАВНАЯ')}}">{{__('ГЛАВНАЯ')}}</a></li>
                <li><a class="nav_item" href="{{route('forum.index')}}" title="{{__('ФОРУМ')}}">{{__('ФОРУМ')}}</a></li>
                <li><a class="nav_item" href="{{route('replay.index',['type' => 'user'])}}" title="{{__('РЕПЛЕИ')}}">{{__('РЕПЛЕИ')}}</a></li>
                <li><a class="nav_item" href="{{route('news.index')}}" title="{{__('НОВОСТИ')}}">{{__('НОВОСТИ')}}</a></li>
                <li><a class="nav_item" href="{{route('tournament.index')}}" title="{{__('ТУРНИРЫ')}}">{{__('ТУРНИРЫ')}}</a></li>
                <li><a class="nav_item" href="{{route('best.index')}}" title="{{__('ЛУЧШИЕ')}}">{{__('ЛУЧШИЕ')}}</a></li>
                <li><a class="nav_item" href="https://drive.google.com/drive/folders/1bkbSoSRHOzEJZKki53uBKYbVMG3xvorc?usp=sharing" title="{{__('ФАЙЛЫ')}}">{{__('ФАЙЛЫ')}}</a></li>
            </ul>
        </div>

        <div class="bottom_menu">
            @guest
                <button type="button" data-toggle="modal"
                        data-target="#authorizationModal"><p>{{ __('Вход') }}</p></button>
                <button class="registration" type="button" data-toggle="modal"
                        data-target="#registrationModal"><p>{{ __('Регистрация') }}</p></button>
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

