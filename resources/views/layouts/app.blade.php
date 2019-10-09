<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
`
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
{{--    <div id="app">--}}

{{--@include('components.Chat')--}}
{{--@include('components.block-tournament')--}}
{{--@include('components.block-replay')--}}
{{--@include('components.block-lastNews')--}}


<!--SECTION HEADER-->
    <header>
            @include('components.header')
    </header>
<!--END SECTION HEADER-->

<!--Stream Section-->
    @yield('stream')
<!--END Stream Section-->

<!--SECTION CONTENT-->
    <section class="container">
        <div class="row">

            <!--SIDEBAR LEFT-->
            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                @yield('sidebar-left')
                {{--@include('components.block-tournament')--}}
                {{--@include('components.block-replay')--}}
                {{--@include('components.block-lastNews')--}}
                {{--@include('left-side.replays')--}}
                {{--@include('left-side.search')--}}
                {{--@include('left-side.forum-topics')--}}
            </div>
            <!--END SIDEBAR LEFT-->

            <!--CONTENT-->
            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                {{--@include('content.Page_tournament-content')--}}
                @yield('content')
                {{--@include('content.detailed-news')--}}
                {{--@include('content.forum-allSections')--}}
                {{--@include('content.forum-article')--}}
                {{--@include('content.gocu-replays')--}}
                {{--@include('content.comments')--}}
            </div>
            <!--END CONTENT-->

            <!--SIDEBAR RIGHT-->
            <div class="col-xl-3 col-3 col-md-6 col-12">
                @section('sidebar-right')
                    @include('components.block-top')
                @show
                {{--@yield('sidebar-right')--}}
                {{--@include('components.block-top')--}}
            </div>
            <!--END SIDEBAR RIGHT-->

        </div>
    </section>
<!--END SECTION CONTENT-->

<!--FOOTER-->
        <footer>
            @include('footer.footer')
        </footer>
<!--END FOOTER-->

<script src="https://kit.fontawesome.com/75f3a42e45.js"></script>

{{--    </div>--}}

</body>
</html>
