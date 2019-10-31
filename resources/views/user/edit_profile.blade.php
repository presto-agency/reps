@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.create-replay')
@endsection

@section('content')
    @include('user.components.setting')
@endsection
