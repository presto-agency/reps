@php
    $last_id = '';
@endphp
<div class="breaking-news border_shadow">
    @if($visible_title)
        <div class="breaking-news__title">
            <svg class="title__icon" viewBox="-96 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path
                        d="m160 512c-88.234375 0-160-71.765625-160-160v-229.332031c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v229.332031c0 70.59375 57.40625 128 128 128s128-57.40625 128-128v-234.667969c0-47.058593-38.273438-85.332031-85.332031-85.332031-47.0625 0-85.335938 38.273438-85.335938 85.332031v213.335938c0 23.53125 19.136719 42.664062 42.667969 42.664062s42.667969-19.132812 42.667969-42.664062v-208c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v208c0 41.171875-33.496094 74.664062-74.667969 74.664062s-74.667969-33.492187-74.667969-74.664062v-213.335938c0-64.679687 52.628907-117.332031 117.335938-117.332031 64.703125 0 117.332031 52.652344 117.332031 117.332031v234.667969c0 88.234375-71.765625 160-160 160zm0 0"/>
            </svg>
            <p class="title__text ">{{__('Последние новости')}}</p>
        </div>
    @endif

    @if($news->isNotEmpty())
        @foreach($news as $single_news)
            <div class="breaking-news__news-card card night_modal">
                @if(!empty($single_news->preview_img) && checkFile::checkFileExists($single_news->preview_img))
                    <a href="{{ route('news.show', $single_news->id) }}">
                        <img src="{{ asset($single_news->preview_img) }}" class="card-img-top" alt="news">
                    </a>
                @endif
                <div class="card-body night_text">
                    <div class="card-body__author">
                        @if(isset($single_news->author) && !empty($single_news->author))
                            @if(auth()->check() && auth()->user()->userViewAvatars())
                                <img src="{{ asset($single_news->author->avatarOrDefault()) }}" alt="avatar"
                                     class="author__avatar img-fluid">
                            @endif
                            @guest()
                                <img src="{{ asset($single_news->author->avatarOrDefault()) }}" alt="avatar"
                                     class="author__avatar img-fluid">
                            @endguest()
                            @if($single_news->author->name)
                                    <a href="#" title="{{ $single_news->author->name }}">   <p class="author__nickname">{{ $single_news->author->name }}</p></a>
                            @endif
                        @endif
                        @if($single_news->created_at)
                            <span
                                    class="author__date">{{\Carbon\Carbon::parse($single_news->created_at)->format('h:m d.m.Y')}}</span>
                        @endif
                    </div>

                    <a href="{{ route('news.show', $single_news->id) }}">
                        <h2 class="card-body__title night_text">{!! ParserToHTML::toHTML($single_news->title,'size') !!} </h2>
                    </a>
                    <div class="card-body__text night_text">
                        {!! ParserToHTML::toHTML($single_news->preview_content,'size') !!}
                    </div>
                    <div class="card-body__items">
                        <a class="items__comment" href="#">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 x="0px" y="0px"
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
                    <hr class="card-body__horizontal-line">
                </div>
            </div>

            @php
                $last_id = $single_news->id;
            @endphp
        @endforeach
        <div id="load_more" class="breaking-news__button night_modal">
            <button type="button" name="load_more_button" class="button button__download-more" data-id="{{ $last_id }}"
                    id="load_more_button">
                {{__('Загрузить еще')}}
            </button>
        </div>
    @else
        <div id="load_more" class="breaking-news__button night_modal">
            <button type="button" name="load_more_button" class="button button__download-more night_text">
                {{__('Пусто')}}
            </button>
        </div>
    @endif
</div>




