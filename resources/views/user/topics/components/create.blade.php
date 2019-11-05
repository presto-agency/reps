<div class="create-topic border_shadow">
    <div class="create-topic__title">
        <p class="title__text">Создание темы</p>
    </div>
    <form class="create-topic__form" method="POST" action="{{route('user-topics.store',['id' => auth()->id()])}}"
          enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="create-topic__section" class="night_text">*Раздел:
                <select name="forum_section_id" id="create-topic__section" class="section night_input" required>
                    @isset($forumSection)
                        @foreach($forumSection as $item)
                            <option class="night_input" value="{{$item->id}}"
                                    title="{{$item->description}}">{{$item->title}}</option>
                        @endforeach
                    @endisset
                </select>
            </label>
        </div>
        <div class="form-group">
            <label for="create-topic__name" class="night_text">*Название:</label>
            <input type="text" class="form-control create-topic__name night_input" id="create-topic__name"
                   placeholder="Название" name="title" value="{{old('title')}}" minlength="1" maxlength="255" required>
        </div>
        <div class="upload-image">
            <div class="row">
                <div class="col-8">
                    <input id="uploadFile3" class="f-input" placeholder="Выбрать картинку превью" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>Выбрать картинку превью</span>
                        <input id="uploadBtn3" type="file" class="upload" value="{{old('preview_img')}}"
                               accept="image/*"
                               name="preview_img"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="preview_content" class="night_text">*Краткое содержание</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="preview_content"
                      name="preview_content" minlength="1" maxlength="1000" rows="16" required>
            </textarea>
        </div>
        <div class="form-group">
            <label for="content" class="night_text">*Краткое содержание</label>
            <textarea type="text" class="form-control create-topic__name night_input" id="preview_content"
                      name="content" minlength="1" maxlength="50000" rows="32" required>
            </textarea>
        </div>
        <div class="modal-body__enter-btn">
            <button class="button button__download-more">
                Опубликовать
            </button>
        </div>
    </form>
</div>
