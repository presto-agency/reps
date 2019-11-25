@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-profile-show', request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('user.components.show')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
