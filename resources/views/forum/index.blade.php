@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-sections-index') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="load_forum_sections" data-rout="{{ route('load.more.forum.index') }}"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript" src="{{mix('js/assets/load_forum_sections.js')}}" defer></script>
@endsection
