@extends('layouts.app')

@section('sidebar-left')
    @include('user.components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    @include('user.components.user_profile')
    @include('user.components.user_reputation')
    @include('user.components.setting')
    @include('user.components.gallery-download')
    @include('user.components.gallery')
    @include('user.components.gallery-img-detail')
    @include('user.components.gallery-comments')
    @include('user.components.gallery-add-comment')
    @include('user.components.create-new-replay')
    @include('user.components.user-reputation-history')
@endsection

@section('sidebar-right')
    @include('user.components.user-replays')
@endsection
