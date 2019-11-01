@extends('layouts.app')

@section('sidebar-left')
    @include('components.vote')
    @include('user.components.search-replay')
@endsection

@section('content')
    @include('user.gallery.components.show')
    @include('content.comments', ['comments' => $userImage->comments])
    @include('content.add-comment', [
        'route' => route('galleries.send.comment', ['id' =>$userImage->id])
    ])
@endsection
