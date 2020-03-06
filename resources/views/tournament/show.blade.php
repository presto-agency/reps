@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament-show') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('tournament.components.show')
@endsection

@section('custom-script')
    @parent
    @if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified() && $tournament::$status[$tournament->status] == 'REGISTRATION')
        @if(empty($tournament->player))
            <script type="text/javascript" src="{{mix('js/assets/register_tournament.js')}}" defer></script>
        @endif
    @endif
@endsection


