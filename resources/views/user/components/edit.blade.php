<div class="user-settings border_shadow">
    <div class="user-settings__title">
        <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
             x="0px" y="0px"
             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
            <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
                s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
                s226,101.383,226,226S380.617,482,256,482z"/>

            <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
                c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
                c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
        </svg>
        <p class="title__text">{{__('Настройки пользователя')}}</p>
    </div>
    <form class="user-settings__form" action="{{route('save_profile', $user->id)}}" enctype="multipart/form-data"
          method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="user-settings-email" class="night_text">{{__('*Email:')}}</label>
            <input type="email" class="form-control night_input" id="user-settings-email" name="email"
                   value="{{old('email',$user->email)}}">
            @error('email')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="user-settings-email-name" class="night_text">{{__('*Имя:')}}</label>
            <input type="text" class="form-control night_input"
                   id="user-settings-email-name" name="name" value="{{old('name',$user->name)}}">
            @error('name')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="upload-image">
            <p>{{__('Аватар:')}}</p>
            <div class="preview-image-wrapper">
                @if(auth()->check() && auth()->user()->userViewAvatars())
                    <img class="" src="{{asset($user->avatarOrDefault())}}" alt="avatar">
                @endif
                @guest()
                    <img class="" src="{{asset($user->avatarOrDefault())}}" alt="avatar">
                @endguest()
            </div>
            <div class="row">
                <div class="col-8">
                    <input id="uploadFile" class="f-input night_input"  placeholder="{{__('Файл')}}" readonly/>
                </div>
                <div class="col-4 pl-0">
                    <div class="fileUpload btn btn--browse">
                        <span>{{__('Выбрать файл')}}</span>
                        <input id="uploadBtn" type="file" class="upload" value="{{old('avatar',$user->avatar)}}"
                               accept="image/*" name="avatar"/>
                    </div>
                </div>
                @error('avatar')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
        </div>
        @if(isset($countries) && $countries->isNotEmpty())
            <div class="form-group">
                <label for="user-settings__country" class="night_text">{{__('*Страна:')}}
                    <select class="js-example-basic-single night_input"
                            name="country" id="user-settings__country">
                        @foreach($countries as $item)
                            <option class="night_input" value="{{$item->id}}"
                                {{ old('first_country_id',$user->country_id) == $item->id ? 'selected':''}}>
                                {{$item->name}}
                            </option>
                        @endforeach
                    </select>
                </label>
                @error('country')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
        @endif
        @if(isset($race) && $race->isNotEmpty())
            <div class="form-group">
                <label for="user-settings__race" class="night_text">{{__('*Раса:')}}
                    <select name="race" id="user-settings__race"
                            class="race night_input">
                        @foreach($race as $item)
                            <option class="night_input" value="{{$item->id}}"
                                {{ old('race',$user->race_id) == $item->id ? 'selected':''}}>
                                {{$item->title}}
                            </option>
                        @endforeach
                    </select>
                </label>
                @error('race')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
        @endif
        <div class="form-group">
            <label for="user-settings-date" class="night_text">{{__('Дата рождения:')}}</label>
            <input type="date" name="birthday" class="form-control night_input "
                   id="user-settings-date" value="{{old('birthday',$user->birthday)}}">
            @error('birthday')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="user-settings-site" class="night_text">{{__('Сайт:')}}</label>
            <input type="text" class="form-control night_input " id="user-settings-site" name="homepage"
                   placeholder="{{__('Сайт')}}" value="{{old('homepage',$user->homepage)}}">
            @error('homepage')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="user-settings-discord" class="night_text">{{__('Discord:')}}</label>
            <input type="text" class="form-control night_input " id="user-settings-discord" name="isq"
                   placeholder="{{__('Discord')}}" value="{{old('isq',$user->isq)}}">
            @error('isq')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="user-settings-skype" class="night_text">{{__('Skype:')}}</label>
            <input type="text" class="form-control night_input " id="user-settings-skype" name="skype"
                   placeholder="{{__('Skype')}}" value="{{old('skype',$user->skype)}}">
            @error('skype')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="form-check">
            <label class="form-check-label night_text" for="view_avatars">
                {{__('Просматривать аватары на форуме:')}}
            </label>
            <input class="form-check-input night_input " type="checkbox" id="view_avatars"
                   name="view_avatars" value="1" {{  old('view_avatars',$user->view_avatars) ? 'checked': ''}}>
            @error('view_avatars')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="modal-body__enter-btn">
            <button type="submit" class="button button__download-more">
                {{__(' Сохранить')}}
            </button>
        </div>
    </form>
</div>
