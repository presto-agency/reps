@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-news-show', $news->id) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('news.components.show')
    @include('content.comments', ['comments' => $news->comments])
    @include('content.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$news->id])
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
