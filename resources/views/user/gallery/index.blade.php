@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-gallery-index', request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('user.gallery.components.create')
    {{--    @include('user.gallery.components.index')--}}
    <div id="load_more_user_gallery"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
                let _token = $('input[name="_token"]').val();
                load_more_user_gallery('', _token);

                function load_more_user_gallery(find_id = "", _token) {
                    $.ajax({
                        url: "{{ route('load.more.user.gallery',['id'=>request('id')]) }}",
                        method: "POST",
                        data: {find_id: find_id, _token: _token, id: "{{request('id')}}"},
                        success: function (data) {
                            $('#load_more_user_gallery_button').remove();
                            $('#load_more_user_gallery').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_user_gallery_button', function () {
                    let find_id = $(this).data('id');
                    $('#load_more_user_gallery_button').html('<b>Загрузка...</b>');
                    load_more_user_gallery(find_id, _token);
                });
            }
        );
    </script>
@endsection
