@extends('layouts.app')
@php
    $tile = Str::limit($news->title,65,'');
    $img = (!empty($news->preview_img) && checkFile::checkFileExists($news->preview_img)) ? $news->preview_img :'images/logo.png';
    $seo_title = !empty($news->seo_title) ? $news->seo_title : $tile;
    $seo_keywords = !empty($news->seo_keywords) ?$news->seo_keywords : $tile;
    $seo_description = !empty($news->seo_description) ?$news->seo_description : $tile;
    $seo_og_icon = !empty($news->seo_og_image) ?$news->seo_og_image : $img;

@endphp

@section('meta-title'){{$seo_title}}@endsection
@section('meta-og-title'){{$seo_title}}@endsection
@section('meta-keywords'){{$seo_keywords}}@endsection
@section('meta-og-keywords'){{$seo_keywords}}@endsection
@section('meta-description'){{$seo_description}}@endsection
@section('meta-og-description'){{$seo_description}}@endsection
@if(!empty($seo_og_icon))
    @php
        $img_type = 'image/'.\File::extension($seo_og_icon);
    @endphp
@section('meta-og-image'){{asset($seo_og_icon)}}@endsection
@section('meta-og-image-alt'){{$seo_title}}@endsection
@section('meta-og-image-type'){{$img_type}}@endsection
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
