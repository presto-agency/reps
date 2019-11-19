@isset($replay)
    <section class="page_replay">
        <div class="wrapper">
            <div class=" title_block">
                <div class="left_block">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trophy"
                         class="svg-inline--fa fa-trophy fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 576 512">
                        <path fill="white"
                              d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"></path>
                    </svg>
                    <span class="title_text night_text">{{$replay->title}}</span>
                </div>
                <div class="right_block">
                    @if(!empty($replay->users))
                        <a href="{{route('user_profile',['id'=>$replay->users->id])}}">{{$replay->users->name}}</a>
                        @if(auth()->user()->userViewAvatars())
                            @if(!empty($replay->users->avatar) && file_exists($replay->users->avatar))
                                <img class="icon_bars" src="{{asset($replay->users->avatar)}}"/>
                            @else
                                <img class="icon_bars" src="{{asset($replay->users->defaultAvatar())}}"/>
                            @endif
                        @endif
                        <span>{{$replay->users->count_positive - $replay->users->count_negative .' кг'}}</span>
                        <a href="{{route('user-comments.index',['id'=>$replay->users->id])}}">{{$replay->users->comments_count.' pts'}}</a>
                    @endif
                </div>
            </div>
            <div class="title_block_gray change_gray">
                <div class="title_top left_block">
                    <span class="title_text">{{$replay->title}}</span>
                </div>
                <div class="right_block">
                    <a href="#">
                        <svg class="night_svg" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60"
                             style="enable-background:new 0 0 60 60;" xml:space="preserve">
                            <path d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1
                                C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59
                                C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079
                                c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007
                                c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5
                                C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"></path>
                            <path
                                d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"></path>
                            <path
                                d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"></path>
                            <path
                                d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"></path>
                    </svg>
                        <span class="comment_count">{{$replay->comments_count}}</span>
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock"
                             class="svg-inline--fa fa-clock fa-w-16 night_svg" role="img"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 512 512">
                            <path
                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path>
                        </svg>
                        <span>{{$replay->created_at->format('h:m d.m.Y')}}</span>
                    </a>
                </div>
            </div>
            <div class="replay-content">
                <div class="col-xl-8 ">
                    <div class="content_left">
                        <div class="left_block">
                            <span class="night_text">{{__('Страны:')}}</span>
                        </div>
                        <div class="right_block">
                            @isset($replay->firstCountries)
                                <img src="{{asset($replay->firstCountries->flag)}}" alt="flag"
                                     title="{{$replay->firstCountries->name}}"/>
                            @endisset
                            <span class="night_text"> vs </span>
                            @isset($replay->secondCountries)
                                <img src="{{asset($replay->secondCountries->flag)}}" alt="flag"
                                     title="{{$replay->secondCountries->name}}"/>
                            @endisset
                        </div>
                    </div>
                    <div class="content_left">
                        <div class="left_block">
                            <span class="night_text">{{__('Матчап:')}}</span>
                        </div>
                        <div class="right_block">
                            @isset($replay->firstRaces)
                                <span class="night_text">{{$replay->firstRaces->title}}</span>
                            @endisset
                            <span class="night_text"> vs </span>
                            @isset($replay->secondRaces)
                                <span class="night_text">{{$replay->secondRaces->title}}</span>
                            @endisset
                        </div>
                    </div>
                    <div class="content_left">
                        <div class="left_block">
                            <span class="night_text">{{__('Локации:')}}</span>
                        </div>
                        <div class="right_block">
                            @isset($replay->first_location)
                                <span class="night_text">{{$replay->first_location}}</span>
                            @endisset
                            <span class="night_text"> vs </span>
                            @isset($replay->second_location)
                                <span class="night_text">{{$replay->second_location}}</span>
                            @endisset
                        </div>
                    </div>
                    <div class="content_left">
                        <div class="left_block">
                            <span class="night_text">{{__('Рейтинг:')}}</span>
                        </div>
                        <div class="right_block">
                            <span class="night_text">{{$replay->rating}}</span>
                        </div>
                    </div>
                    @if(Auth::user() && Auth::user()->isNotUser())
                        <div class="replay-edit">
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="edit"
                                 class="svg-inline--fa fa-edit fa-w-18" role="img"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 576 512">
                                <path
                                    d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path>
                            </svg>
                            <a href="{{route('user-replay.edit',['id' => auth()->id(),'user_replay' =>$replay->id])}}">
                                <span class="edit_text">{{__('Редактировать')}}</span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-xl-4 content_right">
                    <p class="title">{{$replay->title}}</p>
                    @isset($replay->maps)
                        @if(!empty($replay->maps->url))
                            <img class="img-fluid" src="{{asset($replay->maps->url)}}" alt="map"
                                 title="{{$replay->maps->name}}">
                        @else
                            <img class="img-fluid" src="{{asset($replay->maps->url)}}" alt="map">
                        @endif
                    @endisset
                    <div class="replay-rating">
                        <a href="#vote-modal" class="positive-vote vote-replay-up" data-toggle="modal" data-rating="1"
                           data-target="#likeModal"
                           data-route="http://reps.ru/replay/15980/set_rating">
                            <svg class="night_svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                 style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
                                    C100.3,174.7,92.8,167.3,83.6,167.3z"></path>
                                <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                                c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                                h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"></path>
                            </svg>
                            <span>{{$replay->positive_count}}</span>
                        </a>
                        <div class="modal fade" id="likeModal" tabindex="-1" role="dialog" aria-labelledby="likeModal"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="likeModalLabel">Оставте коментарий</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="close_modal">&times;</span>
                                        </button>
                                    </div>
                                    {{--                                    авторизований--}}

                                    {{--                                    @include('modal.like_autorization');--}}
                                    {{-- не авторизований--}}

                                    @include('modal.no-autorization');
                                </div>
                            </div>
                        </div>
                        <a href="#vote-modal" class="negative-vote vote-replay-down" data-toggle="modal"
                           data-rating="-1"
                           data-route="http://reps.ru/replay/15980/set_rating" data-target="#diselikeModal">
                            <svg class="night_svg" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"></path>
                                <path
                                    d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"></path>
                            </svg>
                            <span>{{$replay->negative_count}}</span>
                        </a>
                        <div class="modal fade" id="diselikeModal" tabindex="-1" role="dialog"
                             aria-labelledby="likeModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="likeModalLabel">Оставте коментарий</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="close_modal">&times;</span>
                                        </button>
                                    </div>
                                    {{--                                    авторизований--}}

                                    {{--@include('modal.diselike_autorization');--}}
                                    {{-- не авторизований--}}
                                    @include('modal.no-autorization');
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="replay-download">
                        <svg class="night_svg" version="1.1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 471.2 471.2" style="enable-background:new 0 0 471.2 471.2;"
                             xml:space="preserve">
                            <path d="M457.7,230.1c-7.5,0-13.5,6-13.5,13.5v122.8c0,33.4-27.2,60.5-60.5,60.5H87.5C54.1,427,27,399.8,27,366.5V241.7
                                c0-7.5-6-13.5-13.5-13.5S0,234.2,0,241.7v124.8C0,414.8,39.3,454,87.5,454h296.2c48.3,0,87.5-39.3,87.5-87.5V243.7
                                C471.2,236.2,465.2,230.1,457.7,230.1z"></path>
                            <path d="M226.1,346.8c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.8-85.8c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-62.7,62.8V30.8
                                c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v273.9l-62.8-62.8c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1L226.1,346.8z"></path>
                            </svg>
                        <a href="{{route('replay.download',['id' =>$replay->id])}}">
                            <span class="download" data-id="{{$replay->id}}"
                                  data-url="{{url("replay/$replay->id/download_count")}}">{{__('Скачать')}}</span>
                            <span id="downloadCount"
                                  data-count="{{$replay->downloaded}}">{{$replay->downloaded}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if($replay->video_iframe)
            <span>{{__('Видео:')}}</span>
            <div class="replay_video border_shadow">{!! $replay->video_iframe !!}</div>
        @endif
        @if($replay->content)
            <span>{{__('Контент:')}}</span>
            <div class="replay_video border_shadow">{!! $replay->content !!}</div>
        @endif
    </section>
@endisset
<script type="text/javascript">
    $('.download').click(function () {
        let id = $(this).data('id');
        let token = $('meta[name="csrf-token"]').attr('content');
        let url = $(this).data('url');
        $.ajax({
            method: 'POST',
            url: url,
            dataType: 'json',
            async: false,
            data: {
                _token: token,
                id: id,
            },
            success: function (data) {
                $('#downloadCount').html(data.downloaded);
                console.log(data.downloaded);
            },
            error: function (request, status, error) {
                console.log('code: ' + request.status + "\n" + 'message: ' + request.responseText + "\n" + 'error: ' + error);
            }
        });
    });
</script>
