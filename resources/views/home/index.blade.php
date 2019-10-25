@extends('layouts.app')

@section('stream')
    <section class="container chat_overflow">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('components.Chat')
            </div>
        </div>
    </section>
@endsection

@section('sidebar-left')
    @include('components.block-tournament')
    @include('components.block-replay')
    @include('components.block-lastNews')
@endsection

@section('content')

    <div id="last_news"></div>
    {{--@include('content.last_news')--}}
@endsection
