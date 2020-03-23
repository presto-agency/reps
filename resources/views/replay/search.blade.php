@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay-search') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="set_found_replays"></div>
@endsection
@section('custom-script')
    @parent
    <script type="text/javascript" defer>
        $(document).ready(function () {
            loadReplaysSearch('',);

            function loadReplaysSearch(id = '',) {
                $.ajax({
                    url: '{{ route('load.more.replay.only.search') }}',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}',
                        text: '{{request('text')}}',
                        first_country_id: '{{request('first_country_id')}}',
                        second_country_id: '{{request('second_country_id')}}',
                        first_race: '{{request('first_race')}}',
                        second_race: '{{request('second_race')}}',
                        map_id: '{{request('map_id')}}',
                        type_id: '{{request('type_id')}}',
                        user_replay: '{{request('user_replay')}}',
                        vod_rep: '{{request('vod_rep')}}',
                    },
                    success: function (data) {
                        $('#load_replays_search').remove();
                        $('#set_found_replays').append(data);
                    }
                })
            }

            $(document).on('click', '#load_replays_search', function () {
                $('#load_replays_search').html('<b>Загрузка...</b>');
                loadReplaysSearch($(this).data('id'));
            });
        });
    </script>
@endsection
