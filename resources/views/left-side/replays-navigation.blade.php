<div class="replays border_shadow">
    <div class="replays__title">
        <svg class="title__icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
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
        <p class="title__text">Реплеи</p>
    </div>
    <div class="replays__accordion accordion" id="replaysAccordion">
        @if($pro)
            <div class="accordion__topic card night_modal ">
                <div class="topic__header card-header change_gray">
                    <a class="header__title night_text">
                        {{$replayTypeName}}
                    </a>
                </div>
            </div>
            <div class="accordion__topic card night_modal">
                <div class="topic__header card-header change_gray">
                    <a class="header__title night_text" href="{{route('replay_pro.index')}}">
                        Профессиональные реплеи
                    </a>
                </div>
                @isset($replayTypes)
                    @foreach($replayTypes as $replayTitle => $replayName)
                        <div class="topic__body">
                            <div class="card-body">
                                <div class="subtopic__topic card night_modal border_shadow">
                                    <div class="subtopic__header card-header change_gray">
                                        <a class="header__title night_text"
                                           href="{{route("replay_pro.type.index",['type'=>$replayName])}}">
                                            {{$replayTitle}}
                                        </a>
                                    </div>
                                    <div class="subtopic__body">
                                        <div class="card-body">
                                            @isset($replayNav)
                                                @foreach($replayNav as $replayNavitem)
                                                    @if($replayNavitem['types']['name'] == $replayName)
                                                        <div class="body__wrap">
                                                            <a href="{{route('replay_pro.type.show',['type' =>$replayName, 'replay_pro'=>$replayNavitem['id']])}}"
                                                               class="body__title night_text">{{$replayNavitem['title']}}</a>
                                                            <span
                                                                class="body__numb">{{$replayNavitem['positive_count'] - $replayNavitem['negative_count']}}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        @else
            <div class="accordion__topic card night_modal">
                <div class="topic__header card-header change_gray">
                    <a class="header__title night_text">
                        {{$replayTypeName}}
                    </a>
                </div>
                <div class="topic__header card-header change_gray">
                    <a class="header__title night_text" href="{{route('replay.index')}}">
                        Пользовательские реплеи
                    </a>
                </div>
                @isset($replayNav)
                    @foreach($replayNav as $replayNavitem)
                        <div class="topic__body">
                            <div class="card-body">
                                <div class="body__wrap">
                                    <a href="{{route('replay.show',['replay' => $replayNavitem['id']])}}"
                                       class="body__title night_text">{{$replayNavitem['title']}}</a>
                                    <span
                                        class="body__numb">{{$replayNavitem['positive_count'] - $replayNavitem['negative_count']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        @endif
    </div>
</div>
