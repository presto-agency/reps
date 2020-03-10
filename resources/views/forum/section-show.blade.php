@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-sections-show',request('forum')) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="load_forum_sections_show" data-rout="{{ route('load.more.forum.show',['forum'=>request('forum')]) }}">
    </div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript" src="{{mix('js/assets/load_forum_sections_show.js')}}" defer></script>
@endsection
