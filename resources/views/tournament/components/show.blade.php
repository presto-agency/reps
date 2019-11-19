<section class="Page_tournamentDetail-content">

    <div class="wrapper border_shadow">
        <div class=" title_block">
            <div class="left_content">
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
                <p class="title_text">{{$tournament->name}}</p>
            </div>
        </div>

        <div class="row block_replay_content">
            <div class="col-xl-6 col-lg-6 col-md-6 block_left">
                <div class="container_block">
                    <div class="replay-desc-right"><p>Administrator:</p></div>
                    <div class="replay-desc-left"><p class="blue">{{$tournament->admin_user}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Place:</p></div>
                    <div class="replay-desc-left"><p class="blue">{{$tournament->place}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Registration time:</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->created_at)->format('h:m d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Check-in time:</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->checkin_time)->format('h:m d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Start of Tourney time:</p></div>
                    <div class="replay-desc-left">
                        <p>{{ Carbon\Carbon::parse($tournament->start_time)->format('h:m d.m.Y')}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Prize Fond:</p></div>
                    <div class="replay-desc-left"><p>{{$tournament->getPrizePool($tournament->prize_pool)}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Status of tourney:</p></div>
                    <div class="replay-desc-left"><p class="gray">{{$tournament::$status[$tournament->status]}}</p>
                    </div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Selection map:</p></div>
                    <div class="replay-desc-left"><p
                            class="blue">{{$tournament::$map_types[$tournament->map_selecttype]}}</p></div>
                </div>
                <div class="container_block">
                    <div class="replay-desc-right"><p>Importance tourney:</p></div>
                    <div class="replay-desc-left">
                        {!!  $tournament->ImpToStars($tournament->id)!!}
                    </div>
                </div>

            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 block_right">
                <img class="img-fluid" src="{{ url('/images/tournament_detail.png') }}" alt="logo">
                <div class="container_block">
                    <div class="left">
                        <a href="{{$tournament->rules_link}}">
                            <p>Rules/FAQ</p>
                        </a>
                    </div>
                    <div class="right">
                        <a href="#">
                            <span>Full Replay</span>
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 471.2 471.2" style="enable-background:new 0 0 471.2 471.2;"
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
                            <p>Maps/Prize</p>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal_width" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$tournament->name}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 pl-2 small_block">
                                                    <div class=" title_block">
                                                        <div class="left_content">
                                                            <span
                                                                class="title_text">{{__('Приз')}}</span>
                                                        </div>
                                                    </div>
                                                    @isset($prizeList)
                                                        @foreach($prizeList as $prize)
                                                            <div class="content">
                                                                <div class="left_content">
                                                                    <span>#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
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
                                                                    <span>{{$prize}}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-8 pl-2  big_block">
                                                    <div class=" title_block ml-1">
                                                        <div class="left_content">
                                                            <span class="title_text">Maps</span>
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            @isset($dataArr['maps'])
                                                                @foreach($dataArr['maps'] as $map)
                                                                    <div class="col-xl-4 pl-1 pr-0 container_map">
                                                                        <div class="title_block_gray">
                                                                            {!! App\Models\TourneyMatch::getTourneyMap($map['name'])['title'] !!}
                                                                        </div>
                                                                        {!! App\Models\TourneyMatch::getTourneyMap($map['name'])['url'] !!}
                                                                    </div>
                                                                @endforeach
                                                            @endisset
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
                    <div class="right">
                        <a href="{{$tournament->rules_link}}">
                            <span class="gray">Rules/FAQ</span>
                            <svg class="svg_gray" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 471.2 471.2" style="enable-background:new 0 0 471.2 471.2;"
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
            </div>
        </div>
        <div class="title_players">
            <p class="title_playersText">Players</p>
        </div>
        <div class="container_players">
            @isset($tournament->players)
                @foreach($tournament->players as $player)
                    @isset($player->user)
                        <div class="players_content">
                            <div class="left_block">
                                <span>#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                                <a href="{{route('user_profile',['id'=>$player->user->id])}}">
                                    @auth()
                                        @if(auth()->user()->userViewAvatars())
                                            @if(!empty($player->user->avatar) && file_exists($player->user->avatar))
                                                <img src="{{asset($player->user->avatar)}}"
                                                     class="author__avatar img-fluid"
                                                     alt="avatar" title="{{$player->user->name}}">
                                            @else
                                                <img src="{{asset($player->user->defaultAvatar())}}"
                                                     class="author__avatar img-fluid" alt="avatar">
                                            @endif
                                        @endif
                                    @else
                                        @if(!empty($player->user->avatar) && file_exists($player->user->avatar))
                                            <img src="{{asset($player->user->avatar)}}" class="author__avatar img-fluid"
                                                 alt="avatar" title="{{$player->user->name}}">
                                        @else
                                            <img src="{{asset($player->user->defaultAvatar())}}"
                                                 class="author__avatar img-fluid" alt="avatar">
                                        @endif
                                    @endauth
                                    <span class="name_player"
                                          title="{{$player->user->name}}">{{$player->user->name}}</span>
                                </a>
                            </div>
                            <div class="center_block">
                                @isset($player->user->countries)
                                    <img src="{{asset($player->user->countries->flag)}}" class="info__flag" alt="flag"
                                         title="{{$player->user->countries->name}}">
                                @endisset
                                @isset($player->user->races)
                                    <img
                                        src="{{asset("images/default/game-races/" . $player->user->races->title . ".png")}}"
                                        class="info__cube" alt="game"
                                        title="{{$player->user->races->title}}">
                                @endisset
                            </div>
                            <div class="right_block">
                                <p>{{$player->place_result}}</p>
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="medal"
                                     class="svg-inline--fa fa-medal fa-w-16" role="img"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M223.75 130.75L154.62 15.54A31.997 31.997 0 0 0 127.18 0H16.03C3.08 0-4.5 14.57 2.92 25.18l111.27 158.96c29.72-27.77 67.52-46.83 109.56-53.39zM495.97 0H384.82c-11.24 0-21.66 5.9-27.44 15.54l-69.13 115.21c42.04 6.56 79.84 25.62 109.56 53.38L509.08 25.18C516.5 14.57 508.92 0 495.97 0zM256 160c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm92.52 157.26l-37.93 36.96 8.97 52.22c1.6 9.36-8.26 16.51-16.65 12.09L256 393.88l-46.9 24.65c-8.4 4.45-18.25-2.74-16.65-12.09l8.97-52.22-37.93-36.96c-6.82-6.64-3.05-18.23 6.35-19.59l52.43-7.64 23.43-47.52c2.11-4.28 6.19-6.39 10.28-6.39 4.11 0 8.22 2.14 10.33 6.39l23.43 47.52 52.43 7.64c9.4 1.36 13.17 12.95 6.35 19.59z"></path>
                                </svg>
                            </div>
                        </div>
                    @endisset
                @endforeach
            @endif
        </div>
        @isset($dataArr['round'])
            @foreach($dataArr['round'] as $key => $round)
                <div class="title_players">
                    <p class="title_playersText">{{$round}}</p>
                    {!! App\Models\TourneyMatch::getTourneyRoundMap($tournament->id, $key) !!}
                </div>
                @isset($dataArr['matches'])
                    @foreach($dataArr['matches'][$key] as $match )
                        <div class="container_round">
                            <div class="row winner_round">
                                <div class="col-xl-1 col-lg-1 col-md-1 col-1  left_block">
                                    <span>#{{ $loop->iteration }} {{-- Starts with 1 --}}</span>
                                </div>
                                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-8 col-7 center_block">
                                    @isset($match->player1->user)
                                        <div class="one_player">
                                            @auth()
                                                @if(auth()->user()->userViewAvatars())
                                                    @if(!empty($match->player1->user->avatar) && file_exists($match->player1->user->avatar))
                                                        <img class="icon_bars"
                                                             src="{{asset($match->player1->user->avatar)}}">
                                                    @else
                                                        <img class="icon_bars"
                                                             src="{{asset($match->player1->user->defaultAvatar())}}">
                                                    @endif
                                                @endif
                                            @else
                                                @if(!empty($match->player1->user->avatar) && file_exists($match->player1->user->avatar))
                                                    <img class="icon_bars"
                                                         src="{{asset($match->player1->user->avatar)}}">
                                                @else
                                                    <img class="icon_bars"
                                                         src="{{asset($match->player1->user->defaultAvatar())}}">
                                                @endif
                                            @endauth
                                            <span>{{$match->player1->user->name}}</span>
                                        </div>
                                    @else
                                        {{__('- Freeslot -')}}
                                    @endisset
                                    @if($match->player1_score > $match->player2_score)
                                        <span
                                            class="blue_span">{{$match->player1_score.' > ' .$match->player2_score}}</span>
                                    @else
                                        <span
                                            class="blue_span">{{$match->player1_score.' < ' .$match->player2_score}}</span>

                                    @endif
                                    @isset($match->player2->user)
                                        <div class="one_player">
                                            @auth()
                                                @if(auth()->user()->userViewAvatars())
                                                    @if(!empty($match->player2->user->avatar) && file_exists($match->player2->user->avatar))
                                                        <img class="icon_bars"
                                                             src="{{asset($match->player2->user->avatar)}}">
                                                    @else
                                                        <img class="icon_bars"
                                                             src="{{asset($match->player2->user->defaultAvatar())}}">
                                                    @endif
                                                @endif
                                            @else
                                                @if(!empty($match->player2->user->avatar) && file_exists($match->player2->user->avatar))
                                                    <img class="icon_bars"
                                                         src="{{asset($match->player2->user->avatar)}}">
                                                @else
                                                    <img class="icon_bars"
                                                         src="{{asset($match->player2->user->defaultAvatar())}}">
                                                @endif
                                            @endauth
                                            <span>{{$match->player2->user->name}}</span>
                                        </div>
                                    @else
                                        {{__('- Freeslot -')}}
                                    @endisset
                                </div>
                                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-3 col-4 right_block">
                                    @for($i = 1; $i <= 7; $i++)
                                        @if(!empty($match->{"rep$i"}))
                                            <a href="{{ $match->{"rep$i"} }}">{{"rep$i"}}</a>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            @endforeach
        @endisset
    </div>
</section>
