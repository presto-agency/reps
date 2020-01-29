@if($existAll)
    <h4>Для данного турнира уже созданы все раунды с типом
        <strong>Single-elimination tournament</strong>
    </h4>
@else
    <h4>Для данного турнира можна создать следущие кол-во раундов {{$rounds['canCreate']}} с типом
        <strong>Single-elimination tournament</strong>
    </h4>

@endif
@if($tourney->matches_count == 0)
    <div class="alert alert-info" role="alert">
        <strong>
            {{__('У данного турнира нету матчей сначало нужно создать матч для раунда 1.')}}
        </strong>
    </div>
@endif
@foreach($rounds['rounds'] as $key => $item)


    @if($item['number'] == 1 && !$item['exist'])
        {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
        <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
        <input type="hidden" name="type" tabindex="-1" value="{{$type}}">
        <input type="hidden" name="round" tabindex="-1" value="1">
        {!! Form::button('Создать матчи для раунда '.$item['number'],['type' => 'submit','class'=>'btn btn-primary'])!!}
        {!! Form::close() !!}
        <br>
    @endif
    @if($item['number'] == 1 && $item['exist'])
        <div class="alert alert-info" role="alert">
            <strong> {{__('Матчи для раунда '.$item['number'].' уже созданы')}}
                <a href="{{url('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['number'])}}"
                   class="alert-link">
                    {{__('Смотреть список')}}
                </a>
            </strong>
        </div>
    @endif
    @if($item['number'] > 1 && !$item['exist'] && $item['previousExist'])

        {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
        <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
        <input type="hidden" name="type" tabindex="-1" value="{{$type}}">
        <input type="hidden" name="round" tabindex="-1" value="{{$item['number']}}">
        {!! Form::button('Создать матчи для раунда '.$item['number'],['type' => 'submit','class'=>'btn btn-primary'])!!}
        {!! Form::close() !!}
        <br>
    @endif
    @if($item['number'] > 1 && $item['exist'])
        <div class="alert alert-info" role="alert">
            <strong> {{__('Матчи для раунда '.$item['number'].' уже созданы')}}
                <a href="{{url('admin\tourney_matches'.'?tourney_id='.$tourney->id.'&round_number='.$item['number'])}}"
                   class="alert-link">
                    {{__('Смотреть список')}}
                </a>
            </strong>
        </div>
    @endif

@endforeach

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>{{$errors->first()}}</strong>
    </div>
@endif
@if (session('single-match-success'))
    <div class="alert alert-success">
        <strong> {{ session('single-match-success') }}</strong>
    </div>
@endif

