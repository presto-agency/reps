@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay-index', request('type')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_replays-list"></div>
@endsection

@section('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            loadReplays('',);

            function loadReplays(id = '',) {
                $.ajax({
                    url: '{{ route('load.more.replay.index') }}',
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}',
                        type: '{{request('type')}}',
                        subtype: '{{request('subtype')}}',
                    },
                    success: function (data) {
                        $('#load_more-replay').remove();
                        $('#load_replays-list').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-replay', function () {
                $('#load_more-replay').html('<b>Загрузка...</b>');
                loadReplays($(this).data('id'));
            });
        });
    </script>
@endsection
