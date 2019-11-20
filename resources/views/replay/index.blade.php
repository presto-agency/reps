@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('replay', request('type')) }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="last_replay"></div>
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('input[name="_token"]').val();
            let subtype = "{{$subtype}}";
            let type = "{{$type}}";
            last_replay('', _token, subtype);

            function last_replay(id = "", _token, subtype) {
                $.ajax({
                    url: "{{ route('load.more.replay') }}",
                    method: "POST",
                    data: {id: id, _token: _token, subtype: subtype, type: type},
                    success: function (data) {
                        $('#load_more-replay_button').remove();
                        $('#last_replay').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more-replay_button', function () {
                let id = $(this).data('id');
                let subtype = $(this).data('subtype');
                $('#load_more-replay_button').html('<b>Загрузка...</b>');
                last_replay(id, _token, subtype);
            });
        });
    </script>
@endsection
