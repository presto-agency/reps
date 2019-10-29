@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.replays-navigation')
    @include('left-side.search')
@endsection

@section('content')
        @include('replay.showAll')
@endsection

