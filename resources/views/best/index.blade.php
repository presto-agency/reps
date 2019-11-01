@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('best.components.index')
@endsection

@section('right-side')
    @include('components.block-last-5-news-or-replay')
@endsection
