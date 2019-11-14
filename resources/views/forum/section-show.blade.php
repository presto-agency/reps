@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-show',request('forum')) }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="load_forum_sections_show"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('input[name="_token"]').val();
            load_forum_sections_show('', _token);

            function load_forum_sections_show(id = "", _token) {
                $.ajax({
                    url: "{{ route('load.more.forum.show',['forum'=>request('forum')]) }}",
                    method: "POST",
                    data: {id: id, _token: _token},
                    success: function (data) {
                        $('#load_forum_sections_show_button').remove();
                        $('#load_forum_sections_show').append(data);
                    }
                })
            }

            $(document).on('click', '#load_forum_sections_show_button', function () {
                let id = $(this).data('id');
                $('#load_forum_sections_show_button').html('<b>Загрузка...</b>');
                load_forum_sections_show(id, _token);
            });
        });
    </script>
@endsection
