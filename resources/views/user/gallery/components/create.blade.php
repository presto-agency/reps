<div class="gallery-download night_modal border_shadow">
    <div class="gallery-download__title">
        <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
             x="0px" y="0px"
             viewBox="0 0 512 512" xml:space="preserve">

            <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
                s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
                s226,101.383,226,226S380.617,482,256,482z"/>

            <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
                c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
                c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
        </svg>

        <p class="title__text">{{__('Загрузить изображение')}}</p>
    </div>
    <div class="gallery-download__body">
        <form class="gallery__form" action="{{route('user-gallery.store',['id'=>auth()->id()])}}"
              method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row gallery-file__container upload-image">
                <div class="col-8">
                    <input id="uploadFile" class="f-input night_input input_gallery" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>{{__('Выбрать файл')}}</span>
                        <input id="uploadBtn" type="file" class="upload" accept="image/*" name="picture"/>
                    </div>
                </div>
            </div>
            @error('picture')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-group">
                <label class="label_group" for="gallery-name">{{__('Подпись:')}}</label>
                <input type="text" name="sign" class="form-control night_input" id="gallery-name"
                       maxlength="255" value="{{clean(old('sign'))}}" placeholder="{{__('Подпись')}}">
            </div>
            @error('sign')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="form-check">
                <input class="form-check-input night_input" type="checkbox" value="1" id="gallery__for-adults"
                       {{ old('for_adults') ? 'checked' : '' }}
                       name='for_adults'>
                <label class="label_group" class="form-check-label" for="gallery__for-adults">
                    {{__('18+')}}
                </label>
            </div>
            @error('for_adults')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <div class="modal-body__add-btn">
                <button class="button button__download-more">
                    {{__('Добавить')}}
                </button>
            </div>
        </form>
    </div>
</div>

