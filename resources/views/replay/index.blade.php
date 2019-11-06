@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.index')
    @include('replay.components.video')
@endsection
