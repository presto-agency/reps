@isset($topic)
    <div class="create-topic border_shadow">
        <div class="create-topic__title">
            <p class="title__text">{{__('Редактирование темы')}}</p>
        </div>
        <form class="create-topic__form" method="POST"
              action="{{route('user-topics.update',['id' => $topic->user_id,'user_topic'=>$topic->id])}}"
              enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="create-topic__section" class="night_text">{{__('*Раздел:')}}
                    <select name="forum_section_id" id="create-topic__section" class="section night_input" required>
                        @isset($forumSection)
                            @foreach($forumSection as $item)
                                <option class="night_input" value="{{$item->id}}"
                                        {{ old('forum_section_id',$topic->forum_section_id) == $item->id ? "selected":""}}>
                                    {{$item->title}}
                                </option>
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
                       placeholder="Название" name="title" value="{{old('title',$topic->title)}}" minlength="1"
                       maxlength="255"
                       required>
            </div>
            @if ($errors->has('title'))
                <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
            <div class="upload-image">
                <div class="row">
                    <div class="col-8">
                        <input id="uploadFile3" class="f-input" placeholder="{{__('Выбрать картинку превью')}}"
                               readonly/>
                    </div>
                    <div class="col-4 pl-0">
                        <div class="fileUpload btn btn--browse">
                            <span>{{__('Выбрать')}}</span>
                            <input id="uploadBtn3" type="file" class="upload"
                                   value="{{old('preview_img',$topic->preview_img)}}"
                                   accept="image/*" name="preview_img"/>
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
                          name="preview_content" minlength="1" maxlength="1000" rows="16" required>
                    {!! old('preview_content', ParserToHTML::toHTML($topic->preview_content,'size')) !!}
            </textarea>
            </div>
            @if ($errors->has('preview_content'))
                <div class="alert alert-danger">
                    {{ $errors->first('preview_content') }}
                </div>
            @endif
            <div class="form-group">
                <label for="content" class="night_text">{{__('*Содержание')}}</label>
                <textarea type="text" class="form-control create-topic__name night_input" id="preview_content"
                          name="content" minlength="1" maxlength="50000" rows="32" required>
                   {!!old('content',ParserToHTML::toHTML($topic->content,'size'))!!}
            </textarea>
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
@endisset
