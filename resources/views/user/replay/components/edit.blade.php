<div class="create-replay border_shadow">
    <div class="create-replay__title">
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
        <p class="title__text">Редактировать Replay</p>
    </div>
    <div class="create-replay__body night_modal">
        <form class="create-replay__form"
              action="{{ route('user-replay.update',['id' => $replay->user_id,'user_replay'=>$replay->id]) }}"
              method="POST"
              enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="create-replay-name" class="night_text">* Название:</label>
                <input type="text" class="form-control night_input" id="create-replay-name" placeholder="Название"
                       name="title" value="{{ old("title", ParserToHTML::toHTML($replay->title,'size'))}}" required minlength="1" maxlength="255">
            </div>
            @if ($errors->has('title'))
                <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__type" class="night_text">* Тип:
                            <select name="type_id" id="create-replay__type night_input"
                                    class="create-replay__type night_input">
                                @isset($types)
                                    @foreach ($types as $item)
                                        <option value="{{$item->id}}"
                                                {{ old('type_id',$replay->type_id) == $item->id ? "selected":""}}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('type_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('type_id') }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__type" class="night_text">* Тип2:
                            <select name="user_replay" id="create-replay__type night_input"
                                    class="create-replay__type night_input">
                                @isset($userReplay)
                                    @foreach ($userReplay as $key => $item)
                                        <option value="{{$key}}"
                                                {{ old('user_replay',$replay->user_replay) == $key ? "selected":""}}>
                                            {{$item}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('user_replay'))
                    <div class="alert alert-danger">
                        {{ $errors->first('user_replay') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="create-replay__map" class="night_text">* Карта:
                    <select name="map_id" class="js-example-basic-single night_input" id="create-replay__map">
                        @isset($maps)
                            @foreach($maps as $item)
                                <option value="{{$item->id}}"
                                        {{ old('type_id',$replay->map_id) == $item->id ? "selected":""}}>
                                    {{$item->name}}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </label>
            </div>
            @if ($errors->has('map_id'))
                <div class="alert alert-danger">
                    {{ $errors->first('map_id') }}
                </div>
            @endif
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-race" class="night_text">* Первая раса:
                            <select name="first_race" id="create-replay__first-race"
                                    class="create-replay__first-race night_input">
                                @isset($races)
                                    @foreach($races as $item)
                                        <option value="{{$item->id}}"
                                                {{ old('first_race',$replay->first_race) == $item->id ? "selected":""}}>
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('first_race'))
                    <div class="alert alert-danger">
                        {{ $errors->first('first_race') }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-country" class="night_text">* Первая страна:
                            <select name="first_country_id" class="js-example-basic-single night_input"
                                    id="create-replay__first-country">
                                @isset($countries)
                                    @foreach($countries as $item)
                                        <option value="{{$item->id}}"
                                                {{ old('first_country_id',$replay->first_country_id) == $item->id ? "selected":""}}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('first_country_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('first_country_id') }}
                    </div>
                @endif
                <div class="col-md-6 form-group">
                    <label for="create-replay__second-location" class="night_text">Первая локация:</label>
                    <input type="text" name="first_location" class="form-control night_input"
                           id="create-replay__second-location" minlength="1"
                           maxlength="255" value="{{old('first_location',$replay->first_location)}}"
                           placeholder="Первая локация">
                </div>
                @if ($errors->has('first_location'))
                    <div class="alert alert-danger">
                        {{ $errors->first('first_location') }}
                    </div>
                @endif
                <div class="col-md-6 form-group">
                    <label for="create-replay__second-location" class="night_text">Вторая локация:</label>
                    <input type="text" name="second_location" class="form-control night_input"
                           id="create-replay__second-location" minlength="1"
                           maxlength="255" value="{{old('second_location',$replay->second_location)}}"
                           placeholder="Вторая локация">
                </div>
                @if ($errors->has('second_location'))
                    <div class="alert alert-danger">
                        {{ $errors->first('second_location') }}
                    </div>
                @endif
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-race" class="night_text">* Вторая раса:
                            <select name="second_race" id="create-replay__first-race"
                                    class="create-replay__first-race night_input">
                                @isset($races)
                                    @foreach($races as $item)
                                        <option value="{{$item->id}}"
                                                {{ old('second_race',$replay->second_race) == $item->id ? "selected":""}}>
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('second_race'))
                    <div class="alert alert-danger">
                        {{ $errors->first('second_race') }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-country" class="night_text">* Вторая страна:
                            <select name="second_country_id" class="js-example-basic-single"
                                    id="create-replay__first-country">
                                @isset($countries)
                                    @foreach($countries as $item)
                                        <option value="{{$item->id}}"
                                                {{ old('second_country_id',$replay->second_country_id) == $item->id ? "selected":""}}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('second_country_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('second_country_id') }}
                    </div>
                @endif
            </div>
            <hr>
            <div class="form-group">
                <label for="content" class="night_text">Краткое описание</label>
                <textarea name="content" class="form-control night_input"
                          id="content">{!! old('content',ParserToHTML::toHTML($replay->content,'size')) !!}</textarea>
            </div>
            @if ($errors->has('content'))
                <div class="alert alert-danger">
                    {{ $errors->first('content') }}
                </div>
            @endif

            <div class="form-group">
                <label for="video_iframe" class="night_text">Вставить HTML код с видео реплеем</label>
                <textarea name="video_iframe" class="form-control night_input"
                          id="video_iframe">{{old('video_iframe',$replay->video_iframe)}}</textarea>
                <script>
                    CKEDITOR.replace('video_iframe', {
                        // Define the toolbar groups as it is a more accessible solution.
                        extraPlugins: 'autoembed',
                        toolbarGroups: [
                            {name: 'document', groups: ['mode', 'document', 'doctools']},
                            '/',
                            {name: 'clipboard', groups: ['clipboard', 'undo']},
                            {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                            {name: 'forms', groups: ['forms']},
                            '/',
                            {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                            {name: 'links', groups: ['links']},
                            {name: 'insert', groups: ['insert']},
                            '/',
                            {name: 'styles', groups: ['styles']},
                            {name: 'colors', groups: ['colors']},
                            {name: 'tools', groups: ['tools']},
                            {name: 'others', groups: ['others']},
                            {name: 'about', groups: ['about']}
                        ],
                        // Remove the redundant buttons from toolbar groups defined above.
                        removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Strike,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Unlink,Image,Flash,Table,HorizontalRule,SpecialChar,PageBreak,ShowBlocks,Maximize,About,Checkbox'
                    });
                </script>
            </div>
            @if ($errors->has('replay_video_iframe'))
                <div class="alert alert-danger">
                    {{ $errors->first('replay_video_iframe') }}
                </div>
            @endif
            <div class="row gallery-file__container upload-image">
                <div class="col-8">
                    <input id="uploadFile" class="f-input night_text night_input" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>Выбрать файл</span>
                        <input id="uploadBtn" type="file" class="upload"
                               name="file"/>
                    </div>
                </div>
            </div>
            @if ($errors->has('file'))
                <div class="alert alert-danger">
                    {{ $errors->first('file') }}
                </div>
            @endif
            <div class="create-replay__button">
                <button class="button button__download-more">
                    Создать
                </button>
            </div>
        </form>
    </div>

</div>

