@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-index') }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    @auth()
        @include('user.gallery.components.create')
    @endauth
    <div id="load_more_galleries"></div>
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
@section('ess21-custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
                let _token = $('input[name="_token"]').val();
                load_more_galleries('', _token);

                function load_more_galleries(id = "", _token) {
                    $.ajax({
                        url: "{{ route('load.more.galleries') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            $('#load_more_galleries_button').remove();
                            $('#load_more_galleries').append(data);
                        }
                    })
                }

                $(document).on('click', '#load_more_galleries_button', function () {
                    let id = $(this).data('id');
                    $('#load_more_galleries_button').html('<b>Загрузка...</b>');
                    load_more_galleries(id, _token);
                });
            }
        );
    </script>
@endsection
