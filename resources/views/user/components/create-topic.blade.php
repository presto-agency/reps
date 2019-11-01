<div class="create-topic border_shadow">
    <div class="create-topic__title">
        <p class="title__text">Создание темы</p>
    </div>
    <form class="create-topic__form">
        <div class="form-group">
            <label for="create-topic__section" class="night_text">Раздел:
                <select name="race" id="create-topic__section" class="section night_input">
                    <option class="night_input">Общий</option>
                    <option class="night_input">Общий</option>
                    <option class="night_input">Общий</option>
                    <option class="night_input">Общий</option>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label for="create-topic__name" class="night_text">*Название:</label>
            <input type="text" class="form-control create-topic__name night_input" id="create-topic__name">
        </div>

        <div class="upload-image">
            <div class="row">
                <div class="col-8">
                    <input id="uploadFile3" class="f-input" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>Выбрать файл</span>
                        <input id="uploadBtn3" type="file" class="upload" value="{{old('picture')}}" accept="image/*"
                               name="picture"/>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal-body__enter-btn">
            <button class="button button__download-more">
                Опубликовать
            </button>
        </div>

    </form>
</div>
