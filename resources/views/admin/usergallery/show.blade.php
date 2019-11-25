<div class="container">
    <h4>{{$userGallery->sign}}</h4>
    <br>
    <div class="row">
        <div class="col-md-3 text-center">
                <img class="img-bordered-sm" src="{{asset($userGallery->pictureOrDefault())}}" alt="picture">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center">
            <span class="username">
                    <img src="{{asset($userGallery->users->avatarOrDefault())}}" class="img-circle img-bordered-sm"
                         alt="User avatar"/>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center">
            <span class="username">
                <a href="">{{$userGallery->users->name}}</a>
            </span>
        </div>
        <div class="col-md-3 text-center positive_count">
            <span style="font-size: 2em; color: green;">
                <i class="far fa-thumbs-up">{{$userGallery->positive_count}}</i>
            </span>
        </div>
        <div class="col-md-3 text-center negative_count">
            <span style="font-size: 2em; color: red;">
                <i class="far fa-thumbs-down">{{$userGallery->negative_count}}</i>
            </span>
        </div>
        <div class="col-md-3 text-center comments_count">
            <span style="font-size: 2em;">
                <i class="far fa-comment">{{$userGallery->commentsCount()}}</i>
             </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center">
            <p class="date">{{ $userGallery->created_at->format('h:m d.m.Y') }}</p>
        </div>
    </div>
    <div class="box-container">
        <div class="box-header">
            {{ Form::open(['method' => 'POST', 'route' => ['admin.usergallery.comment_send', 'id' => $userGallery->id]]) }}
            <div class="input-group">
                <input class="form-control" placeholder="Коментарий" type="text" name="content">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
        <div class="box-body">
            @if( isset($userGallery->comments) && !empty($userGallery->comments))
                @foreach($userGallery->comments as $comment)
                    <div class="item row">
                            <img src="{{asset($comment->user->avatarOrDefault())}}" class="img-circle img-bordered-sm"
                                 alt="User avatar"/>
                        <p class="message">
                            <a href="#" class="name">
                                <small class="text-muted pull-right"><i
                                            class="fa fa-clock-o"></i> {{$comment->created_at->format('h:m d.m.Y')}}
                                </small>
                                {{$comment->user->name}}
                            </a>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['admin.usergallery.comment_delete', 'id' => $comment->id], 'name' => 'delete']) }}
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
