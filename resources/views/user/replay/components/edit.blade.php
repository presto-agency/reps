<div class="create-replay border_shadow">
    <div class="create-replay__title">
        <svg class="title__icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
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
        <p class="title__text">{{__('Редактировать Replay')}}</p>
    </div>
    <div class="create-replay__body night_modal">
        <form class="create-replay__form" id="replay-edit" method="POST" enctype="multipart/form-data"
              action="{{ route('user-replay.update',['id' => $userReplayEdit->user_id,'user_replay'=>$userReplayEdit->id]) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="create-replay-name" class="night_text">{{__('* Название:')}}</label>
                <input type="text" class="form-control night_input" id="create-replay-name"
                       name="title" required maxlength="255" placeholder="{{__('Название')}}"
                       value="{{ clean(old('title',$userReplayEdit->title))}}">
            </div>
            @error('title')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="row">
                @if(isset($replayTypes) && $replayTypes->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__type" class="night_text">{{__('* Подтип:')}}
                                <select name="subtype" id="create-replay__type night_input"
                                        class="create-replay__type night_input">
                                    @foreach($replayTypes as $item)
                                        <option
                                            {{ old('subtype',$userReplayEdit->type_id) == $item->id ?  'selected': ''}}
                                            value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('subtype')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                @if(isset($replayTypes2) && $replayTypes2->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__type" class="night_text">{{__('* Тип:')}}
                                <select name="type" id="create-replay__type night_input"
                                        class="create-replay__type night_input">
                                    @foreach ($replayTypes2 as $key => $item)
                                        <option value="{{$key}}"
                                            {{ old('type',$userReplayEdit->user_replay) == (string)$key ?  'selected': ''}}
                                        >{{$item}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('type')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            @if(isset($maps) && $maps->isNotEmpty())
                <div class="form-group">
                    <label for="create-replay__map" class="night_text">{{__('* Карта:')}}
                        <select name="map" class="js-example-basic-single night_input" id="create-replay__map">
                            @foreach($maps as $item)
                                <option value="{{$item->id}}"
                                    {{ old('map',$userReplayEdit->map_id) == $item->id ? 'selected':''}}>
                                    {{$item->name}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            @endif
            @error('map')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <hr>
            <div class="row">
                @if(isset($race) && $race->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__first-race" class="night_text">{{__('* Первая раса:')}}
                                <select name="first_race" id="create-replay__first-race"
                                        class="create-replay__first-race night_input">
                                    @foreach($race as $item)
                                        <option value="{{$item->id}}"
                                            {{ old('first_race',$userReplayEdit->first_race) == $item->id ? 'selected':''}}>
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('first_race')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                @if(isset($countries) && $countries->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__first-country" class="night_text">{{__('* Первая страна:')}}
                                <select name="first_country" class="js-example-basic-single night_input"
                                        id="create-replay__first-country">
                                    @foreach($countries as $item)
                                        <option
                                            value="{{$item->id}}"{{ old('first_country',$userReplayEdit->first_country_id) == $item->id ? 'selected':''}}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('first_country')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="col-md-6 form-group">
                    <label for="create-replay__second-location" class="night_text">{{__('Первая локация:')}}</label>
                    <input type="number" min="1" max="20" name="first_location" class="form-control night_input"
                           id="create-replay__second-location" placeholder="{{__('Первая локация:')}}"
                           value="{{old('first_location',$userReplayEdit->first_location)}}"
                    >
                </div>
                @error('first_location')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="col-md-6 form-group">
                    <label for="create-replay__second-location" class="night_text">{{__('Вторая локация:')}}</label>
                    <input type="number" min="1" max="20" name="second_location" class="form-control night_input"
                           id="create-replay__second-location" placeholder="{{__('Вторая локация')}}"
                           value="{{old('second_location',$userReplayEdit->second_location)}}"
                    >
                </div>
                @error('second_location')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <hr>
            <div class="row">
                @if(isset($race) && $race->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__first-race" class="night_text">{{__('* Вторая раса:')}}
                                <select name="second_race" id="create-replay__first-race"
                                        class="create-replay__first-race night_input">
                                    @foreach($race as $item)
                                        <option value="{{$item->id}}"
                                            {{ old('second_race',$userReplayEdit->second_race) == $item->id ? 'selected':''}}>
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('second_race')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                @if(isset($countries) && $countries->isNotEmpty())
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="create-replay__first-country" class="night_text">{{__('* Вторая страна:')}}
                                <select name="second_country" class="js-example-basic-single"
                                        id="create-replay__first-country">
                                    @foreach($countries as $item)
                                        <option value="{{$item->id}}"
                                            {{ old('second_country',$userReplayEdit->second_country_id) == $item->id ? 'selected':''}}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                @error('second_country')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <hr>
            <div class="form-group">
                <label for="preview_content" class="night_text">{{__('Краткое описание')}}</label>
                <textarea name="short_description" class="form-control night_input"
                          id="preview_content">{{ clean(old('short_description',$userReplayEdit->content)) }}</textarea>
                <script>
                    CKEDITOR.replace('preview_content', {});
                </script>
            </div>
            @error('short_description')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-group">
                <label for="video_iframe_url" class="night_text">{{__('Вставить URL для Video Iframe')}}</label>
                <input id="video_iframe_url" name="video_iframe_url" class="form-control night_input" maxlength="500"
                       placeholder="{{__('Вставить URL для Video Iframe')}}"
                       data-url="{{route('set.iframe')}}"
                       value="{{old('video_iframe_url')}}">
                <input name="src_iframe" type="hidden" id="src_iframe" tabindex="-1" readonly value=""
                       data-src="{{ $userReplayEdit->src_iframe }}">
            </div>
            <iframe id="video_iframe_set" class="d-none" src="" width="100%" height="340" frameborder="0" scrolling="no"
                    allowfullscreen></iframe>
            <div id="video_iframe_error" class="alert alert-danger d-none"></div>
            @error('src_iframe')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="row gallery-file__container upload-image">
                <div class="col-8">
                    <input id="uploadFile" class="f-input night_text night_input" type="text" value=""
                           readonly placeholder="{{__('Файл')}}"/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>{{__('Выбрать файл')}}</span>
                        <input id="uploadBtn" name="file" type="file" class="upload"/>
                    </div>
                </div>
            </div>
            @error('file')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            @if((!empty($userReplayEdit->file) && checkFile::checkFileExists($userReplayEdit->file)))
                <div class="replay-download">
                    <a href="{{route('replay.download',['id' =>$userReplayEdit->id])}}">
                    <span class="downloaded" data-id="{{$userReplayEdit->id}}"
                          data-url="{{route('replay.increment.downloaded',['id'=>$userReplayEdit->id])}}"
                          title="{{basename($userReplayEdit->file)}}">{{__('Скачать')}}</span>
                    </a>
                </div>
            @endif
            <div class="create-replay__button">
                <button class="button button__download-more">
                    {{__('Отправить')}}
                </button>
            </div>
        </form>
    </div>
</div>
@section('custom-script')
    {{--    @parent--}}
    <script type="text/javascript" src="{{mix('js/replay_iframe_edit.js')}}" defer></script>

    {{--    <script type="text/javascript" defer>--}}
    {{--        $(document).ready(function () {--}}
    {{--            if ($('#video_iframe_url').val()) {--}}

    {{--                if (localStorage.success === 'true') {--}}
    {{--                    updateDataIfSuccess()--}}
    {{--                }--}}
    {{--                if (localStorage.success === 'false') {--}}
    {{--                    updateDataIfError()--}}
    {{--                }--}}
    {{--                if (localStorage.success !== 'false' && localStorage.success !== 'true') {--}}
    {{--                    refreshAllData();--}}
    {{--                }--}}
    {{--            } else {--}}

    {{--                if ($('#src_iframe').data('src')) {--}}
    {{--                    $('#video_iframe_set').removeClass('d-none').attr('src', $('#src_iframe').data('src'));--}}
    {{--                } else {--}}
    {{--                    refreshAllData();--}}
    {{--                }--}}
    {{--            }--}}
    {{--        });--}}

    {{--        //setup before functions--}}
    {{--        let typingTimer;                //timer identifier--}}
    {{--        let doneTypingInterval = 1500;  //time in ms (1.5 seconds)--}}
    {{--        //on keyup, start the countdown--}}
    {{--        $('#video_iframe_url').keyup(function () {--}}
    {{--            clearTimeout(typingTimer);--}}
    {{--            if ($('#video_iframe_url').val()) {--}}
    {{--                typingTimer = setTimeout(doneTyping, doneTypingInterval);--}}
    {{--            } else {--}}
    {{--                refreshAllData();--}}
    {{--            }--}}
    {{--        });--}}

    {{--        //user is "finished typing," do something--}}
    {{--        function doneTyping() {--}}
    {{--            const token = $('meta[name="csrf-token"]').attr('content');--}}
    {{--            let video_iframe_url = $('#video_iframe_url').val();--}}
    {{--            let url = $('#video_iframe_url').data('url');--}}
    {{--            sendAjax(token, video_iframe_url, url)--}}
    {{--        }--}}

    {{--        function sendAjax(token, video_iframe_url, url) {--}}
    {{--            $.ajax({--}}
    {{--                url: url,--}}
    {{--                method: 'POST',--}}
    {{--                data: {--}}
    {{--                    _token: token,--}}
    {{--                    video_iframe_url: video_iframe_url,--}}
    {{--                },--}}
    {{--                success: function (data) {--}}
    {{--                    updateLocalStorage(data.success, data.message);--}}
    {{--                    updateDataIfSuccess()--}}
    {{--                },--}}
    {{--                error: function (data) {--}}
    {{--                    updateLocalStorage(data.responseJSON.success, data.responseJSON.message);--}}
    {{--                    updateDataIfError();--}}
    {{--                }--}}
    {{--            });--}}
    {{--        }--}}

    {{--        function updateDataIfSuccess() {--}}
    {{--            $('#src_iframe').val(localStorage.message);--}}
    {{--            $('#video_iframe_set').removeClass('d-none').attr('src', localStorage.message);--}}
    {{--            $("#video_iframe_error").addClass('d-none').html('');--}}
    {{--        }--}}

    {{--        function updateDataIfError() {--}}
    {{--            $('#src_iframe').val('');--}}
    {{--            $('#video_iframe_set').addClass('d-none').attr('src', '');--}}
    {{--            $("#video_iframe_error").removeClass('d-none').html(localStorage.message);--}}
    {{--        }--}}

    {{--        function updateLocalStorage(success, message) {--}}
    {{--            delete localStorage.success;--}}
    {{--            delete localStorage.message;--}}
    {{--            localStorage.success = success;--}}
    {{--            localStorage.message = message;--}}
    {{--        }--}}

    {{--        function refreshAllData() {--}}
    {{--            delete localStorage.success;--}}
    {{--            delete localStorage.message;--}}
    {{--            $('#src_iframe').val('');--}}
    {{--            $('#video_iframe_set').addClass('d-none').attr('src', '');--}}
    {{--            $("#video_iframe_error").addClass('d-none').html('');--}}
    {{--        }--}}

    {{--        /*** file ***/--}}
    {{--        $('#replay-edit').submit(function () {--}}
    {{--            if ($('#uploadBtn').val() === '') {--}}
    {{--                $('input[name="file"]').prop('disabled', true);--}}
    {{--            }--}}
    {{--            if ($('#src_iframe').val() === '') {--}}
    {{--                $('input[name="src_iframe"]').prop('disabled', true);--}}
    {{--            }--}}
    {{--        });--}}

    {{--        /**--}}
    {{--         * Replay File download--}}
    {{--         */--}}
    {{--        $('.downloaded').click(function () {--}}
    {{--            let id = $(this).data('id');--}}
    {{--            $.ajax({--}}
    {{--                method: 'POST',--}}
    {{--                url: $(this).data('url'),--}}
    {{--                data: {--}}
    {{--                    _token: '{{csrf_token()}}',--}}
    {{--                    id: id,--}}
    {{--                },--}}
    {{--                success: function (data) {--}}
    {{--                },--}}
    {{--                error: function (data) {--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

@endsection



