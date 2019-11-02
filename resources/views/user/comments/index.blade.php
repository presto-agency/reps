@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.comments.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
