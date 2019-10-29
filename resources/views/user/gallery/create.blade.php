@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    @include('user.gallery.components.create')
@endsection
@section('sidebar-right')
    @include('user.components.user-replays')
@endsection
