@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament-show') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('tournament.components.show')
@endsection

