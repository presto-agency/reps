<div class="container">
    <h4>{{$userGallery->sign}}</h4>
    <br>
    <div class="row">
        <div class="col-4 text-center">
            <img class="img-bordered-sm" src="{{asset($userGallery->pictureOrDefault())}}" alt="picture">
        </div>

        <div class="col-3 text-center">
            <span class="username">
                <a href="">{{$userGallery->users->name}}</a>
            </span>
        </div>
    </div>
    <div class="icon_wrapper">
        <div class="row">
            <div class="col-12 container_user">
                <img class="avatar img-circle img-bordered-sm" src="{{asset($userGallery->users->avatarOrDefault())}}"
                     alt="User avatar"/>
                <div class="block_text">
                    <a class="username" href="#">{{$userGallery->users->name}}</a>
                    <span class="date">{{ $userGallery->created_at->format('H:i d.m.Y') }}</span>
                </div>
            </div>
            <div class="col-12 container_icon">
                <i class="far fa-thumbs-up" style="color: green;">{{$userGallery->positive_count}}</i>
                <i class="far fa-thumbs-down" style="color: red;">{{$userGallery->negative_count}}</i>
                <i class="far fa-comment"style="color: green;">{{$userGallery->commentsCount()}}</i>
            </div>
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
                    <div class="row coments_row">
                        <div class="col-6 container_user">
                            <img class="avatar img-circle img-bordered-sm" src="{{asset($comment->user->avatarOrDefault())}}"
                                 alt="User avatar"/>
                            <div class="block_text">
                                <a class="username" href="#">{{$comment->user->name}}</a>
                                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.usergallery.comment_delete', 'id' => $comment->id], 'name' => 'delete']) }}
                                <div class="block_btn">
                                    <button class="btn btn-default text-red" title="Удалить запись"><i
                                            class="fa fa-trash"></i></button>
                                    {!! ParserToHTML::toHTML(clean($comment->content),'size') !!}
                                </div>

                                {{ Form::close() }}

                            </div>

                        </div>
                        <div class="col-6 container_icon">
                            <span class="date">{{$comment->created_at->format('H:i d.m.Y')}}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
