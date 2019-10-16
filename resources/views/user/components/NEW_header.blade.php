<section class="header">
    <div class="container header_container">
        <div class="row header_row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6  logotype">
                <img src="{{ url('/images/logo.png') }}" alt="logo">
            </div>
            <div class="col-xl-1 col-lg-1 col-1  mode">
                <button >
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 45.16 45.16" style="enable-background:new 0 0 45.16 45.16;" xml:space="preserve">
                        <path fill="white" d="M22.58,11.269c-6.237,0-11.311,5.075-11.311,11.312s5.074,11.312,11.311,11.312c6.236,0,11.311-5.074,11.311-11.312
                        S28.816,11.269,22.58,11.269z"/>

                        <path fill="white" d="M22.58,7.944c-1.219,0-2.207-0.988-2.207-2.206V2.207C20.373,0.988,21.361,0,22.58,0c1.219,0,2.207,0.988,2.207,2.207
                            v3.531C24.787,6.956,23.798,7.944,22.58,7.944z"/>
                        <path fill="white" d="M22.58,37.215c-1.219,0-2.207,0.988-2.207,2.207v3.53c0,1.22,0.988,2.208,2.207,2.208c1.219,0,2.207-0.988,2.207-2.208
                            v-3.53C24.787,38.203,23.798,37.215,22.58,37.215z"/>

                        <path fill="white" d="M32.928,12.231c-0.861-0.862-0.861-2.259,0-3.121l2.497-2.497c0.861-0.861,2.259-0.861,3.121,0
                            c0.862,0.862,0.862,2.26,0,3.121l-2.497,2.497C35.188,13.093,33.791,13.093,32.928,12.231z"/>

                        <path fill="white" d="M12.231,32.93c-0.862-0.863-2.259-0.863-3.121,0l-2.497,2.496c-0.861,0.861-0.862,2.26,0,3.121
                            c0.862,0.861,2.26,0.861,3.121,0l2.497-2.498C13.093,35.188,13.093,33.79,12.231,32.93z"/>

                        <path fill="white" d="M37.215,22.58c0-1.219,0.988-2.207,2.207-2.207h3.531c1.219,0,2.207,0.988,2.207,2.207c0,1.219-0.988,2.206-2.207,2.206
                            h-3.531C38.203,24.786,37.215,23.799,37.215,22.58z"/>
                        <path fill="white" d="M7.944,22.58c0-1.219-0.988-2.207-2.207-2.207h-3.53C0.988,20.373,0,21.361,0,22.58c0,1.219,0.988,2.206,2.207,2.206
                            h3.531C6.956,24.786,7.944,23.799,7.944,22.58z"/>

                        <path fill="white" d="M32.928,32.93c0.862-0.861,2.26-0.861,3.121,0l2.497,2.497c0.862,0.86,0.862,2.259,0,3.12s-2.259,0.861-3.121,0
                            l-2.497-2.497C32.066,35.188,32.066,33.791,32.928,32.93z"/>
                        <path fill="white" d="M12.231,12.231c0.862-0.862,0.862-2.259,0-3.121L9.734,6.614c-0.862-0.862-2.259-0.862-3.121,0
                            c-0.862,0.861-0.862,2.259,0,3.12l2.497,2.497C9.972,13.094,11.369,13.094,12.231,12.231z"/>
                    </svg>
                </button>
                <button >
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="moon" class="svg-inline--fa fa-moon fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="white" d="M283.211 512c78.962 0 151.079-35.925 198.857-94.792 7.068-8.708-.639-21.43-11.562-19.35-124.203 23.654-238.262-71.576-238.262-196.954 0-72.222 38.662-138.635 101.498-174.394 9.686-5.512 7.25-20.197-3.756-22.23A258.156 258.156 0 0 0 283.211 0c-141.309 0-256 114.511-256 256 0 141.309 114.511 256 256 256z"></path></svg>
                </button>
            </div>
            <div class="col-xl-5 col-lg-4 col-md-2 col-sm-2 col-3 main_menu">
                <nav class="menu_navigation">
                    <a href="/">ГЛАВНАЯ</a>
                    <a href="/forum">ФОРУМ</a>
                    <a href="/replay">РЕПЛЕИ</a>
                    <a href="/news">НОВОСТИ</a>
                    <a href="/tournament">ТУРНИРЫ</a>
                    <a href="/best">ЛУЧШИЕ</a>
                    <a href="#">ФАЙЛЫ</a>
                </nav>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-7 col-sm-7 col-12 header_search">
                <div class="button_input">
                    <button><img class="search_img" src="{{ url('/images/search.png') }}"></button>
                    <input id="inp"class="search_input " placeholder="поиск">
                </div>
                <div class="autorization">
                    <button type="button" data-toggle="modal" data-target="#authorizationModal">Вход</button>
                    <button class="registration"  type="button" data-toggle="modal" data-target="#registrationModal">Регистрация</button>
                </div>
{{--                @include('user.components.user-bar_panel')--}}
            </div>
        </div>
    </div>

</section>
