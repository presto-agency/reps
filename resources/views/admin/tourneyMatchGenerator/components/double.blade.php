<div class="alert alert-secondary" role="alert">
    <h4>{{__('Тип турнира: ')}}<strong><i>{{__('Double-elimination tournament.')}}</i></strong></h4>
    <hr>
    <p>{{__('В даном турнире уже создано слледущие кол-во раундов:')}}
        <strong>{{$data['roundsNowCreate']}}</strong>
    </p>
    <hr>
    <p>{{__('В даном турнире осталось игроков:')}}
        <strong>{{$data['allPlayers']}}</strong>
    </p>
    <hr>
</div>

@if($data['allMatches'] < 1)
    <div class="alert alert-info" role="alert">
        <strong>{{__('У данного турнира нету матчей можна создавать.')}}</strong>
    </div>
@endif

@foreach($data['rounds'] as $key => $item)
    @if($item['roundNumber'] == 1)
        @if(!$item['roundExist'])
            {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
            <input type="hidden" name="id" tabindex="-1" value="{{$tourney->id}}">
            <input type="hidden" name="type" tabindex="-1" value="{{$tourney->type}}">
            <input type="hidden" name="round" tabindex="-1" value="{{$item['roundNumber']}}">
            {!! Form::button('Создать матчи для раунда '.$item['roundNumber'],['type' => 'submit','class'=>'btn btn-primary'])!!}
            {!! Form::close() !!}
            <br>
        @else
            <div class="alert alert-info" role="alert">
                <strong> {{__('Матчи для раунда '.$item['roundNumber'].' уже созданы')}}
                    <a href="{{asset('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['roundNumber'])}}"
                       class="alert-link">{{__('Смотреть список')}}
                    </a>
                </strong>
            </div>
        @endif
    @endif
    @if($item['roundExist'])
        <div class="alert alert-info" role="alert">
            <strong> {{__('Матчи для раунда '.$item['roundNumber'].' уже созданы')}}
                <a href="{{asset('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['roundNumber'])}}"
                   class="alert-link">{{__('Смотреть список')}}
                </a>
            </strong>
        </div>
    @endif
    @if(!$item['roundExistNext'] && $item['roundExist'])
        {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
        <input type="hidden" name="id" tabindex="-1" value="{{$tourney->id}}">
        <input type="hidden" name="type" tabindex="-1" value="{{$tourney->type}}">
        <input type="hidden" name="round" tabindex="-1" value="{{$item['roundNumberNext']}}">
        {!! Form::button('Создать матчи для раунда '.$item['roundNumberNext'],['type' => 'submit','class'=>'btn btn-primary'])!!}
        {!! Form::close() !!}
        <br>
    @endif


@endforeach
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('single-match-success'))
    <div class="alert alert-success" role="alert">
        <strong> {{ session('single-match-success') }}</strong>
    </div>
@endif
