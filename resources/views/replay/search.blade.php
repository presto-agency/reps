@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay', request('user_replay')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_replay_only_search"></div>
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {

            let _token = $('input[name="_token"]').val();

            load_replay_only_search('', _token);

            function load_replay_only_search(id = "", _token) {
                $.ajax({
                    url: "{{ route('load.more.replay.only.search') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: _token,
                        text: "{{request('text')}}",
                        first_country_id: "{{request('first_country_id')}}",
                        second_country_id: "{{request('second_country_id')}}",
                        first_race: "{{request('first_race')}}",
                        second_race: "{{request('second_race')}}",
                        map_id: "{{request('map_id')}}",
                        type_id: "{{request('type_id')}}",
                        user_replay: "{{request('user_replay')}}",
                    },
                    success: function (data) {
                        $('#load_replay_only_search_button').remove();
                        $('#load_replay_only_search').append(data);
                    }
                })
            }

            $(document).on('click', '#load_replay_only_search_button', function () {
                let id = $(this).data('id');
                $('#load_replay_only_search_button').html('<b>Загрузка...</b>');
                load_replay_only_search(id, _token);
            });
        });
    </script>
@endsection
