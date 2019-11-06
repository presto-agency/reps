@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay', request('type')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.index')
@endsection
