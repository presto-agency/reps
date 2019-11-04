@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.search-replay')
    @include('user.components.my-chat')
@endsection

@section('content')
    @include('user.components.user_friends')
    @include('user.components.user_profile')
    @include('user.components.user_reputation')
{{--    @include('user.components.setting')--}}
    @include('user.components.user-reputation-history')
{{--    @include('user.components.my-topics')--}}
    @include('user.components.password-recovery')
    @include('user.components.get-recovery-link')
    @include('user.components.my-posts')
    @include('user.components.reputation-info')

{{--    @include('user.gallery.components.show')--}}
    @include('user.gallery.components.show')
    @include('user.components.create-topic')
    @include('user.messenger')
@endsection
