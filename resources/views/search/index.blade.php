@extends('layouts.app')

@section('stream')
    <section class="container chat_overflow">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('home.components.chat.index')
            </div>
        </div>
    </section>
@endsection

@section('sidebar-left')
    @include('left-side.upcoming-tournament')
    @include('left-side.last-replays')
    @include('left-side.last-news')
@endsection

@section('content')
    <div id="load_more_news_search"></div>
    <div id="load_more_replays_search"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('ess21-custom-script')
    <script type="text/javascript">
        /**
         * Ajax for news-search
         */
        $(document).ready(function () {
                let _token = $('input[name="_token"]').val();
                    @if (request()->has('search') && request()->filled('search'))
                let search = "{{request('search')}}";
                    @endif

                    load_more_news_search('', _token, search);

                function load_more_news_search(id = "", _token, search) {
                    $.ajax({
                        url: "{{ route('load.more.search.news') }}",
                        method: "POST",
                        data: {id: id, _token: _token, search: search},
                        success: function (data) {
                            $('#load_more_news_search_button').remove();
                            $('#load_more_news_search').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_news_search_button', function () {
                    let id = $(this).data('id');
                    $('#load_more_news_search_button').html('<b>Загрузка...</b>');
                    load_more_news_search(id, _token, search);
                });
            }
        );
        /**
         * Ajax for replays-search
         */
        $(document).ready(function () {
            let _token = $('input[name="_token"]').val();
                    @if (request()->has('search') && request()->filled('search'))
            let search = "{{request('search')}}";
            @endif
            load_more_replays_search('', _token, search);

            function load_more_replays_search(id = "", _token, search) {
                $.ajax({
                    url: "{{ route('load.more.search.replays') }}",
                    method: "POST",
                    data: {id: id, _token: _token, search},
                    success: function (data) {
                        $('#load_more_replays_search_button').remove();
                        $('#load_more_replays_search').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_replays_search_button', function () {
                let id = $(this).data('id');
                $('#load_more_replays_search_button').html('<b>Загрузка...</b>');
                load_more_replays_search(id, _token, search);
            });
        });
    </script>
@endsection
