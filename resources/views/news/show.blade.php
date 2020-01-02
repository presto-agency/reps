@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-news-show') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('news.components.show')
    @include('comments.comments', ['comments' => $news->comments])
    @include('comments.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$news->id]),
        'id' => $news->id,
     ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
