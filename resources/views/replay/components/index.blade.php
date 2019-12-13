@php
    $last_id = '';
@endphp

<div class="gocu-replays border_shadow">
    @if($visible_title)
        <div class="gocu-replays__title">
            <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 275.6 275.6" style="enable-background:new 0 0 275.6 275.6;" xml:space="preserve">
		    <path d="M19.6,122l0,0.6c-0.2,4.8,1.3,9.1,4.1,12c4.2,4.3,10.9,5.3,17.4,2.4l25.1-13.7l24.6,13.4l0.5,0.2c2.5,1.1,5,1.7,7.4,1.7
			c3.8,0,7.4-1.5,9.9-4.1c2.9-3,4.3-7.2,4.1-12l-3.3-28.2l18.6-19.1l0.6-0.7c3.5-4.7,4.6-10.1,3-15c-1.7-4.9-5.9-8.5-11.5-10
			l-28.2-4.6L79.7,20.7L79.3,20c-3.3-5-8.2-7.9-13.5-7.9c-5,0-9.8,2.6-13.1,7.2L38,45.1l-25.1,4.2l-0.8,0.2
			c-5.6,1.6-9.8,5.3-11.4,10.2c-1.6,4.9-0.5,10.3,3,15l19.1,19.7L19.6,122z M14.9,65.7c-0.6-0.9-0.6-1.4-0.6-1.5
			c0-0.1,0.4-0.5,1.4-0.8l31.4-5.3l17.4-30.6c0.7-0.9,1.2-1,1.3-1c0.1,0,0.6,0.2,1.3,1.1l15.2,30.5l34.4,5.5
			c0.9,0.3,1.3,0.6,1.4,0.7c0,0.1-0.1,0.6-0.6,1.4l-23,23.6l4,34.1c0,0.4,0,0.8-0.1,1c-0.2,0-0.6-0.1-1-0.3l-31.2-17l-31.2,17
			c-0.4,0.2-0.8,0.3-1,0.3c-0.1-0.2-0.1-0.6-0.1-1l4-34.1L14.9,65.7z"/>
                <path d="M263.3,49.6l-28.2-4.6L223,20.7l-0.4-0.7c-3.3-5-8.2-7.9-13.5-7.9c-5,0-9.8,2.6-13.1,7.2l-14.7,25.8l-25.1,4.2l-0.8,0.2
			c-5.6,1.6-9.8,5.3-11.4,10.2s-0.5,10.3,3,15l19.1,19.7l-3.3,27.7l-0.1,0.6c-0.2,4.8,1.3,9.1,4.1,12c4.2,4.3,10.9,5.3,17.4,2.4
			l25.1-13.7l24.6,13.4l0.5,0.2c2.5,1.1,5,1.7,7.4,1.7c3.8,0,7.4-1.5,9.9-4.1c2.9-3,4.3-7.2,4.1-12l-3.3-28.2l18.6-19.1l0.6-0.7
			c3.5-4.7,4.6-10.1,3-15C273.2,54.8,269,51.2,263.3,49.6z M260.7,65.7l-23,23.6l4,34.1c0,0.4,0,0.8-0.1,1c-0.2,0-0.6-0.1-1-0.3
			l-31.2-17l-31.2,17c-0.4,0.2-0.8,0.3-1,0.3c-0.1-0.2-0.1-0.6-0.1-1l4-34.1l-23-23.6c-0.6-0.9-0.6-1.4-0.6-1.5
			c0-0.1,0.4-0.5,1.4-0.8l31.4-5.3l17.4-30.6c0.7-0.9,1.2-1,1.3-1c0.1,0,0.6,0.2,1.3,1.1l15.2,30.5l34.4,5.5
			c0.9,0.3,1.3,0.6,1.4,0.7C261.3,64.4,261.2,64.9,260.7,65.7z"/>
                <path d="M188.9,174.4l-28.2-4.6l-12.1-24.4l-0.4-0.7c-3.3-5-8.2-7.9-13.5-7.9c-5,0-9.8,2.6-13.1,7.2l-14.7,25.8L81.7,174l-0.8,0.2
			c-5.6,1.6-9.8,5.3-11.4,10.2c-1.6,4.9-0.5,10.3,3,15l19.1,19.7l-3.3,27.7l0,0.6c-0.2,4.8,1.3,9.1,4.1,12
			c4.2,4.3,10.9,5.3,17.4,2.4l25.1-13.7l24.6,13.4l0.5,0.2c2.5,1.1,5,1.7,7.4,1.7c3.9,0,7.4-1.5,9.9-4.1c2.9-3,4.3-7.2,4.1-12
			l-3.3-28.2l18.6-19.1l0.6-0.7c3.5-4.7,4.6-10.1,3-15C198.8,179.5,194.5,175.9,188.9,174.4z M186.2,190.4l-23,23.6l4,34.1
			c0,0.5,0,0.8-0.1,1c-0.2,0-0.6-0.1-1-0.3l-31.2-17l-31.2,17c-0.4,0.2-0.8,0.3-1,0.3c0-0.2-0.1-0.6-0.1-1l4-34.1l-23-23.6
			c-0.6-0.9-0.6-1.4-0.6-1.5c0-0.1,0.4-0.5,1.4-0.8l31.4-5.3l17.4-30.6c0.7-0.9,1.2-1,1.3-1c0.1,0,0.6,0.2,1.3,1.1l15.2,30.5
			l34.4,5.5c0.9,0.3,1.3,0.6,1.4,0.7C186.9,189.1,186.8,189.7,186.2,190.4z"/>
        </svg>
            @if(request()->has('subtype') && request()->exists('subtype'))
                @if(request('subtype') =='duel')
                    <p class="title__text night_text">{{__('1X1')}}</p>
                @elseif(request('subtype') =='pack')
                    <p class="title__text night_text">{{__('PARK / ARCHIVE')}}</p>
                @elseif(request('subtype') =='gotw')
                    <p class="title__text night_text">{{__('GAME OF THE WEEK')}}</p>
                @elseif(request('subtype') =='team')
                    <p class="title__text night_text">{{__('2X2, 3X3, 4X4')}}</p>
                @else
                    <p class="title__text night_text">{{__('Реплеи')}}</p>
                @endif
            @else
                @if(isset($type) && !empty($type))
                    @if($type == "user")
                        <p class="title__text night_text">{{__('Пользовательские')}}</p>
                    @elseif($type == "pro")
                        <p class="title__text night_text">{{__('Профессиональные')}}</p>
                    @endif
                @else
                    <p class="title__text night_text">{{__('Реплеи')}}</p>
                @endif
            @endif
        </div>
    @endif
    @isset($replay)
        @if(!$replay->isEmpty())
            @foreach($replay as $item)
                <div class="gocu-replays__subtitle change_gray">
                    @isset($userReplayRout)
                        @if($userReplayRout)
                            @isset($type)
                                <a class="subtitle__name night_text" title="{!! ParserToHTML::toHTML($item->title,'size') !!}"
                                   href="{{ asset(url("user/{$item->users->id}/user-replay/{$item->id}"."?type={$type}"))}}">
                                   {!! ParserToHTML::toHTML($item->title,'size') !!}
                                </a>
                            @endisset
                        @else
                            @isset($type)
                                <a class="subtitle__name night_text" title="{!! ParserToHTML::toHTML($item->title,'size') !!}"
                                   href="{{ asset(url("replay/{$item->id}"."?type={$type}"))}}">
                                    {!! ParserToHTML::toHTML($item->title,'size') !!}
                                </a>
                            @endisset
                        @endif
                    @endisset
                    <p class="subtitle__date night_text">{{$item->created_at->format('H:i d.m.Y')}}</p>
                </div>
                <div class="gocu-replays__match">
                    <div class="match__author">
                        <div class="subtitle__info">
                            @if(isset($item->users) && !empty($item->users))
                                @if(auth()->check() && auth()->user()->userViewAvatars())
                                    <img src="{{asset($item->users->avatarOrDefault())}}" alt="avatar">
                                @endif
                                @guest()
                                    <img src="{{asset($item->users->avatarOrDefault())}}" alt="avatar">
                                @endguest()
                               <a href="#"> <span class="comment-author__nickname"
                                      title="{{$item->users->name}}">{{$item->users->name}}</span>
                               </a>
                            @endif
                            @if(!empty($item->file) && checkFile::checkFileExists($item->file))
                                <span class="comment-author__replay-item night_text">{{__('REP')}}</span>
                            @else
                                <span class="comment-author__replay-item night_text">{{__('VOD')}}</span>
                            @endif
                        </div>
                        <div class="subtitle__icons">
                            <svg version="1.1" id="Capa_1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 x="0px" y="0px"
                                 viewBox="0 0 60 60" xml:space="preserve">
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
                            <span
                                    class="night_text">{{$item->comments_count}}</span>
                            <a class="items__download night_text download"
                               data-id="{{$item->id}}"
                               data-url="{{asset("replay/$item->id/download_count")}}"
                               href="{{route('replay.download',['id' =>$item->id])}}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                     version="1.1"
                                     id="Capa_1" x="0px" y="0px"
                                     viewBox="0 0 471.2 471.2"
                                     style="enable-background:new 0 0 471.2 471.2;"
                                     xml:space="preserve">
                            <path
                                    d="M457.7,230.1c-7.5,0-13.5,6-13.5,13.5v122.8c0,33.4-27.2,60.5-60.5,60.5H87.5C54.1,427,27,399.8,27,366.5V241.7    c0-7.5-6-13.5-13.5-13.5S0,234.2,0,241.7v124.8C0,414.8,39.3,454,87.5,454h296.2c48.3,0,87.5-39.3,87.5-87.5V243.7    C471.2,236.2,465.2,230.1,457.7,230.1z"/>
                                    <path
                                            d="M226.1,346.8c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.8-85.8c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-62.7,62.8V30.8    c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v273.9l-62.8-62.8c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1L226.1,346.8z"/>
                        </svg>
                                <span class="night_text" id="{{'downloadCount'.$item->id}}"
                                      data-count="{{$item->downloaded}}">{{$item->downloaded}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="match__comment night_text">{!! ParserToHTML::toHTML($item->content,'size') !!}</div>

                    <div class="match__info">
                        <div class="info__country">
                            <span class="country__text night_text">Страны:</span>
                            @isset($item->firstCountries)
                                <img class="country__img country-first" src="{{asset($item->firstCountries->flagOrDefault())}}"
                                     alt="flag" title="{{$item->firstCountries->name}}">
                            @endisset
                            <span class="country__text night_text">vs</span>
                            @isset($item->secondCountries)
                                <img src="{{asset($item->secondCountries->flagOrDefault())}}"
                                     alt="flag" title="{{$item->secondCountries->name}}">
                            @endisset
                        </div>
                        <div class="info__match-up">
                            <span class="match-up__text night_text">Матчап: </span>
                            @isset($item->firstRaces)
                                <span class="match-up__name name__first night_text"
                                      title="{{$item->firstRaces->title}}">{{$item->firstRaces->code}}</span>
                            @endisset
                            <span class="match-up__text match-up__versus night_text">vs</span>
                            @isset($item->secondRaces)
                                <span class="match-up__name name__second night_text"
                                      title="{{$item->secondRaces->title}}">{{$item->secondRaces->code}}</span>
                            @endisset
                        </div>
                        <div class="info__maps">
                            <span class="maps__text night_text">Карта:</span>
                            @isset($item->maps)
                                <span class="maps__name">{{$item->maps->name}}</span>
                            @endisset
                        </div>
                        <div class="info__wins">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
	                <path d="M497,37h-65.7c0.2-7.3,0.4-14.6,0.4-22c0-8.3-6.7-15-15-15H95.3c-8.3,0-15,6.7-15,15c0,7.4,0.1,14.7,0.4,22H15
                    C6.7,37,0,43.7,0,52c0,67.2,17.6,130.6,49.5,178.6c31.5,47.4,73.5,74.6,118.9,77.2c10.3,11.2,21.2,20.3,32.5,27.3v66.7h-25.2
                    c-30.4,0-55.2,24.8-55.2,55.2V482h-1.1c-8.3,0-15,6.7-15,15c0,8.3,6.7,15,15,15h273.1c8.3,0,15-6.7,15-15c0-8.3-6.7-15-15-15h-1.1
                    v-25.2c0-30.4-24.8-55.2-55.2-55.2h-25.2V335c11.3-7,22.2-16.1,32.5-27.3c45.4-2.6,87.4-29.8,118.9-77.2
                    C494.4,182.6,512,119.2,512,52C512,43.7,505.3,37,497,37z M74.4,213.9C48.1,174.4,32.7,122.6,30.3,67h52.1
                    c5.4,68.5,21.5,131.7,46.6,182c4,8,8.2,15.6,12.5,22.7C116.6,262.2,93.5,242.5,74.4,213.9z M437.6,213.9
                    c-19,28.6-42.1,48.3-67.1,57.7c4.3-7.1,8.5-14.7,12.5-22.7c25.1-50.2,41.2-113.5,46.6-182h52.1
                    C479.3,122.6,463.9,174.4,437.6,213.9z"/>
                </svg>
                            <span class="wins__text night_text">{{$item->rating}}</span>
                        </div>
                    </div>
                </div>
                <hr>
                @php
                    $last_id = $item->id;
                @endphp
            @endforeach

            <div id="load_more-replay" class="gocu-replays__button night_modal">
                <button type="button" name="load_more-replay_button" class="button button__download-more night_text"
                        id="load_more-replay_button" data-id="{{ $last_id }}" data-subtype="{{$subtype}}">
                    {{__('Загрузить еще')}}
                </button>
            </div>
        @else
            <div id="load_more-replay" class="gocu-replays__button night_modal">
                <button type="button" name="load_more-replay_button" class="button button__download-more night_text">
                    {{__('Пусто')}}
                </button>
            </div>
        @endif
    @endisset
</div>
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
                let it = "#downloadCount" + id;
                $(it).html(data.downloaded);
                console.log(data.downloaded);
            },
            error: function (request, status, error) {
                console.log('code: ' + request.status + "\n" + 'message: ' + request.responseText + "\n" + 'error: ' + error);
            }
        });
    });
</script>
