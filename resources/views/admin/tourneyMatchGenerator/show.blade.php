<p>
    {{__("Для данного турнира можна создать следущие кол-во раундов $rounds с типом <Single-elimination tournament> ")}}
</p>
@if($tourney->matches->isEmpty())
    {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
    <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
    <input type="hidden" name="type" tabindex="-1" value="{{$type}}">
    <input type="hidden" name="round" tabindex="-1" value="1">
    {!! Form::button("Создать матчи для раунда 1",["type" => "submit","class"=>"btn btn-primary"])!!}
    {!! Form::close() !!}
    <br>
    <div class="alert alert-info" role="alert">
        <strong>
            {{__('У данного турнира нету матчей сначало нужно создать матч для раунда 1.')}}
        </strong>
    </div>
@else
    <div class="alert alert-info" role="alert">
        <strong> {{__('Матчи для раунда 1 уже созданы')}}
            <a href="{{url('admin\tourney_matches'.'?tourney_id='.$tourney->id)}}" class="alert-link">
                {{__('Смотреть список')}}
            </a>
        </strong>
    </div>
    @if($rounds >1)
        @for($i=2;$i <= $rounds;$i++)

            {!! Form::open(['method' => 'POST', 'route' => ['admin.tourney.match.generator']]) !!}
            <input type="hidden" name="id" tabindex="-1" value="{{request('id')}}">
            <input type="hidden" name="type" tabindex="-1" value="{{$type}}">
            <input type="hidden" name="round" tabindex="-1" value="{{$i}}">
            {!! Form::button("Создать матчи для раунда $i",["type" => "submit","class"=>"btn btn-primary"])!!}
            {!! Form::close() !!}
            <br>
        @endfor
    @endif
@endif






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
