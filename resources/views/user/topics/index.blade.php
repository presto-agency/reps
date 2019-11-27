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

        $(document).ready(function () {
            /**
             *
             * Ajax Load ForumSections
             */
            let _token = $('input[name="_token"]').val();
            load_more_user_forum_sections('', _token);

            function load_more_user_forum_sections(section_id = "", _token) {
                $.ajax({
                    url: "{{ route('user.topics.load.sections',['id'=> request('id')]) }}",
                    method: "POST",
                    data: {section_id: section_id, _token: _token, id: "{{request('id')}}"},
                    success: function (data, section_id) {
                        /**
                         *
                         * Ajax Load ForumTopics for Sections
                         */
                        $('#load_more_user_forum_sections_button').remove();
                        $('#load_more_user_forum_sections').append(data);

                        /**
                         * Check first or second click
                         */
                        $('.loadTopics').one("click", loadAjaxData);

                        function loadAjaxData() {
                            alert("Run and show first slick");
                            /**
                             * First click load Data show list
                             */
                            let value = localStorage.getItem('count'),
                                newValue = isFinite(value) ? ++value : 0;
                            localStorage.setItem('count', newValue);

                            let forum_section_id = $(this).data('forum_section_id');
                            let getIdSection = '#load_more_user_forum_sections_topics_' + forum_section_id;

                            load_more_user_forum_sections_topics(forum_section_id, '','', _token);

                            function load_more_user_forum_sections_topics(forum_section_id, topic_id = "", user_id = "", _token) {
                                $.ajax({
                                    url: "{{ route('user.topics.load.sections.topics',['id'=> request('id')]) }}",
                                    method: "POST",
                                    data: {
                                        forum_section_id: forum_section_id,
                                        topic_id: topic_id,
                                        user_id: user_id,
                                        _token: _token,
                                        id: "{{request('id')}}"
                                    },
                                    success: function (data) {
                                        $('#load_more_user_forum_sections_topics_button').remove();
                                        $(getIdSection).append(data);
                                    }
                                })
                            }

                            $(document).on('click', '#load_more_user_forum_sections_topics_button', function () {
                                let topic_id = $(this).data('topic_id');
                                let user_id = $(this).data('user_id');
                                $('#load_more_user_forum_sections_topics_button').html('<b>Загрузка...</b>');
                                load_more_user_forum_sections_topics(forum_section_id, topic_id, user_id, _token);
                            });
                            /**
                             * Second click  hidden list and stop script
                             */
                            $('.loadTopics').on("click", function () {
                                alert("Stop and hidden second slick");
                                return false;
                            });
                        }
                    }
                })
            }

            $(document).on('click', '#load_more_user_forum_sections_button', function () {
                let section_id = $(this).data('section_id');
                $('#load_more_user_forum_sections_button').html('<b>Загрузка...</b>');
                load_more_user_forum_sections(section_id, _token);
            });

        });

    </script>
@endsection
