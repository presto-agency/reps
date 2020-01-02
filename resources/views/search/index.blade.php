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

@section('custom-script')
    <script type="text/javascript">
        /**
         * Ajax for news-search
         */
        $(document).ready(function () {

                @if (request()->has('search') && request()->filled('search'))
                let search = "{{request('search')}}";
                @endif

                loadMoreNewsSearch('', search);

                function loadMoreNewsSearch(id = '', search) {
                    $.ajax({
                        url: '{{ route('load.more.search.news') }}',
                        method: "POST",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}',
                            search: search
                        },
                        success: function (data) {
                            $('#load_more_news_search_button').remove();
                            $('#load_more_news_search').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_news_search_button', function () {
                    $('#load_more_news_search_button').html('<b>Загрузка...</b>');
                    loadMoreNewsSearch($(this).data('id'), search);
                });
            }
        );
        /**
         * Ajax for replays-search
         */
        $(document).ready(function () {

                @if (request()->has('search') && request()->filled('search'))
            let search = "{{request('search')}}";
            @endif
            loadMoreReplaysSearch('', search);

            function loadMoreReplaysSearch(id = '', search) {
                $.ajax({
                    url: "{{ route('load.more.search.replays') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}',
                        search
                    },
                    success: function (data) {
                        $('#load_more_replays_search_button').remove();
                        $('#load_more_replays_search').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_replays_search_button', function () {
                $('#load_more_replays_search_button').html('<b>Загрузка...</b>');
                loadMoreReplaysSearch($(this).data('id'), search);
            });
        });
    </script>
@endsection
