<section class="Page_tournamentDetail-content">
    <div class="wrapper border_shadow">
        <div class=" title_block">
            <div class="left_content">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     x="0px" y="0px"
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
                <p class="title_text">{{$tournament->name}}</p>
            </div>
        </div>

        <div class="row block_replay_content">
            <div class="col-xl-6 col-lg-6 col-md-6 block_left">
                @if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified() && $tournament::$status[$tournament->status] == 'REGISTRATION')
                    @if(empty($tournament->player))
                        <div class="check_registration">
                            <button class="button button__download-more night_text" type="button" data-toggle="modal"
                                    data-target="#registrationTouranment">{{__('Присоединится')}}</button>
                            <div class="modal fade" id="registrationTouranment" tabindex="-1" role="dialog"
                                 aria-labelledby="authorizationModalTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content night_modal">
                                        <div class="modal-body">
                                            <h2 class="modal-body__title night_text nick_text">{{__('Введите свой ник в игре.')}}</h2>
                                            <div class="nick_form">
                                                <input class="form-control night_input" id="description" type="text"
                                                       maxlength="255"
                                                       placeholder="{{ __('nickname') }}">
                                                <div id="description_error" class="alert alert-danger d-none"
                                                     role="alert"></div>
                                                <div id="description_success" class="alert alert-success d-none"
                                                     role="alert"></div>
                                                <button id="tournamentRegister" type="submit"
                                                        class="button button__download-more"
                                                        data-rout="{{ route('tournament.register') }}"
                                                        data-id="{{$tournament->id}}">
                                                    {{__('ОТПРАВИТЬ')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container_block">
                            <div class="replay-desc-left">
                                <p class="blue">{{(__('Вы уже присоединились к турниру'))}}</p>
                            </div>
                        </div>
                    @endif
                @endif
                @if(!empty($tournament->user))
                    <div class="container_block">
                        <div class="replay-desc-right"><p>{{(__('Administrator:'))}}</p></div>
                        <div class="replay-desc-left"><p class="blue">{{$tournament->user->name}}</p></div>
                    </div>
                @endif
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Place:'))}}</p></div>
                    <div class="replay-desc-left"><p class="blue">{{$tournament->place}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Registration time:'))}}</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->created_at)->format('H:i d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Check-in time:'))}}</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->checkin_time)->format('H:i d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Start of Tourney time:'))}}</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->start_time)->format('H:i d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Prize Fond:'))}}</p></div>
                    <div class="replay-desc-left"><p>{{TourneyService::getPrizePool($tournament->prize_pool)}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Status of tourney:'))}}</p></div>
                    <div class="replay-desc-left"><p class="gray">{{$tournament::$status[$tournament->status]}}</p>
                    </div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>{{(__('Selection map:'))}}</p></div>
                    <div class="replay-desc-left">
                        <p class="blue">{{$tournament::$map_types[$tournament->map_select_type]}}</p>
                    </div>
                </div>
                @if(!empty($tournament->prize_pool) && !empty($tournament->ranking) && !empty($tournament->check_players_count))
                    <div class="container_block">
                        <div class="replay-desc-right"><p>{{(__('Importance tourney:'))}}</p></div>
                        <div class="replay-desc-left">
                            {!! TourneyService::ImpToStars($tournament->prize_pool,$tournament->ranking,$tournament->check_players_count) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 block_right">
                @if(!empty($tournament->logo_link))
                    <img class="img-fluid" src="{{asset($tournament->logo_link)}}" alt="tournament-logo">
                @else
                    <img class="img-fluid" src="{{asset('/images/tournament_detail.png')}}" alt="tournament-logo">
                @endif
                <div class="container_block">
                    <div class="left">
                        <a href="{{$tournament->rules_link}}">
                            <p class="night_text">{{(__('Rules/FAQ'))}}</p>
                        </a>
                    </div>
                    <div class="right">
                        <a href="#">
                            <span class="night_text">{{(__('Full Replay'))}}</span>
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 x="0px" y="0px"
                                 viewBox="0 0 471.2 471.2"
                                 style="enable-background:new 0 0 471.2 471.2;"
                                 xml:space="preserve">
                                                <path d="M457.7,230.1c-7.5,0-13.5,6-13.5,13.5v122.8c0,33.4-27.2,60.5-60.5,60.5H87.5C54.1,427,27,399.8,27,366.5V241.7
                                                    c0-7.5-6-13.5-13.5-13.5S0,234.2,0,241.7v124.8C0,414.8,39.3,454,87.5,454h296.2c48.3,0,87.5-39.3,87.5-87.5V243.7
                                                    C471.2,236.2,465.2,230.1,457.7,230.1z"/>
                                <path d="M226.1,346.8c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.8-85.8c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-62.7,62.8V30.8
                                                    c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v273.9l-62.8-62.8c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1L226.1,346.8z"/>
                                                </svg>
                        </a>
                    </div>
                </div>
                <div class="container_block">
                    <div class="left modal_tournament">
                        <button type="button" class="btn_modal" data-toggle="modal" data-target="#exampleModal">
                            <span class="night_text">{{(__('Maps/Prize'))}}</span>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal_width" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$tournament->name}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">{!! __('&times;') !!}</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 pl-2 small_block">
                                                    <div class=" title_block">
                                                        <div class="left_content">
                                                            <span
                                                                class="title_text_whiteModal">{{__('Приз')}}</span>
                                                        </div>
                                                    </div>

                                                    @if(!empty($tournament->prize_pool))
                                                        @foreach(TourneyService::getPrize($tournament->prize_pool) as $item)
                                                            <div class="content">
                                                                <div class="left_content">
                                                                    <span>{{ '#'.$loop->iteration }}</span>
                                                                    <svg aria-hidden="true" focusable="false"
                                                                         data-prefix="fas"
                                                                         data-icon="medal"
                                                                         class="svg-inline--fa fa-medal fa-w-16"
                                                                         role="img"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 512 512">
                                                                        <path fill="currentColor"
                                                                              d="M223.75 130.75L154.62 15.54A31.997 31.997 0 0 0 127.18 0H16.03C3.08 0-4.5 14.57 2.92 25.18l111.27 158.96c29.72-27.77 67.52-46.83 109.56-53.39zM495.97 0H384.82c-11.24 0-21.66 5.9-27.44 15.54l-69.13 115.21c42.04 6.56 79.84 25.62 109.56 53.38L509.08 25.18C516.5 14.57 508.92 0 495.97 0zM256 160c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm92.52 157.26l-37.93 36.96 8.97 52.22c1.6 9.36-8.26 16.51-16.65 12.09L256 393.88l-46.9 24.65c-8.4 4.45-18.25-2.74-16.65-12.09l8.97-52.22-37.93-36.96c-6.82-6.64-3.05-18.23 6.35-19.59l52.43-7.64 23.43-47.52c2.11-4.28 6.19-6.39 10.28-6.39 4.11 0 8.22 2.14 10.33 6.39l23.43 47.52 52.43 7.64c9.4 1.36 13.17 12.95 6.35 19.59z"></path>
                                                                    </svg>
                                                                </div>
                                                                <div class="right_content">
                                                                    <span>{{$item}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-8  big_block">
                                                    <div class=" title_block ml-1">
                                                        <div class="left_content">
                                                            <span class="title_text_whiteModal">{{__('Maps')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            @if(isset($tournament->mapsPool) && $tournament->mapsPool->isNotEmpty())
                                                                @foreach($tournament->mapsPool as $item)
                                                                    <div class="col-4 pl-1 pr-0 container_map">
                                                                        <div class="title_block_gray">
                                                                            <span class='title_text'>
                                                                                {{$item->map->name}}
                                                                            </span>
                                                                        </div>
                                                                        <div class='map'>
                                                                            @if (!empty($item->map->url) && checkFile::checkFileExists($item->map->url))
                                                                                <img src="{{asset($item->map->url)}}"
                                                                                     alt="map">
                                                                            @else
                                                                                <img alt="map"
                                                                                     src="{{asset($item->map->defaultMap())}}">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="title_players change_gray">
            <p class="title_playersText">
                {{__('Players')
                                .' | '.'Registered:'.$tournament->players_count
                                .' | '.'Check-In: '.$tournament->check_players_count
                                .' | '.'Ban: '.$tournament->ban_players_count
                }}
            </p>
        </div>
        <div class="container_players">
            @if(array_key_exists($tournament->type, $tournament::$tourneyType))
                @if(isset($tournament->playersNew) && $tournament->playersNew->isNotEmpty())
                    @include('tournament.components.show_components.players',['players' =>$tournament->playersNew])
                @endif
            @else
                @if(isset($tournament->players) && $tournament->players->isNotEmpty())
                    @include('tournament.components.show_components.players',['players' =>$tournament->players])
                @endif
            @endif
        </div>
        @if(!empty($data))
            @if(array_key_exists($tournament->type, $tournament::$tourneyType))
                @include('tournament.components.show_components.matchesNew',['data' =>$data])
            @else
                @include('tournament.components.show_components.matches',['data' =>$data])
            @endif
        @endif
    </div>
</section>
