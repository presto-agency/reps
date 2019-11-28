<form action="{{route('user-gallery.update',['id'=>$userImage->user_id,'user_gallery'=>$userImage->id])}}"
      class="body__edit-image-form" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="gallery-name"> {{__('Подпись:')}}</label>
        <input type="text" class="form-control" id="gallery-name" name="sign" placeholder="Подпись"
               value="{!! strip_tags(ParserToHTML::toHTML(old('sign',$userImage->sign),'size'))  !!}">
    </div>
    @if ($errors->has('sign'))
        <div class="alert alert-danger">
            {{ $errors->first('sign') }}
        </div>
    @endif
{{--    @dd($userImage->for_adults)--}}
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1"
               name="for_adults" id="gallery__for-adults"
               @if(old('for_adults')) checked @endif
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
