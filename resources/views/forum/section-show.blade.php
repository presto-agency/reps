@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forum-sections-show',request('forum')) }}
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

@section('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {

            loadForumSectionsShow('');

            function loadForumSectionsShow(id = '') {
                $.ajax({
                    url: "{{ route('load.more.forum.show',['forum'=>request('forum')]) }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        $('#load_forum_sections').remove();
                        $('#load_forum_sections_show').append(data);
                    }
                })
            }

            $(document).on('click', '#load_forum_sections', function () {
                $('#load_forum_sections').html('<b>Загрузка...</b>');
                loadForumSectionsShow($(this).data('id'));
            });
        });
    </script>
@endsection
