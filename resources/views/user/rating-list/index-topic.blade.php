@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-topic-rating-list',request('id'),$object->user_id) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.rating-list.components.block-user-topic-reputation-info.show')
    @include('user.rating-list.components.info-topic')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
