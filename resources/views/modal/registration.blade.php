<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content night_modal">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalTitle">Регистрация</h5>
                <a href="#" class="modal-header__close" data-dismiss="modal">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 64 64">
                        <path d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"></path>
                    </svg>
                </a>
            </div>
            <div class="modal-body">
                <h2 class="modal-body__title night_text">Добро пожаловать!</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text"
                               class="form-control night_input @error('name') is-invalid @enderror"
                               id="registration-name"
                               placeholder={{ __('Name') }}
                               name="name"
                               value="{{ old('name') }}"
                               required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="email"
                               class="form-control night_input @error('email') is-invalid @enderror"
                               id="registration-mail"
                               placeholder={{ __('E-Mail Address') }}
                               name="email"
                               value="{{ old('email') }}"
                               required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <select class="js-example-basic-single" name="country">
                            @foreach($countries as $country)
                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>

                        <select name="race" id="race" class="race night_input">
                            @foreach($race as $item)
                                <option value="{{ $item->code }}">{{ $item->title }}</option>
                            @endforeach
                        </select>

                        <input type="password"
                               class="form-control night_input @error('password') is-invalid @enderror"
                               id="registration-password"
                               placeholder={{ __('Password') }}
                                name="password"
                               required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="password"
                               class="form-control night_input"
                               id="registration-rePassword"
                               placeholder={{ __('Confirm Password') }}
                                name="password_confirmation"
                               required autocomplete="new-password">
                    </div>

                    <div class="modal-body__enter-btn">
                        <button type="submit" class="button button__download-more">
                            Зарегистрироваться
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
