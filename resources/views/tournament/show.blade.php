@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.replays-navigation')
    @include('left-side.search')
@endsection

@section('content')
    @include('content.Page_tournamentDetail-content')
@endsection
