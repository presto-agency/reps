@extends('layouts.app')

@section('meta-title'){{$topic->getSeoTitle().' | '}}@endsection
@section('meta-og-title'){{$topic->getSeoTitle()}}@endsection
@section('meta-keywords'){{$topic->getSeoKeywords()}}@endsection
@section('meta-og-keywords'){{$topic->getSeoKeywords()}}@endsection
@section('meta-description'){{$topic->getSeoDescription()}}@endsection
@section('meta-og-description'){{$topic->getSeoDescription()}}@endsection
@section('meta-og-image'){{$topic::getSeoIconData($topic)['path']}}@endsection
@section('meta-og-image-alt'){{$topic->getSeoTitle()}}@endsection
@section('meta-og-image-type'){{$topic::getSeoIconData($topic)['type']}}@endsection

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
