@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    {{--@include('content.last_news')--}}
    <div id="last_news"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
