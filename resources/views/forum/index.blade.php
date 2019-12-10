@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-index') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="last_forum_sections_index"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('input[name="_token"]').val();
            last_forum_sections_index('', _token);

            function last_forum_sections_index(id = "", _token) {
                $.ajax({
                    url: "{{ route('load.more.forum.index') }}",
                    method: "POST",
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#load_more_forum_sections_index_button').remove();
                        $('#last_forum_sections_index').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_forum_sections_index_button', function () {
                let id = $(this).data('id');
                $('#load_more_forum_sections_index_button').html('<b>Загрузка...</b>');
                last_forum_sections_index(id, _token);
            });
        });
    </script>
@endsection
