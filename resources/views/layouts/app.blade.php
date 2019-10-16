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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600&display=swap" rel="stylesheet">
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Include SCEditor -->
    <link rel="stylesheet" href="js/minified(sceditor-2.1.3)/themes/default.min.css"/>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
{{ csrf_field() }}
{{--    <div id="app">--}}

{{--@include('components.Chat')--}}
{{--@include('components.block-tournament')--}}
{{--@include('components.block-replay')--}}
{{--@include('components.block-lastNews')--}}

<!--SECTION HEADER-->
        <header>
                {{--include header--}}
                         @include('user.components.NEW_header')
{{--                 @include('user.components.header_user')--}}
                @include('modal.authorization')
                @include('modal.registration')
        </header>
<!--END SECTION HEADER-->

        <section class="container">
            <div class="row">
                <div class="col-12">
                    @include('breadcrumbs.breadcrumbs')
                </div>
            </div>
        </section>
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
                {{--@include('content.Page_gameBest')--}}
                {{--@include('content.Page_tournamentDetail-content')--}}
                {{--@include('content.Page_tournament-content')--}}
                @yield('content')
                {{--@include('content.detailed-news')--}}
                {{--@include('content.forum-allSections')--}}
                {{--@include('content.forum-article')--}}
                {{--@include('content.gocu-replays')--}}
                {{--@include('content.comments')--}}
                {{--@include('content.add-comment')--}}
                {{--@include('content.detailed-forum')--}}
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



<!--SCEditor-->
<script src="js/minified(sceditor-2.1.3)/sceditor.min.js"></script>
<script src="js/minified/formats/bbcode.js"></script>

<script src="https://kit.fontawesome.com/75f3a42e45.js"></script>


{{--    </div>--}}
@section('custom-script')
    <script>
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();

            load_news('', _token);

            function load_news(id="", _token) {
                $.ajax({
                    url: "{{ route('loadmore.load_news') }}",
                    method: "POST",
                    data: {id:id, _token:_token},
                    success: function (data) {
                        $('#load_more_button').remove();
                        $('#last_news').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_button', function(){
                let id = $(this).data('id');
                $('#load_more_button').html('<b>Loading...</b>');
                load_news(id, _token);
            });
        });
    </script>
@show
</body>
</html>
