@extends('layouts.app')
@if(!empty($news->seo_title))
@section('meta-title')
    {!! $news->seo_title !!}
@endsection
@endif
@if(!empty($news->seo_description))
@section('meta-description')
    {!! $news->seo_description !!}
@endsection
@endif
@if(!empty($news->seo_og_title))
@section('meta-og-title')
    {!! $news->seo_og_title !!}
@endsection
@endif
@if(!empty($news->seo_og_description))
@section('meta-og-description')
    {!! $news->seo_og_description !!}
@endsection
@endif
@if(!empty($news->seo_og_image))
@section('meta-og-image')
    {!! $news->seo_og_image !!}
@endsection
@endif




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
