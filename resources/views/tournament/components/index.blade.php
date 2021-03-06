@php
    $last_id = '';
@endphp
<section class="Page_tournament-content">
    <div class="wrapper border_shadow">
        @if($visible_title)
            <div class=" title_block">
                <div class="left_content">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trophy"
                         class="svg-inline--fa fa-trophy fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 576 512">
                        <path fill="white"
                              d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"></path>
                    </svg>
                    <p class="title_text">{{__('Предстоящие турниры')}}</p>
                </div>
            </div>
        @endif
        @if(isset($tournamentList) &&  $tournamentList->isNotEmpty())
            @foreach($tournamentList as $item)
                <div class="block_navigationTournament change_gray">
                    <a href="{{route('tournament.show',['tournament' =>$item->id])}}"
                       title="Название">{{$item->name}}</a>
                </div>
                <div class="tournament_info">
                    <div class="place" title="Место">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker-alt"
                             class="svg-inline--fa fa-map-marker-alt fa-w-12" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path
                                d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path>
                        </svg>
                        <span>{{$item->place}}</span>
                    </div>
                    <div class="time" title="{{__('Дата начала')}}">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock"
                             class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 512 512">
                            <path
                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path>
                        </svg>
                        <span
                            class="night_text">{{ Carbon\Carbon::parse($item->start_time)->format('H:i d.m.Y')}}</span>
                    </div>
                    <div class="status" title="{{__('Статус')}}">
                        <span class="upcoming darck_gray_color">{{$tournamentStatus[$item->status]}}</span>
                    </div>
                    <div class="palayers" title="{{__('Игроки: Подтверждённые/(Все)')}}">
                        <span
                            class="night_text">{{$item->check_players_count.'/'}}{{'('.$item->players_count.')'}}</span>
                    </div>
                </div>
                @php
                    $last_id = $item->id;
                @endphp
            @endforeach
            <div class="gocu-replays__button night_modal">
                <button type="button" class="button button__download-more" id="load_more-tournament"
                        data-id="{{ $last_id }}">{{__('Загрузить еще')}}
                </button>
            </div>
        @else
            <div class="gocu-replays__button night_modal">
                <button type="button" class="button button__download-more">
                    {{__('Пусто')}}
                </button>
            </div>
        @endif
    </div>
</section>
