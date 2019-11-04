@extends('layouts.app')

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.gallery.components.show')
    @include('content.comments', ['comments' => $userImage->comments])
    @include('content.add-comment', [
        'route' => route('galleries.send.comment', ['id' =>$userImage->id])
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
