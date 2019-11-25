@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div class="password-recovery border_shadow">
        <div class="password-recovery__title">
            <p class="title__text">{{ __('Восстановление пароля') }}</p>
        </div>
        <form class="password-recovery__form night_modal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email-recovery__new-email" class="night_text">{{ __('*Email:') }}</label>
                <input type="email" id="email-recovery__new-email" class="form-control night_input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-recovery__new-password" class="night_text">{{ __('*Пароль:') }}</label>
                <input type="password" id="password-recovery__new-password" class="form-control night_input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-recovery__confirm-password" class="night_text">{{ __('*Подтвердите пароль:') }}</label>
                <input type="password" id="password-recovery__confirm-password" class="form-control night_input" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="modal-body__enter-btn">
                <button type="submit" class="button button__download-more">
                    {{ __('Отправить') }}
                </button>
            </div>
        </form>
    </div>
    {{--    <div class="container">--}}
    {{--        <div class="row justify-content-center">--}}
    {{--            <div class="col-md-12">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header">{{ __('Reset Password') }}</div>--}}
    {{--                    <div class="card-body">--}}
    {{--                        <form method="POST" action="{{ route('password.email') }}">--}}
    {{--                            @csrf--}}
    {{--                            <input type="hidden" name="token" value="{{ $token }}">--}}
    {{--                            <div class="form-group row">--}}
    {{--                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>--}}
    {{--                                    @error('email')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @enderror--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="form-group row">--}}
    {{--                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}
    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}
    {{--                                    @error('password')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @enderror--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="form-group row">--}}
    {{--                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}
    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="form-group row mb-0">--}}
    {{--                                <div class="col-md-6 offset-md-4">--}}
    {{--                                    <button type="submit" class="btn btn-primary">--}}
    {{--                                        {{ __('Reset Password') }}--}}
    {{--                                    </button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection