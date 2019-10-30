@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('best.showAll')
@endsection
