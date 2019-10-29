@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    @include('user.components.user_friends')
    @include('user.components.user_profile')
    @include('user.components.user_reputation')
    @include('user.components.setting')
{{--    @include('user.gallery.gallery-download')--}}
{{--    @include('user.gallery.gallery')--}}
{{--    @include('user.gallery.gallery-img-detail')--}}
{{--    @include('user.gallery.gallery-comments')--}}
{{--    @include('user.gallery.gallery-add-comment')--}}
    @include('user.components.create-new-replay')
    @include('user.components.user-reputation-history')
    @include('user.components.my-topics')
    @include('user.components.password-recovery')
    @include('user.components.get-recovery-link')
    @include('user.components.my-posts')
    @include('user.components.reputation-info')
@endsection

@section('sidebar-right')
    @include('user.components.user-replays')
@endsection
