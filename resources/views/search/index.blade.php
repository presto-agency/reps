@extends('layouts.app')

@section('stream')
    <section class="container chat_overflow">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('home.components.chat.index')
            </div>
        </div>
    </section>
@endsection

@section('sidebar-left')
    @include('left-side.upcoming-tournament')
    @include('left-side.last-replays')
    @include('left-side.last-news')
@endsection

@section('content')
    {{--    <div id="search-result"></div>--}}
    @include('search.components.index')
{{--    @include('topics')--}}
{{--    @include('replay.components.index')--}}
@endsection
