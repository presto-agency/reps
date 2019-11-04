@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.detailed-news')
    @include('content.comments')
    @include('content.add-comment')
@endsection

@section('right-side')
    @include('right-side.components.last-replay')
@endsection
