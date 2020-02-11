<div class="alert alert-secondary" role="alert">
    <h4>{{__('Тип турнира: ')}}<strong><i>{{__('Single-elimination tournament.')}}</i></strong></h4>
    <hr>
    <p>{{__('В даном турнире можна создать слледущие кол-во раундов:')}}
        <strong>{{$data['roundsCanCreate']}}</strong>
    </p>
    <hr>
    <p>{{__('В даном турнире уже создано слледущие кол-во раундов:')}}
        <strong>{{$data['roundsNowCreate']}}</strong>
    </p>
    <hr>
    <p>{{__('В даном турнире осталось создать слледущие кол-во раундов:')}}
        <strong>{{$data['roundsLeftCreate']}}</strong></p>
    <hr>
    @if($data['roundsLeftCreate'] == 0)
        <p>{{__('Для данного турнира созданы все раунды.')}}</p>
        <hr>
    @endif
</div>

@if($tourney->matches_count < 1)
    <div class="alert alert-info" role="alert">
        <strong>{{__('У данного турнира нету матчей можна создавать.')}}</strong>
    </div>
@endif

@foreach($data['rounds'] as $key => $item)

    @if($item['number'] == 1)
        @if(!$item['exist'])
            {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
            <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
            <input type="hidden" name="type" tabindex="-1" value="{{\App\Models\TourneyList::TYPE_SINGLE}}">
            <input type="hidden" name="round" tabindex="-1" value="{{$item['number']}}">
            {!! Form::button('Создать матчи для раунда '.$item['number'],['type' => 'submit','class'=>'btn btn-primary'])!!}
            {!! Form::close() !!}
            <br>
        @else
            <div class="alert alert-info" role="alert">
                <strong> {{__('Матчи для раунда '.$item['number'].' уже созданы')}}
                    <a href="{{asset('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['number'])}}"
                       class="alert-link">{{__('Смотреть список')}}
                    </a>
                </strong>
            </div>
        @endif
    @else
        @if(!$item['exist'] && $item['previousExist'])
            {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
            <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
            <input type="hidden" name="type" tabindex="-1" value="{{\App\Models\TourneyList::TYPE_SINGLE}}">
            <input type="hidden" name="round" tabindex="-1" value="{{$item['number']}}">
            {!! Form::button('Создать матчи для раунда '.$item['number'],['type' => 'submit','class'=>'btn btn-primary'])!!}
            {!! Form::close() !!}
            <br>
        @endif
        @if($item['exist'] && $item['previousExist'])
            <div class="alert alert-info" role="alert">
                <strong> {{__('Матчи для раунда '.$item['number'].' уже созданы')}}
                    <a href="{{asset('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['number'])}}"
                       class="alert-link">{{__('Смотреть список')}}
                    </a>
                </strong>
            </div>
        @endif
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
