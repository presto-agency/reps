@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-news-index') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="load_news_list"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection



