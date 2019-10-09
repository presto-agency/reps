@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.detailed-news')
    @include('content.comments')
@endsection