<div class="create-topic border_shadow">
    <div class="create-topic__title">
        <p class="title__text">{{__('Создание темы')}}</p>
    </div>
    <form class="create-topic__form" method="POST" action="{{route('user-topics.store',['id' => auth()->id()])}}"
          enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="create-topic__section" class="night_text ">{{__('*Раздел:')}}
                <select name="forum_section_id" id="create-topic__section " class="section form-control night_input" required>
                    @isset($forumSection)
                        @foreach($forumSection as $item)
                            <option class="night_input" value="{{$item->id}}"
                                    title="{{$item->description}}"
                                    {{old('forum_section_id')}}>{{$item->title}}</option>
                        @endforeach
                    @endisset
                </select>
            </label>
        </div>
        @if ($errors->has('forum_section_id'))
            <div class="alert alert-danger">
                {{ $errors->first('forum_section_id') }}
            </div>
        @endif
        <div class="form-group">
            <label for="create-topic__name" class="night_text">{{__('*Название:')}}</label>
            <input type="text" class="form-control create-topic__name night_input" id="create-topic__name"
                   placeholder="Название" name="title" value="{{old('title')}}" minlength="1" maxlength="255" required>
        </div>
        @if ($errors->has('title'))
            <div class="alert alert-danger">
                {{ $errors->first('title') }}
            </div>
        @endif
        <div class="upload-image">
            <div class="row">
                <div class="col-8">
                    <input id="uploadFile3" class="f-input night_input" placeholder="Выбрать" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>{{__('Выбрать')}}</span>
                        <input id="uploadBtn3" type="file" class="upload" value="{{old('preview_img')}}"
                               accept="image/*"
                               name="preview_img"/>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->has('preview_img'))
            <div class="alert alert-danger">
                {{ $errors->first('preview_img') }}
            </div>
        @endif
        <div class="form-group">
            <label for="preview_content" class="night_text">{{__('*Краткое содержание')}}</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="preview_content"
                      name="preview_content" minlength="1" maxlength="1000" rows="16" required>{!! old('preview_content') !!}
            </textarea>
            <script>
                CKEDITOR.replace('preview_content', {
                    // Define the toolbar groups as it is a more accessible solution.
                    extraPlugins: 'autoembed',
                    toolbarGroups: [
                        {name: 'document', groups: ['mode', 'document', 'doctools']},
                        {name: 'clipboard', groups: ['clipboard', 'undo']},
                        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                        {name: 'forms', groups: ['forms']},
                        {name: 'styles', groups: ['styles']},
                        {name: 'colors', groups: ['colors']},
                        {name: 'tools', groups: ['tools']},
                        {name: 'others', groups: ['others']},
                        {name: 'about', groups: ['about']},
                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                        {name: 'links', groups: ['links']},
                        {name: 'insert', groups: ['insert']},

                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Strike,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Unlink,Image,Flash,Table,HorizontalRule,SpecialChar,PageBreak,ShowBlocks,Maximize,About,Checkbox'
                });
            </script>
        </div>
        <div class="form-group">
            <label for="description" class="night_text">{{__('*Содержание')}}</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="description"
                      name="content" minlength="10" maxlength="50000" rows="32" required>{!! old('content') !!}
            </textarea>
            <script>
                CKEDITOR.replace('description', {
                    // Define the toolbar groups as it is a more accessible solution.
                    extraPlugins: 'autoembed',
                    toolbarGroups: [
                        {name: 'document', groups: ['mode', 'document', 'doctools']},
                        {name: 'clipboard', groups: ['clipboard', 'undo']},
                        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                        {name: 'forms', groups: ['forms']},
                        {name: 'styles', groups: ['styles']},
                        {name: 'colors', groups: ['colors']},
                        {name: 'tools', groups: ['tools']},
                        {name: 'others', groups: ['others']},
                        {name: 'about', groups: ['about']},
                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                        {name: 'links', groups: ['links']},
                        {name: 'insert', groups: ['insert']},

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
        <div class="modal-body__enter-btn">
            <button class="button button__download-more">
                {{__('Опубликовать')}}
            </button>
        </div>
    </form>
</div>
