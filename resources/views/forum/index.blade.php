@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-sections-index') }}
@endsection

@section('sidebar-left')
    @include('left-side.forum-topics')
@endsection

@section('content')
    <div id="load_forum_sections"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            loadForumSections('',);

            function loadForumSections(id = "",) {
                $.ajax({
                    url: "{{ route('load.more.forum.index') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        $('#load_more_forum_sections').remove();
                        $('#load_forum_sections').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_forum_sections', function () {
                $('#load_more_forum_sections').html('<b>Загрузка...</b>');
                loadForumSections($(this).data('id'));
            });
        });
    </script>
@endsection
