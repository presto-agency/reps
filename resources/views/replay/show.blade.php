@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.show')
    @include('replay.components.video')
    @include('content.comments', ['comments' => $replay->comments])
    @include('content.add-comment', [
        'route' => route('replay.send_comment', ['id' =>$replay->id])
    ])
@endsection
