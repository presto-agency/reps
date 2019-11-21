@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="last_tournament"></div>
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();

            last_tournament('', _token);

            function last_tournament(id = "", _token) {
                $.ajax({
                    url: "{{ route('load.more.tournament') }}",
                    method: "POST",
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#load_more-tournament_button').remove();
                        $('#last_tournament').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-tournament_button', function () {
                let id = $(this).data('id');
                $('#load_more-tournament_button').html('<b>Загрузка...</b>');
                last_tournament(id, _token);
            });
        });
    </script>
@endsection
