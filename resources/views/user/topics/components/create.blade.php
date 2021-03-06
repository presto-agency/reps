<div class="create-topic border_shadow">
    <div class="create-topic__title">
        <p class="title__text">{{__('Создание темы')}}</p>
    </div>
    <form class="create-topic__form" method="POST" enctype="multipart/form-data"
          action="{{route('user-topics.store',['id' => auth()->id()])}}">
        @csrf
        <div class="form-group">
            <label for="create-topic__section" class="night_text ">{{__('*Раздел:')}}
                <select name="forum_section" id="create-topic__section " class="section form-control night_input"
                        required>
                    @isset($forumSection)
                        @foreach($forumSection as $item)
                            <option class="night_input" title="{{$item->description}}"
                                    {{ old('forum_section') == $item->id ? 'selected' : ''  }}
                                    value="{{$item->id}}">
                                {{$item->title}}</option>
                        @endforeach
                    @endisset
                </select>
            </label>
        </div>
        @error('forum_section')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <div class="form-group">
            <label for="create-topic__name" class="night_text">{{__('*Название:')}}</label>
            <input type="text" class="form-control create-topic__name night_input" id="create-topic__name"
                   value="{{clean(old('title'))}}" placeholder="{{__('Название:')}}"
                   maxlength="255" name="title" required>
        </div>
        @error('title')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <div class="upload-image">
            <div class="row">
                <div class="col-8">
                    <input id="uploadFile3" class="f-input night_input" readonly
                           placeholder="{{__('Картинка превью')}}"/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>{{__('Выбрать')}}</span>
                        <input id="uploadBtn3" type="file" class="upload" accept="image/*" name="preview_img"/>
                    </div>
                </div>
            </div>
        </div>
        @error('preview_img')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <div class="form-group">
            <label for="preview_content" class="night_text">{{__('Краткое описание')}}</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="preview_content"
                      name="preview_content">{{ clean(old('preview_content')) }}</textarea>
        </div>
        @error('preview_content')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <div class="form-group">

            <label for="main_content" class="night_text">{{__('*Содержание')}}</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="main_content"
                      name="content">{{ clean(old('content')) }}</textarea>
        </div>
        @error('content')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <div class="modal-body__enter-btn">
            <button class="button button__download-more">
                {{__('Опубликовать')}}
            </button>
        </div>
    </form>
</div>
@section('custom-script')
    @parent
        <script type="text/javascript" src="{{ asset('ckeditor\ckeditor.js') }}" defer></script>
        <script type="text/javascript">
            $(document).ready(function () {
                CKEDITOR.replace('preview_content', {});
                CKEDITOR.replace('main_content', {});
            });
        </script>
@endsection
