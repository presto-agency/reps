@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-topics',request('id')) }}
@endsection

@section('sidebar-left')
    @include('components.interview')
    @include('left-side.search-replays')
@endsection

@section('content')
    <div id="load_more_forum_sections"></div>
    @include('user.topics.components.index')
@endsection

@section('right-side')
    @parent
    @include('right-side.components.last-replay')
@endsection
{{--@section('ess21-custom-script')--}}
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--                let _token = $('input[name="_token"]').val();--}}
{{--                load_more_forum_sections('', _token);--}}

{{--                function load_more_forum_sections(section_id = "", _token) {--}}
{{--                    $.ajax({--}}
{{--                        url: "{{ route('load.more.forum.sections',['id'=>request('id')]) }}",--}}
{{--                        method: "POST",--}}
{{--                        data: {section_id: section_id, _token: _token, id: "{{request('id')}}"},--}}
{{--                        success: function (data) {--}}
{{--                            $('#load_more_forum_sections_button').remove();--}}
{{--                            $('#load_more_forum_sections').append(data);--}}
{{--                        }--}}
{{--                    })--}}
{{--                }--}}

{{--                $(document).on('click', '#load_more_forum_sections_button', function () {--}}
{{--                    let section_id = $(this).data('id');--}}
{{--                    $('#load_more_forum_sections_button').html('<b>Загрузка...</b>');--}}
{{--                    load_more_forum_sections(section_id, _token);--}}
{{--                });--}}
{{--            }--}}
{{--        );--}}
{{--    </script>--}}
{{--@endsection--}}