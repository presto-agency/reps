@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-topics-edit',request('id'),request('user_topic')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.topics.components.edit')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
