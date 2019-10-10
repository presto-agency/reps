@extends('layouts.app')

@section('sidebar-left')
    left
@endsection

@section('content')
    @include('user.components.setting')
@endsection

@section('sidebar-right')
    right
@endsection
