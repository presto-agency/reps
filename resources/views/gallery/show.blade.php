@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-show',$userImage->id) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.gallery.components.show')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

