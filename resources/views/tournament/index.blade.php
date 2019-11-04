@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search')
@endsection

@section('content')
    @include('tournament.components.index')
@endsection
