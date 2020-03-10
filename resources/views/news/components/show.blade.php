<script>
    function QuoteNews(id) {
        let block = document.getElementById(id);
        $('#coments_id').addClass('news_shadow');
        CKEDITOR.instances['content-comment'].insertHtml(block.innerHTML);
    }
</script>
<div class="detailed-news">
    <div class="detailed-news__title">
        <div class="title__wrap">
            <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                 x="0px" y="0px"
                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
			s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
			C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
			s226,101.383,226,226S380.617,482,256,482z"/>

                <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
			c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
			c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
            </svg>
            <p class="title__text night_text" title="{{ clean($news->title) }}">
                {{ clean($news->title) }}
            </p>
        </div>
        @if(!empty($news->author))
            <div class="title__wrap">
                @if(auth()->check() && auth()->user()->userViewAvatars())
                    <img src="{{asset($news->author->avatarOrDefault())}}" class="title__avatar" alt="avatar">
                @endif
                @guest
                    <img src="{{asset($news->author->avatarOrDefault())}}" class="title__avatar" alt="avatar">
                @endguest
                <a href="{{ route('user_profile',['id'=>$news->author->id]) }}" class="title__nickname night_text"
                   title="{{ $news->author->name ? $news->author->name : 'user' }}">
                    {{ $news->author->name ? $news->author->name : 'user' }}
                </a>
                @if(!empty($news->author->countries))
                    <img src="{{ asset($news->author->countries->flagOrDefault()) }}"
                         class="title__flag" alt="flag" title="{{$news->author->countries->name}}">
                @endif
                <img src="{{asset("images/default/game-races/" . $news->author->races->title . ".png")}}"
                     class="title__cube" alt="race" title="{{$news->author->races->title}}">
                    <div class="block_minerals_icons text_pts">
                        <p class="title__text info__text" title="{{$news->author->comments_count}}">{{$news->author->comments_count}}</p>
                        <img class="minerals_icons" title="minerals" alt="min"
                             src="{{asset('images/minerals_icons/min.png') }}">
                        <p class="title__text text_special info__text">|</p>
                        <p class="title__text info__text" title="{{$news->author->rating}}">{{$news->author->rating}}</p>
                        <img class="minerals_icons" title="supply" alt="sup"
                             src="{{asset('images/minerals_icons/supp.png') }}">
                        <p class="title__text text_special info__text">|</p>
                        <p class="title__text info__text" title="0">{{ $news->author->gas_balance }}</p>
                        <img class="minerals_icons" title="gas" alt="gas"
                             src="{{asset('images/minerals_icons/gaz.png') }}">
                    </div>
            </div>
        @endif
    </div>
    <div class="citation border_shadow">
        <div id="{{$news->id}}">
            <div class="comments__wrapp wrapp_comments_news">
                <div class="detailed-news__info change_gray">
                    <div class="info__items">
                    <span class="items__watch night_text">
                        <img src="{{asset('images/svg/eye-solid.svg')}}" alt="eye">
                        <span>{{$news->reviews}}</span>
                    </span>
                        <span class="items__comment night_text">
                        <img src="{{asset('images/svg/comments.svg')}}" alt="comments">
                        <span> {{ $news->comments_count }}</span>
                    </span>
                        <div class="right">
                            @if(Auth::check() && Auth::user()->isNotUser())
                                <a href="{{route('user-topics.edit',['id' => $news->user_id,'user_topic'=>$news->id])}}">
                                    <img src="{{asset('images/svg/edit-regular.svg')}}" alt="edit">
                                    <span class="edit_text">{{__('Редактировать')}}</span>
                                </a>
                            @endif
                            <p class="items__date">{{$news->created_at->format('H:i d.m.Y')}}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body ">
                    @if(!empty($news->preview_img) && checkFile::checkFileExists($news->preview_img))
                        <img src="{{ asset($news->preview_img) }}" class="img-fluid" alt="news">
                    @endif
                    <h2 class="card-body__title night_text">
                        {!! ParserToHTML::toHTML($news->preview_content,'size') !!}
                    </h2>
                    <div class="card-body__text night_text">
                        {!!  ParserToHTML::toHTML($news->content,'size') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="detailed-news__card card night_modal night_text">
            <div class="card-body__items">
                <div class="card-body__items-wrap">
                    {{--                    <button --}}
                    {{--                        onclick="QuoteNews({{$news->id}})"--}}
                    {{--                        class="items__quote">--}}
                    {{--                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"--}}
                    {{--                             x="0px" y="0px"--}}
                    {{--                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">--}}
                    {{--                            <path d="M256,0C114.6,0,0,114.6,0,256s114.6,256,256,256s256-114.6,256-256S397.4,0,256,0z M256,472c-119.3,0-216-96.7-216-216--}}
                    {{--		                    S136.7,40,256,40s216,96.7,216,216S375.3,472,256,472z"/>--}}
                    {{--                            <path d="M239.1,185.5L209.2,160c-37,27.2-65.2,75.6-65.2,127.4c0,41.6,23.3,64.6,50,64.6c24.2,0,43.5-20.4,43.5-45.9--}}
                    {{--			                c0-24.6-16.9-43.3-39.5-43.3c-4,0-9.7,1.7-10.5,1.7C190.8,237.3,213.3,203.3,239.1,185.5z"/>--}}
                    {{--                            <path d="M326.9,262.8c-3.2,0-8.9,1.7-10.5,1.7c3.2-27.2,25.8-61.1,51.6-79L338.2,160c-37,27.2-65.2,75.6-65.2,127.4--}}
                    {{--			                c0,41.6,23.3,64.6,50,64.6c24.1,0,43.5-20.4,43.5-45.9C366.4,281.5,349.5,262.8,326.9,262.8z"/>--}}
                    {{--                        </svg>--}}
                    {{--                    </button>--}}
                </div>
                <div class="card-body__items-wrap">
                    @php
                        $modal = (!Auth::guest() && $news->user_id == Auth::user()->id) ?'#no-rating':'#vote-modal';
                    @endphp
                    <a href="{{ $modal }}"
                       class="items__like modal_like-diselike night_text positive-vote vote-replay-up"
                       data-toggle="modal" data-rating="1"
                       data-route="{{route('forum.topic.set_rating',['id'=>$news->id])}}">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"/>
                            <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"/>
                        </svg>
                        <span>{{$news->positive_count}}</span>
                    </a>
                    <a href="{{ $modal }}" class="items__dislike modal_like-diselike negative-vote vote-replay-down"
                       data-toggle="modal" data-rating="-1"
                       data-route="{{route('forum.topic.set_rating',['id'=>$news->id])}}">
                        <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"/>
                            <path
                                d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"/>
                        </svg>
                        <span>{{$news->negative_count}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
