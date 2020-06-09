<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{config('app.name', 'Reps.ru').' | '}}@section('meta-title'){{$metaTags->getMetaTitle()}}@show</title>
    <base href="{{config('app.url')}}">
    {{--META OG:TAGS--}}

    <meta property="og:locale" content="ru_RU"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:site_name" content="{{config('app.name', 'Reps.ru')}}"/>
    <meta property="og:title" content="@section('meta-og-title'){{$metaTags->getMetaTitle()}}@show"/>
    <meta property="og:keywords" content="@section('meta-og-keywords'){{$metaTags->getMetaKeywords()}}@show">
    <meta property="og:description" content="@section('meta-og-description'){{$metaTags->getMetaDescription()}}@show"/>

    <meta property="og:image" content="@section('meta-og-image'){{$metaTags->getMetaIcon()}}@show"/>
    <meta property="og:image:alt" content="@section('meta-og-image-alt'){{$metaTags->getMetaTitle()}}@show"/>
    <meta property="og:image:type" content="@section('meta-og-image-type'){{$metaTags->getMetaIconType()}}@show"/>
    <meta property="og:image:width" content="400"/>
    <meta property="og:image:height" content="300"/>
    <meta name="google-site-verification" content="{{config('services.google.site_verification')}}"/>
    <meta name="yandex-verification" content="{{config('services.yandex.site_verification')}}"/>
    {{--META TAGS--}}
    <meta name="title" content="@section('meta-title'){{$metaTags->getMetaTitle()}}@show">
    <meta name="keywords" content="@section('meta-keywords'){{$metaTags->getMetaKeywords()}}@show">
    <meta name="description" content="@section('meta-description'){{$metaTags->getMetaDescription()}}@show">

    {{--csrf_token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/png" sizes="32x32"/>
    {{--    CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--Script--}}
    <script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('ckeditor\ckeditor.js') }}"></script>
    {{--    Fonts   --}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600&display=swap" rel="stylesheet">
    {{--    Styles   --}}
    <link id="stl_day" href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sceditor/minified/themes/default.min.css') }}"/>

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
{{--MAIN--}}
<script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>
{{--SCEditor--}}
<script type="text/javascript" src="{{ asset('sceditor\minified\sceditor.min.js') }}" defer></script>
{{-- SCEditor Include the BBCode or XHTML formats  --}}
<script type="text/javascript" src="{{ asset('sceditor\minified\formats\bbcode.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('sceditor\minified\formats\xhtml.js') }}" defer></script>
@if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified())
    <script type="text/javascript" defer>
        /**
         * SCEditor
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
<script type="text/javascript" src="{{ asset('js/sceditor/sceditor.min.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('js/sceditor/formats/bbcode.js') }}" defer></script>
<script type="text/javascript" src="https://kit.fontawesome.com/75f3a42e45.js" defer></script>


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

        /**
         * Spoiler
         */
        function xbbSpoiler(obj) {
            console.log("OBJ", obj);
            // var obj_content = obj.parentNode.parentNode.getElementsByTagName('div')[1];
            var obj_content = obj.parentNode.getElementsByClassName('spoiler')[0];
            console.log("obj_content", obj_content);
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

        /**
         * Raiting vote -1 or +1
         *
         * */
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
                let url = $(this).attr('action');
                let selectData = $('#rating-vote-form').serialize();
                let imgClass = 'positive-vote-img';
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
@show
@yield('java-script')
</body>
</html>
