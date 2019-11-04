@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.forum-article')
@endsection

@section('right-side')
    @include('right-side.components.last-replay')
@endsection
