@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-comments',request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.comments.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('ess21-custom-script')
    <script type="text/javascript">
        /**
         * Check first or second click
         */
        $(document).ready(function () {
            /**
             * Check first or second click
             */
            $('.loadUserPosts').one("click", loadAjaxData);

            function loadAjaxData() {
                // alert("Run and show first slick");
                let _token = $('input[name="_token"]').val();
                let relation_id = $(this).data('relation_id');
                let setSectionName = '#load_more_user_posts_' + relation_id;

                load_more_user_posts(relation_id, '', _token);

                function load_more_user_posts(relation_id, comment_id = '', _token) {
                    $.ajax({
                        url: "{{ route('user.comments.load.sections.comments',['id'=> request('id')]) }}",
                        method: "POST",
                        data: {
                            relation_id: relation_id,
                            comment_id: comment_id,
                            _token: _token,
                            id: "{{request('id')}}"
                        },
                        success: function (data) {
                            $('#load_more_user_posts_button').remove();
                            $(setSectionName).append(data);
                        }
                    })
                }
                $(document).on('click', '#load_more_user_posts_button', function () {
                    let relation_id = $(this).data('relation_id');
                    let comment_id = $(this).data('comment_id');
                    $('#load_more_user_posts_button').html('<b>Загрузка...</b>');
                    load_more_user_posts(relation_id, comment_id, _token);
                });
                /**
                 * Second click  hidden list and stop script
                 */
                // $('.loadUserPosts').on("click", function () {
                //     alert("Stop and hidden second slick");
                //     return false;
                // });
            }
        });
    </script>
@endsection
