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
    <div id="load_user-gallery-list"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection

@section('custom-script')
    @parent
    <script type="text/javascript" defer>
        $(document).ready(function () {
                loadUserGallery('',);

                function loadUserGallery(id = '',) {
                    $.ajax({
                        url: '{{ route('load.more.user.images',['id'=>request('id')]) }}',
                        method: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            user_id: '{{request('id')}}',
                            id: id,
                        },

                        success: function (data) {
                            $('#load_more_user_gallery').remove();
                            $('#load_user-gallery-list').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_user_gallery', function () {
                    $('#load_more_user_gallery').html('<b>Загрузка...</b>');
                    loadUserGallery($(this).data('id'));
                });
            }
        );
    </script>
@endsection
