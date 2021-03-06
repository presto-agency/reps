@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-friends', auth()->id()) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.components.user_friends')
@endsection
