<form class="body__edit-image-form" method="POST" enctype="multipart/form-data"
      action="{{route('user-gallery.update',['id'=>$userImage->user_id,'user_gallery'=>$userImage->id])}}">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="gallery-name"> {{__('Подпись:')}}</label>
        <input type="text" class="form-control night_input" id="gallery-name" name="sign" placeholder="Подпись"
               maxlength="255" value="{{ clean(old('sign',$userImage->sign)) }}">
    </div>
    @if ($errors->has('sign'))
        <div class="alert alert-danger">
            {{ $errors->first('sign') }}
        </div>
    @endif
    <div class="form-check">
        <input class="form-check-input night_input" type="checkbox" value="1"
               name="for_adults" id="gallery__for-adults"
            {{  old('for_adults',$userImage->for_adults) ? 'checked' : ''}}
        >
        <label class="form-check-label" for="gallery__for-adults">
            {{__('18+')}}
        </label>
    </div>
    @if ($errors->has('for_adults'))
        <div class="alert alert-danger">
            {{ $errors->first('for_adults') }}
        </div>
    @endif
    <div class="modal-body__add-btn">
        <button class="button button__download-more">
            {{__('Обновить')}}
        </button>
    </div>
</form>
