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
         * Ajax Load Request
         */
        function loadAjaxData(relation_id, comment_id = '', _token, panel= '') {
            $.ajax({
                url: "{{ route('user.comments.load.sections.comments',['id'=> request('id')]) }}",
                method: "POST",
                data: {
                    relation_id: relation_id,
                    comment_id: comment_id,
                    _token: _token,
                },
                success: function (data) {
                    let div_id = '#load_more_user_posts_' + relation_id;
                    let button_id =  '#load_more_user_posts_button_' + relation_id;
                    $(button_id).remove();
                    $(div_id).append(data);
                }
            });

        }
            $.ready(button_event);
        function button_event2(relation_id,comment_id) {
            let button_id = '#load_more_user_posts_button_' + relation_id;
            let _token = $('input[name="_token"]').val();
            $(button_id).html('<b>Загрузка...</b>');
            loadAjaxData(relation_id, comment_id, _token,'');
        }
    </script>
@endsection
