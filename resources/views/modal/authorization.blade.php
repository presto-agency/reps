<div class="modal fade" id="authorizationModal" tabindex="-1" role="dialog" aria-labelledby="authorizationModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content night_modal">
            <div class="modal-header">
                <h5 class="modal-title" id="authorizationModalTitle">{{__('Вход')}}</h5>
                <a href="#" class="modal-header__close" data-dismiss="modal">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                         enable-background="new 0 0 64 64">
                        <path
                            d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"></path>
                    </svg>
                </a>
            </div>
            <div class="modal-body">
                <h2 class="modal-body__title night_text">{{__('Добро пожаловать!')}}</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control night_input @error('email') is-invalid @enderror"
                               id="authorization-mail" type="email" autocomplete="email" name="email"
                               required autofocus value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input class="form-control night_input @error('password') is-invalid @enderror"
                               type="password" id="authorization-password" name="password"
                               autocomplete="current-password"
                               required placeholder="{{ __('Password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-12 remember">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label night_text" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__enter-btn">
                        <button type="submit" class="button button__download-more">
                            {{ __('Login') }}
                        </button>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="modal-body__forgot-password night_text" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
