@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay', request('user_replay')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.search')
@endsection
