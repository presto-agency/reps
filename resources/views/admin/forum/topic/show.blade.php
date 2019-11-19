<div class="col-md-10 col-md-offset-1">
    <div class="load-wrapp">
        <div class="load-3">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title text-blue">{{$topic->forumSection->title}} / {!! $topic->title !!}</h3>
        </div>
        <div class="box-body">
            <div class="box-tools col-md-12">
                <div class="post">
                    @if($topic->preview_img)
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 preview-image-wrapper text-center">
                                <img class="img-bordered-sm" src="{{ asset($topic->preview_img) }}" alt="user image">
                            </div>
                        </div>
                        <br>
                    @endif
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                {!! $topic->preview_content !!}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>
                                {!! $topic->content !!}
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="user-block">
                        @if(auth()->user()->userViewAvatars())
                            @if(!empty($topic->author->avatar) && file_exists($topic->author->avatar))
                                <img class="img-circle img-bordered-sm" src="{{asset($topic->author->avatar)}}"
                                     alt="avatar">
                            @else
                                <img class="img-circle img-bordered-sm" src="{{asset($topic->author->defaultAvatar())}}"
                                     alt="avatar">
                            @endif
                        @endif
                        {{--                            <img class="img-circle img-bordered-sm" src="{{route('news').'/dist/img/avatar.png'}}" alt="User img">--}}
                        <span class="username">
{{--                            <a href="#{{route('admin.user.profile', ['id' => $topic->author->id])}}">{{$topic->author->name}}</a>--}}
                        </span>
                        <span class="description">{{$topic->created_at->format('h:m d.m.Y')}}</span>
                    </div>

                    <ul class="list-inline">
                        <li class="pull-right">
                            <p class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i>
                                {{$topic->comments_count}}</p></li>
                        <li class="pull-right">
                            <p class="link-black text-sm"><i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>
                                {{$topic->negative_count}}</p></li>
                        <li class="pull-right">
                            <p class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>
                                {{$topic->positive_count}}</p></li>
                    </ul>
                    <br>
                    <div>
                        <div class="box-body chat" id="chat-box">
                            <div class="box-footer">
                                <form method="POST"
                                      action="{{route('admin.forum.topic.comment_send', ['id' => $topic->id])}}"
                                      method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Type message..." type="text"
                                               name="content">

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-content">
                                @foreach($topic->comments as $comment)
                                    <div class="item row">
                                        @if(auth()->user()->userViewAvatars())
                                            @if(!empty($comment->user->avatar) && file_exists($comment->user->avatar))
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{asset($comment->user->avatar)}}" alt="avatar">
                                            @else
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{asset($comment->user->defaultAvatar())}}" alt="avatar">
                                            @endif
                                        @endif
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i
                                                        class="fa fa-clock-o"></i> {{$comment->created_at->format('h:m d.m.Y')}}
                                                </small>
                                                {{$comment->user->name}}
                                            </a>
                                            {{--<a type="button" class="btn btn-default text-red"  title="Удалить запись" href="#{{route('admin.comments.remove', ['id' => $comment->id])}}"><i class="fa fa-trash"></i></a>--}}
                                            {!! $comment->content !!}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="box-footer clearfix pagination-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

