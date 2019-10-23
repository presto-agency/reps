<div class="container">
    <div class="row">
        <div class="col-md-3 text-center">
            <img class="img-bordered-sm" src="{{asset($replay->maps->url)}}" alt="map">
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2">
                    <p>Название:</p>
                </div>
                <div class="col-md-10">
                    <a href="#">
                        <p>{{$replay->user_replay}}</p>
                    </a>
                </div>
                <div class="col-md-2">
                    <p>Страны:</p>
                </div>
                <div class="col-md-10">
                    <p>{{$replay->firstCountries->name}} vs {{$replay->secondCountries->name}}</p>
                </div>
                <div class="col-md-2">
                    <p>Игроки:</p>
                </div>
                <div class="col-md-10">
                    <p>{{$replay->first_name}} vs {{$replay->second_name}}</p>
                </div>
                <div class="col-md-2">
                    <p>Расы:</p>
                </div>
                <div class="col-md-10">
                    <p>{{$replay->firstRaces->title}} vs {{$replay->secondRaces->title}}</p>
                </div>
                <div class="col-md-2">
                    <p>Локация:</p>
                </div>
                <div class="col-md-10">
                    <p>{{$replay->first_location}} vs {{$replay->second_location}}</p>
                </div>
                <div class="col-md-2">
                    <p>Дата:</p>
                </div>
                <div class="col-md-10">
                    <p>{{$replay->start_date}}</p>
                </div>
                <div class="col-md-2">
                    <p>Оценка пользователей:</p>
                </div>
                <div class="col-md-10">
                    <a type="button" title="Посмотреть" data-toggle="modal" data-target="#modal-default"
                       href="#">
                        <p>{{$replay->user_rating}}</p>
                    </a>
                </div>
                <div class="col-md-2">
                    <p>Подтвержден:</p>
                </div>
                <div class="col-md-10">
                    <p>{!!$replay->approved == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-minus'></i>"!!}</p>
                </div>
                <div class="col-md-2">
                    <p>Файл:</p>
                </div>
                <div class="col-md-10">
                    <a href="{{route('replay.download', ['id' => $replay->id])}}">Скачать Replay</a>
                </div>
                <div class="col-md-2">
                    <p>Контент:</p>
                </div>
                <div class="col-md-10">
                    {!! $replay->content !!}
                </div>
            </div>
            <div class="box-container">
                <div class="box-header">
                    {{ Form::open(['method' => 'POST', 'route' => ['admin.replays.comment_send', 'id' => $replay->id]]) }}
                    <div class="input-group">
                        <input class="form-control" placeholder="Коментарий" type="text" name="content">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="box-body">
                    @foreach($replay->comments as $comment)
                        <div class="item row">
                            <img src="{{$comment->user->avatar_url_or_blank}}"
                                 class="img-circle img-bordered-sm" alt="User avatar"/>
                            <p class="message">
                                <a href="#" class="name">
                                    <small class="text-muted pull-right"><i
                                            class="fa fa-clock-o"></i> {{$comment->created_at->format('h:m d-m-Y')}}
                                    </small>
                                    {{$comment->user->name}}
                                </a>
                                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.replays.comment_delete', 'id' => $comment->id], 'name' => 'delete']) }}
                                <button class="btn btn-default text-red" title="Удалить запись"><i
                                        class="fa fa-trash"></i></button>
                                {{ Form::close() }}
                                {!! $comment->content !!}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
