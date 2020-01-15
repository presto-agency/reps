@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('tournament-show') }}
@endsection

@section('sidebar-left')
    @include('left-side.navigation-replays')
    @include('left-side.search-replays')
@endsection

@section('content')
    @include('tournament.components.show')
@endsection



@if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified())
@section('custom-script')
    @parent
    <script type="text/javascript">

        function tournamentRegister() {
            $.ajax({
                url: '{{ route('tournament.register') }}',
                method: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    description: 'ayayayaya',
                    tourney_id: '{{request('tournament')}}',
                },
                success: function (data) {
                    $('#load_more-tournament').remove();
                    $('#load_tournament-list').append(data);
                }
            })
        }
    </script>

@endsection
@endif

