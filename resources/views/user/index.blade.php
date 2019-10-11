@extends('layouts.app')

@section('sidebar-left')
    left
    @yield('sidebar-left')
@endsection

@section('content')
    @include('user.components.setting')
    @include('user.components.user_profile')
@endsection

@section('sidebar-right')
    right
@endsection
