<div class="container">
    <div class="row">
        <div class="col-md-3 text-center">
            @if(!empty($replay->maps->url))
                <img style="width: 100%" class="img-bordered-sm" src="{{asset($replay->maps->url)}}" alt="map">
            @else
                <img style="width: 100%" class="img-bordered-sm" src="{{asset($replay->maps->defaultMap)}}" alt="map">
            @endif
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2">
                    <p>Название:</p>
                </div>
                <div class="col-md-10">
                    <a href="{{route('replay.show',['replay'=>$replay->id])}}">
                        <p>{{$replay->title}}</p>
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
                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('admin-downloadReplay').submit();">{{__('Скачать Replay')}}</a>
                    <form id="admin-downloadReplay"
                          action="{{route('admin.replay.download', ['id' => $replay->id])}}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </div>
                <div class="col-md-2">
                    <p>Контент:</p>
                </div>
                <div class="col-md-10">
                    {!! ParserToHTML::toHTML($replay->content,'size') !!}
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
                <div class="table-content">
                    @if(!empty($replay->comments))
                        @foreach($replay->comments as $comment)
                            <div class="item row">
                                <img src="{{asset($comment->user->avatarOrDefault())}}"
                                     class="img-circle img-bordered-sm"
                                     alt="avatar"/>
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right"><i
                                                class="fa fa-clock-o"></i> {{$comment->created_at->format('H:i d.m.Y')}}
                                        </small>
                                        {{$comment->user->name}}
                                    </a>
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['admin.replays.comment_delete', 'id' => $comment->id], 'name' => 'delete']) }}
                                    <button class="btn btn-default text-red" title="Удалить запись"><i
                                            class="fa fa-trash"></i></button>
                                    {{ Form::close() }}
                                    {!! ParserToHTML::toHTML($comment->content,'size') !!}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
