@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-index') }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_galleries-list"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
@section('custom-script')
    @parent
    <script type="text/javascript" defer>
        $(document).ready(function () {
                loadGalleries('',);

                function loadGalleries(id = '',) {
                    $.ajax({
                        url: '{{ route('load.more.images') }}',
                        method: "POST",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (data) {
                            $('#load_more_galleries').remove();
                            $('#load_galleries-list').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_galleries', function () {
                    $('#load_more_galleries').html('<b>Загрузка...</b>');
                    loadGalleries($(this).data('id'));
                });
            }
        );
    </script>
@endsection
