@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay-show',request('id'),request('user_replay'),request('type')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('replay.components.show')
    @include('comments.comments', ['comments' => $replay->comments])
    @include('comments.add-comment', [
        'route' => route('replay.send_comment', ['id' =>$replay->id]),
        'id' => $replay->id,
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
