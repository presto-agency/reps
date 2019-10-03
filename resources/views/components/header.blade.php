<section class="header">
    <div class="container header_container">
        <div class="row header_row">
            <div class="col-3 cabinet"><img class="icon_cabinet" src="{{url('images\svg\user-solid.svg')}}"/></div>
            <div class=" col-xl-3 col-lg-2 col-md-3 col-sm-3 col-6 logo"><img src="{{ url('/images/logo.png') }}" alt="logo"></div>
            <div class="col-xl-6  col-lg-6 col-md-2 col-sm-2 col-3 main_menu">
                <nav class="menu_navigation">
                    <a href="#">ГЛАВНАЯ</a>
                    <a href="#">ФОРУМ</a>
                    <a href="#">РУПЛЕИ</a>
                    <a href="#">НОВОСТИ</a>
                    <a href="#">ЛУЧШИЕ</a>
                    <a href="#">ФАЙЛЫ</a>
                </nav>
                <img class="icon_bars" src="{{url('images\svg\bars.svg')}}"/>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-7 col-sm-7 col-12 search">
                <div class="button_input">
                    <button><img class="search_img" src="{{ url('/images/search.png') }}"></button>
                    <input id="inp"class="search_input " placeholder="поиск">
                </div>

                <div class="autorization">
                    <button>Вход</button>
                    <a class="registration" href="#">Регистрация</a>
                </div>
            </div>
        </div>
    </div>
</section>
