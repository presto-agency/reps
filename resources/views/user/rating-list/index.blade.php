@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.rating-list.components.block-user-reputation-info.index')
    @include('user.rating-list.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
