@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay-create',request('id'),'user') }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.replay.components.create')

@endsection
@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
