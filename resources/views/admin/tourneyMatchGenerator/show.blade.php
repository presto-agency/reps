<div class="container">

    @if($tourney->type == $tourney::TYPE_SINGLE)
        @if($tourney::$status[$tourney->status] === 'STARTED' && $data['allPlayers'] >= 1)
            @include('admin.tourneyMatchGenerator.components.single')
        @endif
        <div class="alert alert-warning" role="alert">
            <strong>  {{ __('При создании "раундов > 1" выбраны будут только те игроки которые "победили" и с матчей который "сыграны".') }}</strong>
        </div>
        @if($tourney::$status[$tourney->status] !== 'STARTED')
            <div class="alert alert-secondary" role="alert">
                <h4>{{__('Статус турнира не ')}}<strong>{{__('STARTED')}}</strong></h4>
            </div>
        @endif
        @if($data['allPlayers'] < 1)
            <div class="alert alert-secondary" role="alert">
                <h4>{{__('Количество игроков не позволяет создавать матчи')}}</h4>
            </div>
        @endif
    @endif
    @if($tourney->type == $tourney::TYPE_DOUBLE)
        @if($tourney::$status[$tourney->status] === 'STARTED' && $data['allPlayers'] >= 1)
            @include('admin.tourneyMatchGenerator.components.double')
        @endif
        <div class="alert alert-warning" role="alert">
            <strong>  {{ __('При создании "раундов > 1" выбраны будут только те игроки которые "победили" и с матчей который "сыграны".') }}</strong>
        </div>
        @if($tourney::$status[$tourney->status] !== 'STARTED')
            <div class="alert alert-secondary" role="alert">
                <h4>{{__('Статус турнира не ')}}<strong>{{__('STARTED')}}</strong></h4>
            </div>
        @endif
        @if($data['allPlayers'] < 1)
            <div class="alert alert-secondary" role="alert">
                <h4>{{__('Количество игроков не позволяет создавать матчи')}}</h4>
            </div>
        @endif
    @endif
</div>
