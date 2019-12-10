@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay-edit',request('id'),request('user_replay'),request('type','user')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.replay.components.edit')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
