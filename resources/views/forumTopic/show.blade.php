@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-show', $topic->id,$topic->forum_section_id) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('forumTopic.components.show')
    @include('content.comments', ['comments' => $topic->comments])
    @include('content.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$topic->id])
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
