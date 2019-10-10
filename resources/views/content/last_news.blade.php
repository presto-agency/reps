<div class="breaking-news">
    <div class="breaking-news__title">
        <svg class="title__icon" viewBox="-96 0 512 512" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="m160 512c-88.234375 0-160-71.765625-160-160v-229.332031c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v229.332031c0 70.59375 57.40625 128 128 128s128-57.40625 128-128v-234.667969c0-47.058593-38.273438-85.332031-85.332031-85.332031-47.0625 0-85.335938 38.273438-85.335938 85.332031v213.335938c0 23.53125 19.136719 42.664062 42.667969 42.664062s42.667969-19.132812 42.667969-42.664062v-208c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v208c0 41.171875-33.496094 74.664062-74.667969 74.664062s-74.667969-33.492187-74.667969-74.664062v-213.335938c0-64.679687 52.628907-117.332031 117.335938-117.332031 64.703125 0 117.332031 52.652344 117.332031 117.332031v234.667969c0 88.234375-71.765625 160-160 160zm0 0"/>
        </svg>
        <p class="title__text">Последние новости</p>
    </div>
    @if(!$news->isEmpty())
        @foreach($news as $single_news)
        <div class="breaking-news__news-card card">
            @if($single_news->preview_img)
                <img src="{{ asset($single_news->preview_img) }}" class="card-img-top" alt="news">
            @endif
            <div class="card-body">
                <div class="card-body__author">
                    @if($single_news->author->avatar)
                        <img src="{{ asset($single_news->author->avatar) }}" alt="avatar" class="author__avatar img-fluid">
                    @endif
                    @if($single_news->author->name)
                        <p class="author__nickname">{{ $single_news->author->name }}</p>
                    @endif
                    @if($single_news->author->created_at)
                        <span class="author__date">{{\Carbon\Carbon::parse($single_news->author->created_at)->format('d.m.Y')}}</span>
                    @endif
                </div>
                <h2 class="card-body__title">{{ $single_news->title }}</h2>
                <p class="card-body__text">{!! $single_news->preview_content !!}</p>
                <div class="card-body__items">
                    <a class="items__comment" href="#">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                            <path d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1
                                C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59
                                C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079
                                c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007
                                c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5
                                C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"/>
                            <path
                                    d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"/>
                            <path
                                    d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"/>
                            <path
                                    d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"/>
                        </svg>

                        <span>{{ $single_news->comments_count }}</span>
                    </a>
                    <a class="items__share" href="#">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;"
                             xml:space="preserve">

                            <path d="M352,256c-27.902,0-51.993,15.57-64.807,38.307l-139.844-53.785c1.214-5.333,1.984-10.827,1.984-16.522
                                c0-7.388-1.41-14.385-3.418-21.13l143.579-66.275c13.333,20.458,36.32,34.072,62.505,34.072c41.167,0,74.667-33.5,74.667-74.667
                                c0-41.167-33.5-74.667-74.667-74.667S277.333,54.833,277.333,96c0,7.388,1.41,14.385,3.418,21.13l-143.579,66.275
                                c-13.333-20.458-36.32-34.072-62.505-34.072C33.5,149.333,0,182.833,0,224c0,41.167,33.5,74.667,74.667,74.667
                                c27.902,0,51.994-15.57,64.807-38.307l139.844,53.785c-1.214,5.333-1.984,10.827-1.984,16.522c0,41.167,33.5,74.667,74.667,74.667
                                s74.667-33.5,74.667-74.667C426.667,289.5,393.167,256,352,256z M352,42.667c29.406,0,53.333,23.927,53.333,53.333
                                S381.406,149.333,352,149.333S298.667,125.406,298.667,96S322.594,42.667,352,42.667z M74.667,277.333
                                c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333S128,194.594,128,224S104.073,277.333,74.667,277.333z
                                 M352,384c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333s53.333,23.927,53.333,53.333S381.406,384,352,384z"/>
                        </svg>
                    </a>
                    <a class="items__watch" href="#">
                        <svg id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512"
                             viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                            <path
                                    d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                        </svg>
                        <span>{{$single_news->reviews ?? '0'}}</span>
                    </a>
                </div>

                <form class="card-body__comment-form">
                    <div class="comment-form__group form-group">
                        <label class="comment" for="comment">
                            <input type="text" class="comment__input form-control" id="comment"
                                   placeholder="Написать комментарий...">
                        </label>

                        <div class="buttons-upload">
                            <label class="custom-img-upload">
                                <input type="file" accept="image/*"/>
                                <i class="fas fa-camera"></i>
                            </label>

                            <label class="custom-file-upload">
                                <input type="file"/>
                                <i class="fas fa-paperclip"></i>
                            </label>

                            <button class="smile-upload">
                                <i class="far fa-smile"></i>
                            </button>
                        </div>

                    </div>
                    <button type="submit" class="comment-form__button">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 535.5 535.5"
                             style="enable-background:new 0 0 535.5 535.5;" xml:space="preserve">
                                <g id="send">
                                    <polygon points="0,497.25 535.5,267.75 0,38.25 0,216.75 382.5,267.75 0,318.75"/>
                                </g>
                        </svg>
                    </button>
                </form>

                <hr class="card-body__horizontal-line">
            </div>
        </div>
        @endforeach
    @else
        <h2>В данный момент новостей нет</h2>
    @endif

{{--
    <div class="breaking-news__news-card card">
        <img src="{{ url('/images/news2.png') }}" class="card-img-top" alt="news">
        <div class="card-body">
            <div class="card-body__author">
                <img src="{{ url('/images/newsAvatar2.png') }}" alt="avatar" class="author__avatar img-fluid">
                <p class="author__nickname">Rus_Brain</p>
                <span class="author__date">09.09.2019</span>
            </div>
            <h2 class="card-body__title">Corrupted Cup 2019: Трофеи</h2>
            <p class="card-body__text">Наконец появились фотографии трофеев турнира. Подробности далее.</p>
            <div class="card-body__items">
                <a class="items__comment" href="#">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                        <path d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1
                            C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59
                            C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079
                            c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007
                            c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5
                            C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"/>
                        <path
                                d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"/>
                        <path
                                d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"/>
                        <path
                                d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"/>
                    </svg>

                    <span>0</span>
                </a>
                <a class="items__share" href="#">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;"
                         xml:space="preserve">

                        <path d="M352,256c-27.902,0-51.993,15.57-64.807,38.307l-139.844-53.785c1.214-5.333,1.984-10.827,1.984-16.522
                            c0-7.388-1.41-14.385-3.418-21.13l143.579-66.275c13.333,20.458,36.32,34.072,62.505,34.072c41.167,0,74.667-33.5,74.667-74.667
                            c0-41.167-33.5-74.667-74.667-74.667S277.333,54.833,277.333,96c0,7.388,1.41,14.385,3.418,21.13l-143.579,66.275
                            c-13.333-20.458-36.32-34.072-62.505-34.072C33.5,149.333,0,182.833,0,224c0,41.167,33.5,74.667,74.667,74.667
                            c27.902,0,51.994-15.57,64.807-38.307l139.844,53.785c-1.214,5.333-1.984,10.827-1.984,16.522c0,41.167,33.5,74.667,74.667,74.667
                            s74.667-33.5,74.667-74.667C426.667,289.5,393.167,256,352,256z M352,42.667c29.406,0,53.333,23.927,53.333,53.333
                            S381.406,149.333,352,149.333S298.667,125.406,298.667,96S322.594,42.667,352,42.667z M74.667,277.333
                            c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333S128,194.594,128,224S104.073,277.333,74.667,277.333z
                             M352,384c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333s53.333,23.927,53.333,53.333S381.406,384,352,384z"/>
                    </svg>
                </a>
                <a class="items__watch" href="#">
                    <svg id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512"
                         viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                        <path
                                d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                    </svg>
                    <span>106</span>
                </a>
            </div>

            <form class="card-body__comment-form">
                <div class="comment-form__group form-group">
                    <label class="comment" for="comment">
                        <input type="text" class="comment__input form-control" id="comment"
                               placeholder="Написать комментарий...">
                    </label>

                    <div class="buttons-upload">
                        <label class="custom-img-upload">
                            <input type="file" accept="image/*"/>
                            <i class="fas fa-camera"></i>
                        </label>

                        <label class="custom-file-upload">
                            <input type="file"/>
                            <i class="fas fa-paperclip"></i>
                        </label>

                        <button class="smile-upload">
                            <i class="far fa-smile"></i>
                        </button>
                    </div>



                </div>
                <button type="submit" class="comment-form__button">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 535.5 535.5"
                         style="enable-background:new 0 0 535.5 535.5;" xml:space="preserve">
                            <g id="send">
                                <polygon points="0,497.25 535.5,267.75 0,38.25 0,216.75 382.5,267.75 0,318.75"/>
                            </g>
                    </svg>
                </button>
            </form>

            <hr class="card-body__horizontal-line">
        </div>
    </div>
--}}

    {{--<div class="breaking-news__news-card card">
        <img src="{{ url('/images/news3.png') }}" class="card-img-top" alt="news">
        <div class="card-body">
            <div class="card-body__author">
                <img src="{{ url('/images/newsAvatar.png') }}" alt="avatar" class="author__avatar img-fluid">
                <p class="author__nickname">SC1F.eOnzErG</p>
                <span class="author__date">09.09.2019</span>
            </div>
            <h2 class="card-body__title">Corrupted Cup 2019: Конкурс предсказателей</h2>
            <p class="card-body__text">Есть возможность заработать до $1,200 без риска, правильно угадав результаты
                матчей Corrupted Cup 2019. К участию допущены все.</p>
            <div class="card-body__items">
                <a class="items__comment" href="#">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                        <path d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1
                            C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59
                            C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079
                            c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007
                            c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5
                            C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"/>
                        <path
                                d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"/>
                        <path
                                d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"/>
                        <path
                                d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"/>
                    </svg>

                    <span>0</span>
                </a>
                <a class="items__share" href="#">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;"
                         xml:space="preserve">

                        <path d="M352,256c-27.902,0-51.993,15.57-64.807,38.307l-139.844-53.785c1.214-5.333,1.984-10.827,1.984-16.522
                            c0-7.388-1.41-14.385-3.418-21.13l143.579-66.275c13.333,20.458,36.32,34.072,62.505,34.072c41.167,0,74.667-33.5,74.667-74.667
                            c0-41.167-33.5-74.667-74.667-74.667S277.333,54.833,277.333,96c0,7.388,1.41,14.385,3.418,21.13l-143.579,66.275
                            c-13.333-20.458-36.32-34.072-62.505-34.072C33.5,149.333,0,182.833,0,224c0,41.167,33.5,74.667,74.667,74.667
                            c27.902,0,51.994-15.57,64.807-38.307l139.844,53.785c-1.214,5.333-1.984,10.827-1.984,16.522c0,41.167,33.5,74.667,74.667,74.667
                            s74.667-33.5,74.667-74.667C426.667,289.5,393.167,256,352,256z M352,42.667c29.406,0,53.333,23.927,53.333,53.333
                            S381.406,149.333,352,149.333S298.667,125.406,298.667,96S322.594,42.667,352,42.667z M74.667,277.333
                            c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333S128,194.594,128,224S104.073,277.333,74.667,277.333z
                             M352,384c-29.406,0-53.333-23.927-53.333-53.333s23.927-53.333,53.333-53.333s53.333,23.927,53.333,53.333S381.406,384,352,384z"/>
                    </svg>
                </a>
                <a class="items__watch" href="#">
                    <svg id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512"
                         viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                        <path
                                d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                    </svg>
                    <span>106</span>
                </a>
            </div>

            <form class="card-body__comment-form">
                <div class="comment-form__group form-group">
                    <label class="comment" for="comment">
                        <input type="text" class="comment__input form-control" id="comment"
                               placeholder="Написать комментарий...">
                    </label>

                    <div class="buttons-upload">
                        <label class="custom-img-upload">
                            <input type="file" accept="image/*"/>
                            <i class="fas fa-camera"></i>
                        </label>

                        <label class="custom-file-upload">
                            <input type="file"/>
                            <i class="fas fa-paperclip"></i>
                        </label>

                        <button class="smile-upload">
                            <i class="far fa-smile"></i>
                        </button>
                    </div>



                </div>
                <button type="submit" class="comment-form__button">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 535.5 535.5"
                         style="enable-background:new 0 0 535.5 535.5;" xml:space="preserve">
                            <g id="send">
                                <polygon points="0,497.25 535.5,267.75 0,38.25 0,216.75 382.5,267.75 0,318.75"/>
                            </g>
                    </svg>
                </button>
            </form>

        </div>
    </div>--}}

</div>

<div class="breaking-news__numb-pages">
    <p class="numb-pages">3 из 762</p>
</div>

<div class="breaking-news__button">
    <button class="button button__download-more">
        Загрузить еще
    </button>
</div>