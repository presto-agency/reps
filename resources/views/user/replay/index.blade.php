@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay',request('id'),request('type')) }}
@endsection


@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.index')

@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
