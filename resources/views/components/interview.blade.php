<div class="vote border_shadow">
    <div class="vote__title">
        <svg class="title__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px"
             y="0px"
             viewBox="0 0 227 227" xml:space="preserve">
            <path d="M224.2,67.3c-2.9-5.4-7.8-9.4-13.7-11.2c-5.9-1.8-12.1-1.2-17.6,1.7c-5.4,2.9-9.4,7.8-11.2,13.7c-1.2,3.9-1.3,8-0.4,11.9
                l-24.9,13.3c-7.6-10.6-19.4-18-32.9-19.8V55.7c9.8-2.6,17.1-11.6,17.1-22.3c0-12.7-10.3-23.1-23.1-23.1S94.5,20.7,94.5,33.4
                c0,10.6,7.2,19.6,17.1,22.3v21.3c-17.3,2.2-31.8,13.7-38.2,29.3l-27.3-7.3c0-4-1-7.9-3.1-11.5c-3.1-5.3-8-9.2-14-10.8
                c-12.3-3.3-25,4-28.3,16.3C-0.8,98.8,0,105,3.1,110.4s8,9.2,14,10.8c2,0.5,4,0.8,6,0.8c4,0,7.9-1,11.5-3.1c3.6-2,6.4-4.9,8.4-8.4
                l27.3,7.3c-0.3,2.1-0.5,4.3-0.5,6.5c0,11,3.8,21.2,10,29.3l-20,20c-8.8-5.1-20.3-3.9-27.8,3.7c-9,9-9,23.6,0,32.6
                c4.5,4.5,10.4,6.7,16.3,6.7c5.9,0,11.8-2.2,16.3-6.7c7.5-7.5,8.7-19,3.7-27.8l20-20c8.1,6.3,18.2,10,29.3,10s21.2-3.8,29.3-10
                l20,20c-5.1,8.8-3.9,20.3,3.7,27.8c4.5,4.5,10.4,6.7,16.3,6.7s11.8-2.2,16.3-6.7c9-9,9-23.6,0-32.6c-7.5-7.5-19-8.7-27.8-3.7
                l-20-20c6.3-8.1,10-18.2,10-29.3c0-6-1.1-11.8-3.2-17.1l24.9-13.3c2.7,2.9,6.2,5.1,10.1,6.3c2.2,0.7,4.5,1,6.7,1
                c3.7,0,7.5-0.9,10.9-2.7c5.4-2.9,9.4-7.8,11.2-13.7S227.2,72.7,224.2,67.3L224.2,67.3z M209.1,87.9c-2.6,1.4-5.6,1.7-8.4,0.8
                c-2.8-0.9-5.2-2.8-6.6-5.4c-1.4-2.6-1.7-5.6-0.8-8.4c0.9-2.8,2.8-5.2,5.4-6.6c1.6-0.9,3.4-1.3,5.2-1.3c1.1,0,2.2,0.2,3.2,0.5
                c2.8,0.9,5.2,2.8,6.6,5.4c1.4,2.6,1.7,5.6,0.8,8.4C213.6,84.2,211.7,86.5,209.1,87.9z M153.4,124.4c0,19.7-16.1,35.8-35.8,35.8
                s-35.8-16.1-35.8-35.8s16.1-35.8,35.8-35.8S153.4,104.6,153.4,124.4z M106.5,33.4c0-6.1,5-11.1,11.1-11.1s11.1,5,11.1,11.1
                s-5,11.1-11.1,11.1S106.5,39.5,106.5,33.4z M20.2,109.6c-2.9-0.8-5.2-2.6-6.7-5.2c-1.5-2.6-1.9-5.5-1.1-8.4
                c1.6-5.9,7.7-9.4,13.6-7.8c2.9,0.8,5.2,2.6,6.7,5.2c1.5,2.6,1.9,5.5,1.1,8.4C32.2,107.7,26.1,111.2,20.2,109.6z M56.2,201.4
                c-4.3,4.3-11.3,4.3-15.6,0c-4.3-4.3-4.3-11.3,0-15.6c2.2-2.2,5-3.2,7.8-3.2c2.8,0,5.7,1.1,7.8,3.2
                C60.5,190.1,60.5,197.1,56.2,201.4z M194.7,185.8c4.3,4.3,4.3,11.3,0,15.6c-4.3,4.3-11.3,4.3-15.6,0c-4.3-4.3-4.3-11.3,0-15.6
                c2.2-2.2,5-3.2,7.8-3.2C189.7,182.5,192.5,183.6,194.7,185.8z"/>
        </svg>

        <p class="title__text">{{__('Голосование')}}</p>
    </div>
    @if(!$votes->isEmpty())
        @foreach($votes as $item)

            @if($item->for_login && auth()->user())
                <div class="vote__content">
                    <div class="content__header change_gray">
                        <p class="header__title night_text">{{$item->question}}</p>
                    </div>
                    <div class="content__body">
                        @auth
                            @if(isset($item->users) && $item->users->isEmpty())
                                <form class="vote-form" id="vote-form" action="{{ route('interview.store')}}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @if(isset($item->answers) && !$item->answers->isEmpty())
                                        @foreach($item->answers as $answer)
                                            <div class="form-check night_text">
                                                <input class="form-check-input" type="radio" name="answer_id"
                                                       id="{{$answer->id}}"
                                                       value="{{$answer->id}}"
                                                       checked>
                                                <input class="form-check-input" type="hidden" name="question_id"
                                                       id="{{$answer->question_id}}"
                                                       value="{{$answer->question_id}}">
                                                <label class="form-check-label night_text" for="{{$answer->id}}">
                                                    {{$answer->answer}}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="body__button-vote">
                                        <button class="button button__download-more">
                                            {{__('Проголосовать')}}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endauth
                        <div class="view-results" id="view-results">
                            @if(isset($item->answers) && !$item->answers->isEmpty())
                                @foreach($item->answers as $answer)
                                    <div class="results">
                                        <span class="night_text">{{$answer->answer}}</span>
                                        <span class="night_text">({{$answer->users_count}})</span>
                                    </div>
                                @endforeach
                            @endif
                            <div class="result__total">
                                <span class="night_text">Total votes: {{$item->user_answers_count}}</span>
                            </div>
                        </div>
                        <div id="view-results__1" class="body__view-results js-body__view-results">
                            <button class="view-results__button night_text">
                                {{__('Посмотреть результаты')}}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @if($item->for_login == 0)
                <div class="vote__content">
                    <div class="content__header change_gray">
                        <p class="header__title night_text">{{$item->question}}</p>
                    </div>
                    <div class="content__body">
                        @auth
                            @if(isset($item->users) && $item->users->isEmpty())
                                <form class="vote-form" id="vote-form" action="{{ route('interview.store')}}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @if(isset($item->answers) && !$item->answers->isEmpty())
                                        @foreach($item->answers as $answer)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="answer_id"
                                                       id="{{$answer->id}}"
                                                       value="{{$answer->id}}"
                                                       checked>
                                                <input class="form-check-input" type="hidden" name="question_id"
                                                       id="{{$answer->question_id}}"
                                                       value="{{$answer->question_id}}">
                                                <label class="form-check-label" for="{{$answer->id}}">
                                                    {{$answer->answer}}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="body__button-vote">
                                        <button class="button button__download-more">
                                            {{__('Проголосовать')}}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endauth
                        <div class="view-results" id="view-results">
                            @if(isset($item->answers) && !$item->answers->isEmpty())
                                @foreach($item->answers as $answer)
                                    <div class="results">
                                        <span class="night_text">{{$answer->answer}}</span>
                                        <span class="night_text">({{$answer->users_count}})</span>
                                    </div>
                                @endforeach
                            @endif
                            <div class="result__total">
                                <span class="night_text">Total votes: {{$item->user_answers_count}}</span>
                            </div>
                        </div>
                        <div id="view-results__1" class="body__view-results js-body__view-results">
                            <button class="view-results__button night_text">
                                {{__('Посмотреть результаты')}}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
