@extends('layouts.app')

@section('sidebar-left')
    @include('user.components.vote')
@endsection

@section('content')
    @include('user.components.setting')
    @include('user.components.user_profile')

@endsection

@section('sidebar-right')
    right
@endsection
