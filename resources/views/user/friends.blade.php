@extends('layouts.app')

@section('sidebar-left')
    <p>sidebar-left</p>
@endsection

@section('content')
    @include('user.components.user_friends')
@endsection
