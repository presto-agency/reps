@inject('rout','App\Services\User\UserActivityLogService')

@php
    $last_id = '';
@endphp

<div class="comments">
    @if($visible_title)
        <div class="comments__title" id="comments_id">
            <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
            <p class="title__text">{{__('Результаты поиска <'.request('search').'> в комментариях')}}</p>
        </div>
    @endif
    @if(isset($comments) && $comments->isNotEmpty())
        @foreach($comments as $item)
            <div class="citation border_shadow comments__wrapp wrapp_comments">

                @if(!empty($item->user))
                    <div class="comments__info change_gray">
                        @if(auth()->check() && auth()->user()->userViewAvatars())
                            <img src="{{asset($item->user->avatarOrDefault())}}" class="info__avatar"
                                 alt="avatar">
                        @endif
                        @guest()
                            <img src="{{asset($item->user->avatarOrDefault())}}" class="info__avatar"
                                 alt="avatar">
                        @endguest()

                        <a href="{{route('user_profile',['id'=>$item->user->id])}}"
                           title="{{$item->user->name}}" class="info__nickname night_text">
                            {{$item->user->name}}</a>
                        @if(!empty($item->user->countries))
                            <img src="{{asset($item->user->countries->flagOrDefault())}}"
                                 class="info__flag" alt="flag" title="{{$item->user->countries->name}}">
                        @endif
                        @if(!empty($item->user->races))
                            <img
                                src="{{asset('images/default/game-races/'.$item->user->races->title.'.png')}}"
                                class="info__cube" alt="race" title="{{$item->user->races->title}}">
                            <p class="info__text"
                               title="{{$item->user->comments_count.' minerals | '. $item->user->rating.' supply'}}">
                                {{$item->user->comments_count.' minerals | '. $item->user->rating.' supply'}}
                            </p>
                        @endif
                        <span
                            class="info__date">{{$item->created_at->format('H:i d.m.Y')}}</span>
                    </div>
                @endif
                <div class="comments__content">
                    <a class="body__numb" href="{{asset($rout::getCommentRoute($item))}}">{{$item->id}}</a>
                    <div class="content__title night_text">
                        {!! ParserToHTML::toHTML(clean($item->content),'size') !!}
                    </div>
                </div>
                <div class="comments__items">
                    <div class="items__wrap">
                    </div>
                    <div class="items__wrap">
                        <span class="items__like modal_like-diselike positive-vote vote-replay-up"
                              data-toggle="modal"
                              data-rating="1" data-route="{{route('comment.set_rating',['id'=>$item->id])}}">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                 xml:space="preserve">
                                                        <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
                                                            C100.3,174.7,92.8,167.3,83.6,167.3z"/>
                                <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                                                        c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                                                        h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"/>
                                                </svg>
                            <span>{{$item->positive_count }}</span>
                        </span>
                        <span class="items__dislike negative-vote vote-replay-down"
                              data-toggle="modal" data-rating="-1"
                              data-route="{{route('comment.set_rating',['id'=>$item->id])}}">
                            <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"/>
                                <path
                                    d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"/>
                            </svg>
                            <span>{{$item->negative_count }}</span>
                        </span>
                    </div>
                </div>
            </div>
            @php
                $last_id = $item->id;
            @endphp
        @endforeach
        <div class="breaking-news__button night_modal">
            <button type="button" class="button button__download-more" id="load_more_comments_search_button"
                    data-id="{{ $last_id }}">{{__('Загрузить еще')}}
            </button>
        </div>
    @else
        <div class="breaking-news__button night_modal">
            <button type="button" class="button button__download-more night_text">
                {{__('Пусто')}}
            </button>
        </div>
    @endif
</div>
