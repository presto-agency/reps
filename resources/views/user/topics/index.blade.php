@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-topics',request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div class="my-topics forum-topics border_shadow">
        <div id="load_more_user_forum_sections"></div>
    </div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('ess21-custom-script')
    <script type="text/javascript">
        /**
         *
         * Ajax Load ForumSections
         */
        $(document).ready(function () {
                let _token = $('input[name="_token"]').val();
                load_more_user_forum_sections('', _token);

                function load_more_user_forum_sections(section_id = "", _token) {
                    $.ajax({
                        url: "{{ route('user.topics.load.sections',['id'=> request('id')]) }}",
                        method: "POST",
                        data: {section_id: section_id, _token: _token, id: "{{request('id')}}"},
                        success: function (data) {
                            $('#load_more_user_forum_sections_button').remove();
                            $('#load_more_user_forum_sections').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_user_forum_sections_button', function () {
                    let section_id = $(this).data('section_id');
                    $('#load_more_user_forum_sections_button').html('<b>Загрузка...</b>');
                    load_more_user_forum_sections(section_id, _token);
                });
            }
        );

        /**
         *
         * Ajax Load ForumTopics for Sections
         */
            $(document).ready(function () {
                    let _token = $('input[name="_token"]').val();
                load_more_user_forum_sections_topics('','', _token);

                    function load_more_user_forum_sections_topics(section_id = "",topic_id = "", _token) {
                        $.ajax({
                            url: "{{ route('user.topics.load.sections.topics',['id'=> request('id')]) }}",
                            method: "POST",
                            data: {section_id: section_id,topic_id: topic_id, _token: _token, id: "{{request('id')}}"},
                            success: function (data) {
                                $('#load_more_user_forum_sections_topics_button').remove();
                                $('#load_more_user_forum_sections_topics').append(data);
                            }
                        })
                    }

                    $(document).on('click', '#load_more_user_forum_sections_topics_button', function () {
                        let section_id = $(this).data('section_id');
                        let topic_id = $(this).data('topic_id');
                        $('#load_more_user_forum_sections_topics_button').html('<b>Загрузка...</b>');
                        load_more_user_forum_sections_topics(section_id,topic_id, _token);
                    });
                }
            );

    </script>
@endsection
