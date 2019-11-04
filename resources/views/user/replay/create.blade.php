@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.search-replay')
@endsection

@section('content')
    @include('user.replay.components.create')
@endsection
