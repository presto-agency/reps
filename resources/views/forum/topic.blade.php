@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.detailed-forum')
    @include('content.comments', ['comments' => $topic->comments])
    @include('content.add-comment', [
        'route' => route('comment.store', $topic->id)
    ])
@endsection