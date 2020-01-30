<div class="add-comment border_shadow">
    <div class="add-comment__title">
        <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
             x="0px" y="0px"
             viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
	        <path d="M30.5,0C14.233,0,1,13.233,1,29.5c0,5.146,1.346,10.202,3.896,14.65L0.051,58.684c-0.116,0.349-0.032,0.732,0.219,1
            C0.462,59.888,0.728,60,1,60c0.085,0,0.17-0.011,0.254-0.033l15.867-4.176C21.243,57.892,25.86,59,30.5,59
            C46.767,59,60,45.767,60,29.5S46.767,0,30.5,0z M30.5,57c-3.469,0-6.919-0.673-10.132-1.945l4.849-1.079
            c0.539-0.12,0.879-0.654,0.759-1.193c-0.12-0.539-0.653-0.877-1.193-0.759l-7.76,1.727c-0.006,0.001-0.01,0.006-0.016,0.007
            c-0.007,0.002-0.014,0-0.021,0.001L2.533,57.563l4.403-13.209c0.092-0.276,0.059-0.578-0.089-0.827C4.33,39.292,3,34.441,3,29.5
            C3,14.336,15.336,2,30.5,2S58,14.336,58,29.5S45.664,57,30.5,57z"/>
            <path
                d="M17,23.015h14c0.552,0,1-0.448,1-1s-0.448-1-1-1H17c-0.552,0-1,0.448-1,1S16.448,23.015,17,23.015z"/>
            <path
                d="M44,29.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,29.015,44,29.015z"/>
            <path
                d="M44,37.015H17c-0.552,0-1,0.448-1,1s0.448,1,1,1h27c0.552,0,1-0.448,1-1S44.552,37.015,44,37.015z"/>
        </svg>
        <p class="title__text">{{__('Добавить комментарий')}}</p>
    </div>
    @auth
        <form class="add-comment__form" action="{{$route}}" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" tabindex="-1" value="{{$id}}">
            <div class="form-group" id="div_content-comment">
                <label for="content-comment" class="night_text">  {{__('Коментарий')}}</label>
                <textarea class="form-control night_input" id="content-comment" name="content">
                    {{clean(old('content'))}}</textarea>
                @error('content')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <script type="text/javascript" defer>
                    // let areas = Array('content-comment');
                    // $.each(areas, function (i, area) {
                    //     CKEDITOR.replace(area, {
                    //         customConfig: '/ckeditor/commentsConfig.js'
                    //
                    //     });
                    // });
                    CKEDITOR.replace('content-comment', {});
                </script>
                <div class="messenger__button add-comment__btn">
                    <button class="button button__download-more">
                        {{__('Отправить')}}
                    </button>
                </div>
            </div>
        </form>
    @else
        <p class="none_text night_text">{{__('Авторизуйтесь чтобы отправить комментарий')}}</p>
    @endif
</div>
{{--hgg--}}
