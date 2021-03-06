@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('best') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('best.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
