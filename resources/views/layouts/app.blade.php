<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        {{--include header--}}

                    </div>
                </div>
            </div>
        </header>

        <section class="container">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                {{--include breadcrumbs--}}
            </div>
        </section>

        <section class="container">
            <div class="row">
                <div class="col-3">
                    {{--include left-side--}}
                </div>
                <div class="col-6">
                    @yield('content')

                    {{--include content--}}
                </div>
                <div class="col-3">
                    {{--include right-side--}}
                </div>
            </div>
        </section>

        <footer>
            @include('footer.footer')
        </footer>

{{--    </div>--}}

</body>
</html>
