@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-topics',request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.topics.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript">
        function loadAjaxDataTopics(forum_section_id, topic_id = '', panel = '') {
            $.ajax({
                url: "{{ route('user.topics.load.sections.topics',['id'=> request('id')]) }}",
                method: "POST",
                data: {
                    forum_section_id: forum_section_id,
                    topic_id: topic_id,
                    _token: '{{csrf_token()}}',
                },
                success: function (data) {
                    let div_id = '#load_more_user_forum_sections_topics_' + forum_section_id;
                    let button_id = '#load_more_user_forum_sections_topics_button_' + forum_section_id;

                    $(button_id).remove();
                    $(div_id).append(data);
                }
            });

        }

        $.ready(button_event2);

        function button_event2(forum_section_id, topic_id) {
            let button_id = '#load_more_user_forum_sections_topics_button_' + forum_section_id;
            $(button_id).html('<b>Загрузка...</b>');
            loadAjaxDataTopics(forum_section_id, topic_id, '');
        }
    </script>
@endsection
