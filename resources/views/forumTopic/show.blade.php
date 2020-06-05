@extends('layouts.app')

@php
    $tile = Str::limit($topic->title,65,'');
    $img = !empty($topic->preview_img) && checkFile::checkFileExists($topic->preview_img) ? $topic->preview_img :'images/logo.png';
    $seo_title = !empty($topic->seo_title) ? $topic->seo_title: $tile;
    $seo_keywords = !empty($topic->seo_keywords) ?$topic->seo_keywords : $tile;
    $seo_description = !empty($topic->seo_description) ? $topic->seo_description: $tile;
    $seo_og_icon = !empty($topic->seo_og_image) ? $topic->seo_og_image : $img;
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
    {{ Breadcrumbs::render('forum-topic-show', $topic->forum_section_id) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    @include('forumTopic.components.show')
    @include('comments.comments', ['comments' => $topic->comments])
    @include('comments.add-comment', [
        'route' => route('topic.send_comment', ['id' =>$topic->id]),
        'id' => $topic->id,
    ])
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
