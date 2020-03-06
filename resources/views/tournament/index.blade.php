@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_tournament-list" data-rout="{{ route('load.more.tournament') }}"></div>
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript" src="{{mix('js/assets/load_tournament.js')}}" defer></script>
@endsection
