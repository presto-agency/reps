@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay-show', request('type')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.show')
    @include('comments.comments', ['comments' => $replayShow->comments])
    @include('comments.add-comment', [
        'route' => route('replay.send-comment', ['id' =>$replayShow->id]),
        'id' => $replayShow->id,
    ])
@endsection
