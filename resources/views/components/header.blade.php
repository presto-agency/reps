<section class="header">
    <div class="container header_container">
        <div class="row header_row">
            <div class="col-3 cabinet"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" class="svg-inline--fa fa-user fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="white" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg></div>
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
