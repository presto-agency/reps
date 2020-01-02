@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-news-index') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="last_news"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
