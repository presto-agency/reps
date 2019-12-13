@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-replay',request('id'),request('type')) }}
@endsection


@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="last_replay"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('input[name="_token"]').val();
            let user_id = "{{$user_id}}";
            let type = "{{$type}}";
            last_replay('', _token, user_id);

            function last_replay(id = "", _token, user_id) {
                $.ajax({
                    url: "{{ route('load.more.user.replay',['id'=>$user_id]) }}",
                    method: "POST",
                    data: {id: id, _token: _token, user_id: user_id, type: type},
                    success: function (data) {
                        $('#load_more-replay_button').remove();
                        $('#last_replay').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-replay_button', function () {
                let id = $(this).data('id');
                let user_id = $(this).data('user_id');
                $('#load_more-replay_button').html('<b>Загрузка...</b>');
                last_replay(id, _token, user_id);
            });
        });
    </script>
@endsection
