@if($forumSectionsTopics->isNotEmpty())
    @foreach($forumSectionsTopics as $item)
        <div class="panel night_modal">
            <div class="panel__wrap">
                <div class="panel__header">
                    <div class="header__items">
                        <a class="items__link"
                           href="{{route('forum.show',['forum'=>$item->id])}}">{{$item->title}}</a>
                        <span>{{__('|')}}</span>
                        <a class="items__link"
                           href="{{route('topic.show',['topic'=>$item->id])}}">{!! ParserToHTML::toHTML($item->title,'size') !!}</a>
                    </div>
                    <div class="header__items">
                        <svg class="items__icon" xmlns="http://www.w3.org/2000/svg" id="Capa_1"
                             enable-background="new 0 0 515.556 515.556" viewBox="0 0 515.556 515.556">
                            <path
                                d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                            <path
                                d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                        </svg>
                        <p class="items__info">{{$item->created_at->format('h:m d.m.Y')}}</p>
                        <p class="items__info info">{{'#'.$item->id}}</p>
                    </div>
                </div>
                <div class="panel__body">
                    <p class="body__comment night_text">{!! ParserToHTML::toHTML($item->content,'size') !!}</p>
                </div>
                <div class="panel__footer">
                    <div class="footer__item">
                        <button class="items__items item__watch">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1"
                                 enable-background="new 0 0 515.556 515.556"
                                 viewBox="0 0 515.556 515.556">
                                <path
                                    d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                                <path
                                    d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                            </svg>
                            <span>{{ $item->reviews }}</span>
                        </button>
                        <button class="items__items item__comment">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60"
                                 xml:space="preserve">
	                    <path
                            d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1   C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59   C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079   c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007   c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5   C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"/>
                                <path
                                    d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"/>
                                <path
                                    d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"/>
                                <path
                                    d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"/>
                    </svg>
                            <span>{{$item->comments_count}}</span>
                        </button>
                    </div>
                    <div class="footer__item">
                        <button class="items__items item__like">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 x="0px" y="0px"
                                 viewBox="0 0 512 512"
                                 style="enable-background:new 0 0 512 512;" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"></path>
                                <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"></path>
                        </svg>
                            <span>{{$item->positive_count}}</span>
                        </button>
                        <button class="items__items item__dislike">
                            <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"></path>
                                <path
                                    d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"></path>
                            </svg>
                            <span>{{$item->negative_count}}</span>
                        </button>
                        <a class="rate"
                           href="{{route('forum.topic.get_rating',['id' => $item->id])}}">
                            рейтинг лист</a>
                    </div>
                    <div class="footer__item">
                        <a class="item__later"
                           href="{{route('topic.show',['topic'=> $item->id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 489.6 489.6"
                                 xml:space="preserve">
                                                <path
                                                    d="M394.8,261.5V81.7c0-24.9-20.3-45.2-45.2-45.2H45.2C20.3,36.5,0,56.8,0,81.7v179.8c0,24.9,20.3,45.2,45.2,45.2h12.9v54.2    c0,10,8.1,18.1,18.2,18.1l0,0c5.2,0,10.2-2.3,13.7-6.3l57.1-66.1h202.6C374.5,306.7,394.8,286.4,394.8,261.5z M141.4,282.2    c-3.6,0-6.9,1.5-9.3,4.2l-49.6,57.3v-49.3c0-6.8-5.5-12.3-12.3-12.3h-25c-11.4,0-20.7-9.3-20.7-20.7V81.7    c0-11.4,9.3-20.7,20.7-20.7h304.4c11.4,0,20.7,9.3,20.7,20.7v179.8c0,11.4-9.3,20.7-20.7,20.7L141.4,282.2L141.4,282.2z"/>
                                <path
                                    d="M399.7,446.8c3.5,4.1,8.5,6.3,13.6,6.3c2.1,0,4.3-0.4,6.4-1.2c7.2-2.7,11.8-9.3,11.8-17v-54.2h12.9    c24.9,0,45.2-20.3,45.2-45.2V155.7c0-24.9-20.3-45.2-45.2-45.2c-6.8,0-12.3,5.5-12.3,12.2c0,6.8,5.5,12.3,12.3,12.3    c11.4,0,20.7,9.3,20.7,20.7v179.8c0,11.4-9.3,20.7-20.7,20.7h-25.1c-6.8,0-12.3,5.5-12.3,12.3v49.3l-49.6-57.3    c-2.3-2.7-5.7-4.2-9.3-4.2h-184c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h178.4L399.7,446.8z"/>
                                <circle cx="197.4" cy="175.9" r="14.6"/>
                                <circle cx="246.3" cy="175.9" r="14.6"/>
                                <circle cx="148.5" cy="175.9" r="14.6"/>
                                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @php
            $last_topic = $item->id;
            $user_id = $item->user_id;
        @endphp
    @endforeach
    <div id="load_more_user_forum_sections_topics" class="gocu-replays__button night_modal">
        <button type="button" name="load_more_user_gallery_button"
                class="button button__download-more night_text"
                id="load_more_user_forum_sections_topics_button"  data-topic_id="{{ $last_topic }}" data-user_id="{{ $user_id }}">
            {{__('Загрузить еще')}}
        </button>
    </div>
@else
    <div class="gocu-replays__button night_modal">
        <button type="button" name="load_more_user_forum_sections"
                class="button button__download-more night_text">
            {{__('Пусто')}}
        </button>
    </div>
@endif
