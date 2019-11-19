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

    <link rel="stylesheet" href="minified/themes/default.min.css"/>
    {{--    <script src="minified/sceditor.min.js"></script>--}}
    {{--    <script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>--}}
    {{--    <script src="https://cdn.ckeditor.com/4.13.0/standard-all/ckeditor.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.13.0/full-all/ckeditor.js"></script>
    <link rel="stylesheet" href="minified/themes/default.min.css"/>
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
<a href="javascript:" id="return-to-top"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-up" class="svg-inline--fa fa-chevron-up fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></a>
<header>
    {{--    @include('header.index')--}}
    @include('layouts.components.header.index')
</header>
<!--END SECTION HEADER-->

<!--SECTION BREADCRUMBS-->
<section class="container">
    <div class="row">
        <div class="col-12">
            @section('breadcrumbs')
{{--                {{ Breadcrumbs::render('home') }}--}}
            @show
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
                @section('right-side')
                    @include('right-side.index')
                @show
            </div>
        </div>
        <!--END SIDEBAR RIGHT-->

    </div>
</section>
<!--END SECTION CONTENT-->

<footer>
    {{--    @include('footer.index')--}}
    @include('layouts.components.footer.index')
</footer>


<!-- Start Modal Rating-->
<div class="modal fade" id="vote-modal" tabindex="-1" role="dialog" aria-labelledby="addRatingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRatingModalLabel">Оставте комментарий</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::user() )
                <form id="rating-vote-form" action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Комментарий:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
                @else
                    <p>Данная опция доступна только авторизированным пользователям</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Rating-->


<!--SCEditor-->
<script src="{{ asset('js/sceditor/sceditor.min.js') }}"></script>
<script src="{{ asset('js/sceditor/formats/bbcode.js') }}"></script>

<script src="https://kit.fontawesome.com/75f3a42e45.js"></script>


{{--    </div>--}}
@yield('ess21-custom-script')
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
                $('#load_more_button').html('<b>Загрузка...</b>');
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

<script>
    $(function () {

        /**Vote - positive / negative vote - Separate Replay Page*/
        $('body').on('click', 'a.vote-replay-up, a.vote-replay-down', function (e) {
            var rating = $(this).attr('data-rating');
            var modal = $('#vote-modal');
            var url = $(this).attr('data-route');
            modal.find('form input#rating').val(rating);
            modal.find('form').attr('action', url);
            modal.find('.modal-body .unregistered-info-wrapper').removeClass('active');

            if (rating === '1') {
                modal.find('.negative').removeClass('active');
                modal.find('.positive').addClass('active');
            }
            if (rating === '-1') {
                modal.find('.negative').addClass('active');
                modal.find('.positive').removeClass('active');
            }
        });

        $('body').on('submit', '#rating-vote-form', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var selectData = $('#rating-vote-form').serialize();
            var imgClass = 'positive-vote-img';
            $.ajax({
                type: 'POST',
                url: url,
                data: selectData,
                success: function (response) {
                    if (response.message) {
                        if (response.user_rating === "-1") {
                            imgClass = 'negative-vote-img';
                        }
                        if (response.user_rating === undefined) {
                            imgClass = '';
                        }
                        $('#vote-modal').find('.modal-body .unregistered-info-wrapper').addClass('active');
                        $('#vote-modal').find('.modal-body .unregistered-info-wrapper .notice').html(response.message);
                        $('#vote-modal').find('.modal-body' + ' .' + imgClass).addClass('active');
                    } else {
                        location.reload();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>

@yield('java-script')
</body>
</html>
