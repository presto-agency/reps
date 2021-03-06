@isset($topic)
    <div class="detailed-forum border_shadow">
        <div class="detailed-forum__title">
            <div class="title__wrap small_wrap">
                <svg class="title__icon" xmlns="http://www.w3.org/2000/svg"
                     x="0px" y="0px"
                     viewBox="0 0 512 512" xml:space="preserve">

		        <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
                s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
                s226,101.383,226,226S380.617,482,256,482z"/>

                    <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
                c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
                c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
            </svg>
                <div class="title__text"
                     title="{{clean($topic->title)}}">{{clean($topic->title)}}</div>
            </div>
            <div class="title__wrap">
                @if(!empty($topic->author))
                    @if(auth()->check() && auth()->user()->userViewAvatars())
                        <img src="{{asset($topic->author->avatarOrDefault())}}" class="title__avatar" alt="avatar">
                    @endif
                    @guest()
                        <img src="{{asset($topic->author->avatarOrDefault())}}" class="title__avatar" alt="avatar">
                    @endguest()
                    <p class="title__nickname"
                       title="{{ clean($topic->author->name) ? clean($topic->author->name) : 'user' }}">{{ clean($topic->author->name) ? clean($topic->author->name) : 'user' }}</p>
                    @if($topic->author->countries)
                        <img src="{{ asset($topic->author->countries->flagOrDefault()) }}" class="title__flag"
                             title="{{ $topic->author->countries->name }}" alt="flag">
                    @endif
                    <img src="{{asset('images/default/game-races/' . $topic->author->races->title . '.png')}}"
                         class="title__cube" title="{{ $topic->author->races->title }}" alt="race">
                    <div class="block_minerals_icons text_pts">
                        <p class="title__text" title="{{$topic->author->comments_count}}">
                            {{$topic->author->comments_count}}</p>
                        <img class="minerals_icons" title="minerals" alt="min"
                             src="{{asset('images/minerals_icons/min.png') }}">
                        <p class="title__text text_special">|</p>
                        <p class="title__text" title="{{$topic->author->rating}}">
                            {{$topic->author->rating}}</p>
                        <img class="minerals_icons" title="supply" alt="sup"
                             src="{{asset('images/minerals_icons/supp.png') }}">
                        <p class="title__text text_special ">|</p>
                        <p class="title__text ">{{ $topic->author->gas_balance }}</p>
                        <img class="minerals_icons" title="gas" alt="gas"
                             src="{{asset('images/minerals_icons/gaz.png') }}">

                    </div>
                @endif
            </div>

        </div>
        <div class="detailed-forum__info change_gray ">
            <div class="info__items">
                <div class="left">
                    <div class="items__watch">
                        <svg id="Capa_1" enable-background="new 0 0 515.556 515.556" viewBox="0 0 515.556 515.556"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                            <path
                                d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                        </svg>
                        <span>{{$topic->reviews}}</span>
                    </div>
                    <div class="items__comment">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             x="0px" y="0px"
                             viewBox="0 0 511.6 511.6" style="enable-background:new 0 0 511.6 511.6;"
                             xml:space="preserve">
                    <path d="M301.9,327.6c30.9-13,55.3-30.8,73.2-53.2C393,251.9,402,227.4,402,201c0-26.5-8.9-50.9-26.8-73.4
                            c-17.9-22.5-42.3-40.2-73.2-53.2C271,61.3,237.4,54.8,201,54.8c-36.4,0-70,6.5-100.9,19.6c-30.9,13-55.3,30.8-73.2,53.2
                            C8.9,150.1,0,174.5,0,201c0,22.6,6.8,44,20.3,64c13.5,20,32.1,36.8,55.7,50.5c-1.9,4.6-3.9,8.8-5.9,12.6c-2,3.8-4.4,7.5-7.1,11
                            c-2.8,3.5-4.9,6.3-6.4,8.3c-1.5,2-4,4.8-7.4,8.4c-3.4,3.6-5.6,6-6.6,7.1c0-0.2-0.4,0.2-1.1,1.3c-0.8,1-1.2,1.5-1.3,1.4
                            c-0.1-0.1-0.5,0.4-1.1,1.4c-0.7,1-1,1.6-1,1.6l-0.7,1.4c-0.3,0.6-0.5,1.1-0.6,1.7c-0.1,0.6-0.1,1.2-0.1,1.9s0.1,1.3,0.3,1.9
                            c0.4,2.5,1.5,4.5,3.3,6c1.8,1.5,3.8,2.3,5.9,2.3h0.9c9.5-1.3,17.7-2.9,24.6-4.6c29.3-7.6,55.8-19.8,79.4-36.5
                            c17.1,3,33.9,4.6,50.2,4.6C237.3,347.2,271,340.6,301.9,327.6z M142.2,303.8l-12.6,8.8c-5.3,3.6-11.2,7.3-17.7,11.1l10-24
                            l-27.7-16c-18.3-10.7-32.5-23.2-42.5-37.7c-10.1-14.5-15.1-29.5-15.1-45.1c0-19.4,7.5-37.6,22.4-54.5
                            c14.9-16.9,35.1-30.4,60.4-40.3c25.3-9.9,52.5-14.8,81.7-14.8s56.3,5,81.7,14.8c25.3,9.9,45.4,23.3,60.4,40.3
                            c14.9,16.9,22.4,35.1,22.4,54.5c0,19.4-7.5,37.6-22.4,54.5c-14.9,16.9-35.1,30.4-60.4,40.3c-25.3,9.9-52.5,14.8-81.7,14.8
                            c-14.3,0-28.8-1.3-43.7-4L142.2,303.8z"/>
                            <path d="M491.3,338.2c13.5-19.9,20.3-41.3,20.3-64.1c0-23.4-7.1-45.3-21.4-65.7c-14.3-20.4-33.7-37.3-58.2-50.8
                            c4.4,14.3,6.6,28.7,6.6,43.4c0,25.5-6.4,49.7-19.1,72.5c-12.8,22.8-31,43-54.8,60.5c-22.1,16-47.2,28.3-75.4,36.8
                            c-28.2,8.6-57.6,12.8-88.2,12.8c-5.7,0-14.1-0.4-25.1-1.1c38.3,25.1,83.2,37.7,134.8,37.7c16.4,0,33.1-1.5,50.3-4.6
                            c23.6,16.8,50.1,28.9,79.4,36.5c6.9,1.7,15,3.2,24.6,4.6c2.3,0.2,4.4-0.5,6.3-2c1.9-1.5,3.1-3.6,3.7-6.3c-0.1-1.1,0-1.8,0.3-1.9
                            c0.3-0.1,0.2-0.7-0.1-1.9c-0.4-1.1-0.6-1.7-0.6-1.7l-0.7-1.4c-0.2-0.4-0.5-0.9-1-1.6c-0.5-0.7-0.9-1.1-1.1-1.4
                            c-0.3-0.3-0.7-0.8-1.3-1.4c-0.6-0.7-1-1.1-1.1-1.3c-1-1.1-3.1-3.5-6.6-7.1c-3.4-3.6-5.9-6.4-7.4-8.4c-1.5-2-3.7-4.8-6.4-8.3
                            c-2.8-3.5-5.1-7.2-7.1-11c-2-3.8-3.9-8-5.9-12.6C459.3,374.9,477.8,358.1,491.3,338.2z"/>
                    </svg>
                        <span>{{ $topic->comments_count }}</span>
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->isNotUser())
                    <div class="right">
                        <a href="{{route('user-topics.edit',['id' => $topic->user_id,'user_topic'=>$topic->id])}}">
                            <svg aria-hidden=" true" focusable="false" data-prefix="far" data-icon="edit"
                                 class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 576 512">
                                <path
                                    d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path>
                            </svg>

                            <span class="edit_text">{{__('Редактировать')}}</span>

                        </a>
                        <p class="items__date">{{$topic->created_at->format('H:i d.m.Y')}}</p>
                    </div>
                @endif
            </div>
        </div>
        <hr>
        <div class="detailed-forum__card card">
            <div class="card-body night_modal">
                @if(!empty($topic->preview_img) && checkFile::checkFileExists($topic->preview_img))
                    <img src="{{ asset($topic->preview_img) }}" class="card-img-top" alt="forum image">
                @endif

                <h2 class="card-body__text night_text">{!! $topic->preview_content !!}</h2>
                <div class="card-body__text night_text">{!! $topic->content !!}</div>
                <div class="card-body__items">
                    <div class="card-body__items-wrap">
                        <div class="items__quote night_text">
                            {{--                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"--}}
                            {{--                                 x="0px" y="0px"--}}
                            {{--                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">--}}
                            {{--	                    <path d="M256,0C114.6,0,0,114.6,0,256s114.6,256,256,256s256-114.6,256-256S397.4,0,256,0z M256,472c-119.3,0-216-96.7-216-216--}}
                            {{--		                    S136.7,40,256,40s216,96.7,216,216S375.3,472,256,472z"/>--}}
                            {{--                                <path d="M239.1,185.5L209.2,160c-37,27.2-65.2,75.6-65.2,127.4c0,41.6,23.3,64.6,50,64.6c24.2,0,43.5-20.4,43.5-45.9--}}
                            {{--			                c0-24.6-16.9-43.3-39.5-43.3c-4,0-9.7,1.7-10.5,1.7C190.8,237.3,213.3,203.3,239.1,185.5z"/>--}}
                            {{--                                <path d="M326.9,262.8c-3.2,0-8.9,1.7-10.5,1.7c3.2-27.2,25.8-61.1,51.6-79L338.2,160c-37,27.2-65.2,75.6-65.2,127.4--}}
                            {{--			                c0,41.6,23.3,64.6,50,64.6c24.1,0,43.5-20.4,43.5-45.9C366.4,281.5,349.5,262.8,326.9,262.8z"/>--}}
                            {{--                    </svg>--}}
                        </div>
                    </div>
                    <div class="card-body__items-wrap">
                        @php
                            $modal = (!Auth::guest() &&  $topic->user_id == Auth::user()->id) ?'#no-rating':'#vote-modal';
                        @endphp
                        <a href="{{$modal}}"
                           class="modal_like-diselike items__like positive-vote vote-replay-up night_text"
                           data-toggle="modal" {{--data-target="#vote-modal" --}}data-rating="1"
                           data-route="{{route('forum.topic.set_rating',['id'=>$topic->id])}}">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"/>
                                <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"/>
                    </svg>
                            <span id="positive-vote">{{$topic->positive_count}}</span>
                        </a>
                        <a href="{{$modal}}" class="items__dislike modal_like-diselike negative-vote vote-replay-down"
                           data-toggle="modal"
                           {{--data-target="#vote-modal"--}} data-rating="-1"
                           data-route="{{route('forum.topic.set_rating',['id'=>$topic->id])}}">
                            <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"/>
                                <path
                                    d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"/>
                            </svg>
                            <span id="negative-vote">{{$topic->negative_count}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
