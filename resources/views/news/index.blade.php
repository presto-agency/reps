@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('news') }}
@endsection

@section('content')
    <div id="last_news"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
