@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('content.forum-allSections')
@endsection