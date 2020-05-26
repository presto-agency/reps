@extends('layouts.app')
@php
    $seo_title = !empty($news->seo_title) ? $news->seo_title: config('app.name','Reps.ru');
    $seo_keywords = !empty($news->seo_keywords) ?$news->seo_keywords : config('app.name','Reps.ru');
    $seo_description = !empty($news->seo_description) ? $news->seo_description: 'images/logo.png';
    $seo_og_icon = !empty($news->seo_og_image) ?$news->seo_og_image : null;
@endphp

@section('meta-title'){{$seo_title}}@endsection
@section('meta-og-title'){{$seo_title}}@endsection
@section('meta-keywords'){{$seo_keywords}}@endsection
@section('meta-og-keywords'){{$seo_keywords}}@endsection
@section('meta-description'){{$seo_description}}@endsection
@section('meta-og-description'){{$seo_description}}@endsection
@if(!is_null($seo_og_icon) && File::exists($seo_og_icon))
@section('meta-og-image'){{asset($seo_og_icon)}}@endsection
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
