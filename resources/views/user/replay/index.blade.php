@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay-index',request('id'),request('type')) }}
@endsection


@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_user-replays-list"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            loadUserReplays('',);
            function loadUserReplays(id = '',) {
                $.ajax({
                    url: '{{ route('load.more.user.replay.index',['id'=>request('id')]) }}',
                    method: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        user_id: '{{request('id')}}',
                        id: id,
                        type: '{{request('type')}}',
                    },
                    success: function (data) {
                        $('#load_more-user-replay').remove();
                        $('#load_user-replays-list').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-user-replay', function () {
                $('#load_more-user-replay').html('<b>Загрузка...</b>');
                loadUserReplays($(this).data('id'),);
            });
        });
    </script>
@endsection
