<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name', 'Reps.ru').' | '}} Chat</title>
    <base href="{{config('app.url')}}">
    <meta property="og:locale" content="ru_RU"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:site_name" content="{{config('app.name', 'Reps.ru')}}"/>
    <meta name="title" content="{{config('app.name', 'Reps.ru').' | '}} Chat">
    <meta name="keywords" content="Reps.ru reps.ru chat">
    <meta name="description" content="Reps.ru window chat">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/png" sizes="32x32"/>
    {{--    CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        #appchat {
            width: 320px !important;
        }
    </style>
</head>
<body>
<div id="appchat">
    <chat-room :auth="{{ Auth::check() ? Auth::user() : 0 }}"
               :not_user="{{ (Auth::check() && Auth::user()->email_verified_at) ? Auth::user()->isNotUser() : 0}}"/>
</div>
@include("modal.authorization")
<script type="text/javascript" src="{{mix('js/app.js')}}" defer></script>
<script type="text/javascript" src="{{mix('js/assets/chat/init.js')}}" defer></script>
</body>
</html>


