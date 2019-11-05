@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
    @include('user.components.my-chat')
@endsection

@section('content')
    @include('user.components.edit')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
