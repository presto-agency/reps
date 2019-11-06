@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-show',request('forum')) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.forum-article')
@endsection

@section('right-side')
    @include('right-side.components.last-replay')
@endsection
