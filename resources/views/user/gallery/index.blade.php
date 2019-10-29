@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    {{--    @include('user.gallery.components.gallery-download')--}}
    @include('user.gallery.components.gallery')
    {{--    @include('user.gallery.components.gallery-img-detail')--}}
    {{--    @include('user.gallery.components.gallery-comments')--}}
    {{--    @include('user.gallery.components.gallery-add-comment')--}}
@endsection
@section('sidebar-right')
    @include('user.components.user-replays')
@endsection
