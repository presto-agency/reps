@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.components.user_profile')
    #####################################################
    @include('user.components.user_friends')
    #####################################################
    @include('user.components.user_reputation')
    #####################################################
{{--    @include('user.components.setting')--}}
{{--    #####################################################--}}
{{--    @include('user.rating-list.components.index')--}}
{{--    #####################################################--}}
{{--    @include('user.topics.components.index')--}}
{{--    #####################################################--}}
    @include('user.components.password-recovery')
    #####################################################
    @include('user.components.get-recovery-link')
    #####################################################
{{--    @include('user.components.topik-show') --}}
{{--    #####################################################--}}
    @include('user.components.create-topic')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
