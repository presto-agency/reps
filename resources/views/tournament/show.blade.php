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




@section('custom-script')
    @parent
    @if(auth()->check() && auth()->user()->isNotBan() && auth()->user()->isVerified() && $tournament::$status[$tournament->status] == 'REGISTRATION')
        @if(empty($tournament->player))
            <script type="text/javascript" defer>
                function tournamentRegister() {
                    let description = document.getElementById('description').value;
                    if (description !== '') {
                        $.ajax({
                            url: '{{ route('tournament.register') }}',
                            method: "POST",
                            data: {
                                _token: '{{csrf_token()}}',
                                description: description,
                                tourneyId: '{{request('tournament')}}',
                            },
                            success: function (data) {
                                if (data.success === true) {
                                    $("#tournamentRegister").remove();
                                    $("#description_success").removeClass('d-none').html(data.message);
                                }
                            },
                            errors: function (data) {
                                if (data.success === false) {
                                    $("#tournamentRegister").remove();
                                    $("#description_error").removeClass('d-none').html(data.message);
                                }
                                if (data.responseJSON.errors.description) {
                                    $("#description_error").removeClass('d-none').html(data.responseJSON.errors.description);
                                }
                                if (data.responseJSON.errors.tourneyId) {
                                    $("#description_error").removeClass('d-none').html(data.responseJSON.errors.tourneyId);
                                }
                            }
                        })
                    }
                }
            </script>
        @endif
    @endif
@endsection


