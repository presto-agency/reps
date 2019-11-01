@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.components.my-topics')
@endsection


@section('right-side')
    @parent
    @include('right-side.components.last-replay')

{{--    @include('user.components.user-replays')--}}

@endsection
