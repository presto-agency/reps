@extends('layouts.app')

@section('meta-title'){{$news->getSeoTitle().' | '}}@endsection
@section('meta-og-title'){{$news->getSeoTitle()}}@endsection
@section('meta-keywords'){{$news->getSeoKeywords()}}@endsection
@section('meta-og-keywords'){{$news->getSeoKeywords()}}@endsection
@section('meta-description'){{$news->getSeoDescription()}}@endsection
@section('meta-og-description'){{$news->getSeoDescription()}}@endsection
@section('meta-og-image'){{$news::getSeoIconData($news)['path']}}@endsection
@section('meta-og-image-alt'){{$news->getSeoTitle()}}@endsection
@section('meta-og-image-type'){{$news::getSeoIconData($news)['type']}}@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('topic-news-show') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('news.components.show')
    @include('comments.comments', ['comments' => $news->comments])
    @include('comments.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$news->id]),
        'id' => $news->id,
     ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
