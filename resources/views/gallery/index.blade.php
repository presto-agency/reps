@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-index') }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_galleries-list" data-rout="{{ route('load.more.images') }}"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
@section('custom-script')
    @parent
    <script type="text/javascript" src="{{mix('js/assets/load_galleries.js')}}" defer></script>
@endsection
