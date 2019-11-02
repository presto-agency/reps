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

        <p class="title__text">Создать новый Replay</p>
    </div>
    <div class="create-replay__body night_modal">
        <form class="create-replay__form" action="{{ route('replay.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="create-replay-name" class="night_text">* Название:</label>
                <input type="text" class="form-control night_input" id="create-replay-name" placeholder="Название"
                       name="title" value="{{old("title")}}" required minlength="1" maxlength="255">
            </div>
            @if ($errors->has('title'))
                <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__user-replay" class="night_text">* Пользовательский/Gosu:
                            <select name="user_replay" id="create-replay__user-replay"
                                    class="create-replay__user-replay night_input">
                                @foreach($userReplay as $key => $items)
                                    <option value="{{$key}}">{{$items}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('user_replay'))
                    <div class="alert alert-danger">
                        {{ $errors->first('user_replay') }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__type" class="night_text">* Тип:
                            <select name="type_id" id="create-replay__type night_input"
                                    class="create-replay__type night_input">
                                @foreach($types as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('type_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('type_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="create-replay__map" class="night_text">* Карта:
                    <select name="map_id" class="js-example-basic-single night_input" id="create-replay__map">
                        @foreach($maps as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
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
                            <select name="race_id" id="create-replay__first-race"
                                    class="create-replay__first-race night_input">
                                @foreach($races as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('race_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('race_id') }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create-replay__first-country" class="night_text">* Первая страна:
                            <select name="first_country_id" class="js-example-basic-single" name="country"
                                    id="create-replay__first-country">
                                @foreach($countries as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                @if ($errors->has('first_country_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('first_country_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="create-replay__second-location" class="night_text">* Вторая локация:</label>
                <input type="text" class="form-control night_input" id="create-replay__second-location" minlength="1"
                       maxlength="255" placeholder="Вторая локация">
            </div>
            <hr>
            <div class="form-group">
                <label for="replay_content" class="night_text">Вставить HTML код с видео реплеем</label>
                <textarea name="editor1" class="form-control night_input"
                          id="editor1"></textarea>
{{--                <script>--}}
{{--                    CKEDITOR.replace('editor1', {--}}
{{--                        extraPlugins: 'embed,autoembed,image2',--}}
{{--                        removePlugins: 'Image',--}}
{{--                        height: 500,--}}

{{--                        // Load the default contents.css file plus customizations for this sample.--}}
{{--                        contentsCss: [--}}
{{--                            'http://cdn.ckeditor.com/4.13.0/full-all/contents.css',--}}
{{--                            'https://ckeditor.com/docs/vendors/4.13.0/ckeditor/assets/css/widgetstyles.css'--}}
{{--                        ],--}}
{{--                        // Setup content provider. See https://ckeditor.com/docs/ckeditor4/latest/features/media_embed--}}
{{--                        embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',--}}

{{--                        // Configure the Enhanced Image plugin to use classes instead of styles and to disable the--}}
{{--                        // resizer (because image size is controlled by widget styles or the image takes maximum--}}
{{--                        // 100% of the editor width).--}}
{{--                        image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],--}}
{{--                        image2_disableResizer: true--}}
{{--                    });--}}
{{--                </script>--}}
                <script>
                    CKEDITOR.replace('editor1', {
                        // Define the toolbar groups as it is a more accessible solution.
                        extraPlugins: 'embed,autoembed',
                        toolbarGroups: [
                            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                            '/',
                            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                            { name: 'forms', groups: [ 'forms' ] },
                            '/',
                            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                            { name: 'links', groups: [ 'links' ] },
                            { name: 'insert', groups: [ 'insert' ] },
                            '/',
                            { name: 'styles', groups: [ 'styles' ] },
                            { name: 'colors', groups: [ 'colors' ] },
                            { name: 'tools', groups: [ 'tools' ] },
                            { name: 'others', groups: [ 'others' ] },
                            { name: 'about', groups: [ 'about' ] }
                        ],
                        // Remove the redundant buttons from toolbar groups defined above.
                        removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Strike,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Unlink,Image,Flash,Table,HorizontalRule,SpecialChar,PageBreak,ShowBlocks,Maximize,About,Checkbox'
                    });
                </script>
            </div>

            @if ($errors->has('content'))
                <div class="alert alert-danger">
                    {{ $errors->first('content') }}
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

