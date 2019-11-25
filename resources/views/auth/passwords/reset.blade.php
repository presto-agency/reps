@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.upcoming-tournament')
    @include('left-side.last-replays')
    @include('left-side.last-news')
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
@endsection
