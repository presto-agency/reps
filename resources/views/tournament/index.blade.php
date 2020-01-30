@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_tournament-list"></div>
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript" defer>
        $(document).ready(function () {
            loadTournament('');

            function loadTournament(id = '') {
                $.ajax({
                    url: "{{ route('load.more.tournament') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        $('#load_more-tournament').remove();
                        $('#load_tournament-list').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-tournament', function () {
                $('#load_more-tournament').html('<b>Загрузка...</b>');
                loadTournament($(this).data('id'));
            });
        });
    </script>
@endsection
