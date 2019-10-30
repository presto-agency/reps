@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    @include('user.components.my-topics')
@endsection

@section('sidebar-right')
    @include('user.components.user-replays')
@endsection
