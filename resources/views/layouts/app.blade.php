<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Reps.Ru') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('ckeditor\ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sceditor\minified\sceditor.min.js') }}"></script>
    <link rel="stylesheet" href="../../../sceditor/minified/themes/default.min.css"/>
    {{--  Include the BBCode or XHTML formats  --}}
    <script type="text/javascript" src="{{ asset('sceditor\minified\formats\bbcode.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sceditor\minified\formats\xhtml.js') }}"></script>
    {{--    Fonts   --}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600&display=swap" rel="stylesheet">
    {{--    Styles   --}}
    <link id="stl_day" href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified())
        <script>
            /**
             * Path to files.
             * smilesPath: /storage/chat/smiles/{$fileName}
             * imagesPath: /storage/chat/pictures/{$fileName}
             * racesPath: /images/default/game-races/{$fileName}
             * countriesPath: /storage/images/countries/flags/{$fileName}
             *
             */
            const smiles = JSON.parse('{!! $smilesJson !!}');
            const images = JSON.parse('{!! $imagesJson !!}');
            const races = JSON.parse('{!! $raceJson !!}');
            const countries = JSON.parse('{!! $countriesJson !!}');

            const getSmiles = smiles.map(function (item) {
                return item.filename;
            });
            const getImages = images.map(function (item) {
                return item.filename;
            });
            const getRaces = races.map(function (item) {
                return item.filename;
            });
            const getCountries = countries.map(function (item) {
                return item.filename;
            });
        </script>
    @endif
</head>
<body>
<a href="javascript:" id="return-to-top">
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-up"
         class="svg-inline--fa fa-chevron-up fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 448 512">
        <path fill="currentColor"
              d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path>
    </svg>
</a>
<header>
    @include('layouts.components.header.index')
</header>
<section class="container">
    <div class="row">
        <div class="col-12">
            @section('breadcrumbs')
            @show
        </div>
    </div>
</section>
@yield('stream')
<section class="container">
    <div class="row">
        <div id="left-sidebar" class="col-xl-3 col-lg-3 col-md-6 col-12">
            <button id="pulse-button-info" class="pulse-button">{{__('Информация')}}</button>
            <div id="left-sidebar-wrap" class="left-sidebar-wrap no-height">
                @yield('sidebar-left')
            </div>
        </div>
        <div id="content" class="col-xl-6 col-lg-6 col-md-12 col-12 content">
            @yield('content')
        </div>
        <div id="right-sidebar" class="col-xl-3 col-lg-3 col-md-6 col-12">
            <button id="pulse-button-top" class="pulse-button">{{__('Топ')}}</button>
            <div id="right-sidebar-wrap" class="right-sidebar-wrap no-height">
                @section('right-side')
                    @include('right-side.index')
                @show
            </div>
        </div>
    </div>
</section>
<footer>
    @include('layouts.components.footer.index')
</footer>
{{-- ========ALL MODAL WINDOWS ============== --}}
<div class="modal fade modal_like-diselike" id="vote-modal" tabindex="-1" role="dialog" aria-labelledby="likeModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="likeModalLabel">{{__('Оставте коментарий')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="close_modal">&times;</span>
                </button>
            </div>
            @if(Auth::user() )
                @include('modal.like_autorization')
            @else
                @include('modal.no-autorization')
            @endif
            <div class="modal-body unregistered-info-wrapper info-block">
                <div class="notice"></div>
                <img class="positive-vote-img d-none" src="{{asset('images/icons/thumbs-up.png')}}" alt="thumbs-up">
                <img class="negative-vote-img d-none" src="{{asset('images/icons/thumbs-down.png')}}" alt="thumbs-down">
            </div>
        </div>
    </div>
</div>
{{--========== END ALL MODAL WINDOWS ============--}}


{{--SCEditor--}}
<script src="{{ asset('js/sceditor/sceditor.min.js') }}"></script>
<script src="{{ asset('js/sceditor/formats/bbcode.js') }}"></script>
<script src="https://kit.fontawesome.com/75f3a42e45.js"></script>


@section('custom-script')
    <script type="text/javascript" defer>
        $(document).ready(function () {
            @if(Request::route()->getName() ==  'home.index' || Request::route()->getName() == 'news.index')
            /**
             * load News
             */
            loadNewsMainPage('');

            function loadNewsMainPage(id = '') {
                $.ajax({
                    url: "{{ route('load.news') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        $('#load_news_list_button').remove();
                        $('#load_news_list').append(data);
                    }
                })
            }

            $(document).on('click', '#load_news_list_button', function () {
                $('#load_news_list_button').html('<b>Загрузка...</b>');
                loadNewsMainPage($(this).data('id'));
            });
            @endif
            /**
             * Modal If validation Error Redirect and open modal
             */
            @if (count($errors) > 0)
            @if(!empty(Session::get('showModal')) && Session::get('showModal') == 'registration')
            $('#registrationModal').modal('show');
            @elseif(!empty(Session::get('showModal')) && Session::get('showModal') == 'login')
            $('#authorizationModal').modal('show');
            @endif
            @endif
            @if(!empty(Session::get('showModal')) && Session::get('showModal') == 'ban')
            $('#userInBanModal').modal('show');
            @endif
        });

        function xbbSpoiler(obj) {
            var obj_content = obj.parentNode.parentNode.getElementsByTagName('div')[1];
            var obj_text_show = obj.getElementsByTagName('strong')[1];
            var obj_text_hide = obj.getElementsByTagName('strong')[0];

            if (obj_content.style.display != '') {
                obj_content.style.display = '';
                obj_text_show.style.display = '';
                obj_text_hide.style.display = 'none';
            } else {
                obj_content.style.display = 'none';
                obj_text_show.style.display = 'none';
                obj_text_hide.style.display = '';
            }
            return false;
        }
    </script>
@show
<script type="text/javascript">
    $(function () {
        $('#button__auth-modal').click(function () {
            //active content with  id="myModal" as modal window
            $('#vote-modal').modal('hide');
            $('#authorizationModal').modal('show');
        });
        $('#button__register-modal').click(function () {
            //active content with  id="myModal" as modal window
            $('#vote-modal').modal('hide');
            $('#registrationModal').modal('show');
        });
        /**Vote - positive / negative vote - Separate Replay Page*/
        $('body').on('click', 'a.vote-replay-up, a.vote-replay-down', function (e) {
            var rating = $(this).attr('data-rating');
            var modal = $('#vote-modal');
            var url = $(this).attr('data-route');
            modal.find('form input#rating').val(rating);
            modal.find('form').attr('action', url);
            modal.find('.unregistered-info-wrapper').addClass('d-none');
            if (rating === '1') {
                modal.find('.positive').removeClass('d-none');
                modal.find('.negative').addClass('d-none');
            }
            if (rating === '-1') {
                modal.find('.positive').addClass('d-none');
                modal.find('.negative').removeClass('d-none');
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
                        $('#vote-modal').find('.unregistered-info-wrapper').removeClass('d-none');
                        $('#vote-modal').find('.unregistered-info-wrapper .notice').html(response.message);
                        $('#vote-modal').find('.modal-body' + ' .' + imgClass).removeClass('d-none');
                    } else {
                        location.reload();
                    }
                },
                error: function (error) {
                    $('#vote-modal').find('.unregistered-info-wrapper').removeClass('d-none');
                    $('#vote-modal').find('.unregistered-info-wrapper .notice').html('ошибка' + error);
                }
            });
        });
    });
</script>

@yield('java-script')
</body>
</html>
