@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-edit', $user->id) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.components.edit')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
