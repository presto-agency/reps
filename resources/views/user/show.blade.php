@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.components.show')
    @include('user.components.user_friends')
    @include('user.components.password-recovery')
    @include('user.components.get-recovery-link')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
