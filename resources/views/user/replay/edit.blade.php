@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay-edit',$userReplayEdit->user_id,\App\Models\Replay::$type[$userReplayEdit->user_replay]) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.replay.components.edit')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
