@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div class="get-recovery-link border_shadow">
        <div class="get-recovery-link__title">
            <p class="title__text">{{__('Получение ссылки для восстановление пароля')}}</p>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form class="get-recovery-link__form night_modal" action="{{route('password.email')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="get-recovery-link__email" class="night_text">{{ __('*Email:') }}</label>
                <input id="get-recovery-link__email" type="email" class="form-control night_input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="modal-body__enter-btn">
                <button type="submit" class="button button__download-more">
                    {{__('Отправить')}}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection