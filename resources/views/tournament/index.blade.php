@extends('layouts.app')

@section('sidebar-left')
    @include('left-side.replays')
    @include('left-side.search')
@endsection

@section('content')
    @include('content.Page_tournament-content')
@endsection