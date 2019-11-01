<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="minified/themes/default.min.css" />
    <script src="minified/sceditor.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600&display=swap" rel="stylesheet">
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

<!-- Include SCEditor -->
    <link rel="stylesheet" href="{{ asset('js/sceditor/themes/default.min.css') }} "/>

    <!-- Styles -->
    <link id="stl_day" href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
<!--SECTION HEADER-->
<header>
    @include('header.index')
</header>
<!--END SECTION HEADER-->

<!--SECTION BREADCRUMBS-->
<section class="container">
    <div class="row">
        <div class="col-12">
            @include('breadcrumbs.breadcrumbs')
        </div>
    </div>
</section>
<!--END SECTION BREADCRUMBS-->

<!--SECTION STREAM-->
@yield('stream')
<!--END SECTION STREAM-->

<!--SECTION CONTENT-->
<section class="container">
    <div class="row">

        <!--SIDEBAR LEFT-->
        <div id="left-sidebar" class="col-xl-3 col-lg-3 col-md-6 col-12">
            <button id="pulse-button-info" class="pulse-button">Информация</button>
            <div id="left-sidebar-wrap" class="left-sidebar-wrap no-height">
                @yield('sidebar-left')
            </div>
        </div>
        <!--END SIDEBAR LEFT-->

        <!--CONTENT-->
        <div id="content" class="col-xl-6 col-lg-6 col-md-12 col-12 content">
            @yield('content')
        </div>
        <!--END CONTENT-->

        <!-- RIGHT SIDEBAR-->
        <div id="right-sidebar" class="col-xl-3 col-lg-3 col-md-6 col-12">
            <button id="pulse-button-top" class="pulse-button">Топ</button>
            <div id="right-sidebar-wrap" class="right-sidebar-wrap no-height">
                @include('right-side.index')
            </div>
        </div>
        <!--END SIDEBAR RIGHT-->

    </div>
</section>
<!--END SECTION CONTENT-->

<footer>
    @include('footer.index')
</footer>

<!--SCEditor-->
<script src="{{ asset('js/sceditor/sceditor.min.js') }}"></script>
<script src="{{ asset('js/sceditor/formats/bbcode.js') }}"></script>

<script src="https://kit.fontawesome.com/75f3a42e45.js"></script>


{{--    </div>--}}
@stack('ess21-custom-script')
@section('custom-script')
    <script>
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();

            load_news('', _token);

            function load_news(id = "", _token) {
                $.ajax({
                    url: "{{ route('loadmore.load_news') }}",
                    method: "POST",
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#load_more_button').remove();
                        $('#last_news').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_button', function () {
                let id = $(this).data('id');
                $('#load_more_button').html('<b>Loading...</b>');
                load_news(id, _token);
            });

            /*
            якщо є помилки при валідації під час реєстрації,
            відбувається редірект з відкритим модальним вікном
            і списком помилок в ньому
            */
            @if (count($errors) > 0)
            @if(!empty(Session::get('showModal')) && Session::get('showModal') == 'registration')
            $('#registrationModal').modal('show');
            @elseif(!empty(Session::get('showModal')) && Session::get('showModal') == 'login')
            $('#authorizationModal').modal('show');
            @endif
            @endif
        });
    </script>
@show
</body>
</html>
