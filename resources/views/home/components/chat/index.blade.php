@foreach($headlineData as $item)
    <div class="text_support night_text">
        {!! $item['title']!!}
    </div>
@endforeach
<section id="block_chat-twitch" class="block_chat-twitch theatre-off">
    <div class="row main_row">
        <div class="col-12 main_container">
            <div id="appchat"><chat-room :auth="{{ Auth::check() ? Auth::user() : 0 }}" :not_user="{{ Auth::check() ? auth()->user()->isNotUser() : 0}}"/></div>
            <div class="block_stream_list">
                <div class="title_video ">
                    @include('home.components.chat.components.streams-list')
                    <div class="video_header">
                        <div class="left_block">
                            <button class="big_video_right">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left"
                                     class="svg_left svg-inline--fa fa-chevron-left fa-w-10" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path
                                        d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                                </svg>
                            </button>
                            <button class="big_video_left">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right"
                                     class="svg_right svg-inline--fa fa-chevron-right fa-w-10" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path
                                        d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                                </svg>
                            </button>

                                <img class="icon_bars" id="streamOnlineFlag"
                                     src="@isset($stream){{asset($stream->countries->flag)}}@endisset"
                                     title="@isset($stream){{$stream->countries->name}}@endisset" alt="flag"/>
                                <img class="icon_bars" id="streamOnlineRace"
                                     src="@isset($stream){{asset('images/default/game-races/'.$stream->races->title.'.png')}}@endisset"
                                     title="@isset($stream){{$stream->races->title}}@endisset" alt="race"/>
                                <p class="title_text" id="streamOnlineName"
                                   title="@isset($stream){{$stream->title}}@endisset">@isset($stream){{$stream->title}}@endisset</p>
                        </div>
                        <div class="right_block">
                            <button id="btn_theatre_mode" class="btn_theatre_mode">
                                <svg viewBox="0 0 59 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="8" y="12" width="42" height="31" stroke="white" stroke-width="2"/>
                                    <line x1="37" y1="43" x2="37" y2="11" stroke="white" stroke-width="2"/>
                                </svg>
                            </button>
                            <button class="btn_streams_list">
                                <svg class="svg_stream" viewBox="0 0 59 55" fill="white"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <line x1="12" y1="16" x2="47" y2="16" stroke="white" stroke-width="2"/>
                                    <line x1="12" y1="27" x2="47" y2="27" stroke="white" stroke-width="2"/>
                                    <line x1="12" y1="38" x2="47" y2="38" stroke="white" stroke-width="2"/>
                                </svg>
                            </button>
                            <button class="btn_streams_close">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times"
                                     class=" svg_close svg-inline--fa fa-times fa-w-11" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
                                    <path fill="white"
                                          d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="video_twitch">
                    <iframe id="streamOnline" style="width: 99%; height: 100%;" allowfullscreen="true" scrolling="no"
                            autoplay="1" frameborder="0" src="@isset($stream){{$stream->stream_url_iframe}}@endisset"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>





