@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-topic-show', $topic->forum_section_id) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('forumTopic.components.show')
    @include('comments.comments', ['comments' => $topic->comments])
    @include('comments.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$topic->id]),
        'id' => $topic->id,
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
