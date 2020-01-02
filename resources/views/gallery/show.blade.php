@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-show') }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.gallery.components.show')
    @include('comments.comments', ['comments' => $image->comments])
    @include('comments.add-comment', [
        'route' => route('galleries.send.comment', ['id' =>$image->id]),
        'id' => $image->id,
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

