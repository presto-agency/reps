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
            <h3 class="box-title text-blue">{{__('Заголовок секция | ')}}{{$topic->forumSection->title}}</h3>
            <hr>
            <h4 class="box-title text-blue">{{__('Заголовок топик | ')}} {!! ParserToHTML::toHTML($topic->title,'size') !!}</h4>
            <hr>
        </div>
        <div class="box-body">
            <div class="box-tools col-md-12">
                <div class="post">
                    <hr>
                    <h4>{{__('Картинка превю')}}</h4>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 preview-image-wrapper text-center">
                            @if($topic->preview_img)
                                <img class="img-bordered-sm" src="{{ asset($topic->preview_img) }}" alt="user image">
                            @endif
                        </div>
                    </div>
                    <hr>
                    <br>
                    <h4>{{__('Контетн превю')}}</h4>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            {!! ParserToHTML::toHTML(clean($topic->preview_content),'size') !!}
                        </div>
                    </div>
                    <hr>
                    <br>
                    <h4>{{__('Контетн')}}</h4>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            {!! ParserToHTML::toHTML(clean($topic->content),'size') !!}
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset($topic->author->avatarOrDefault())}}"
                             alt="avatar">
                        {{--                            <img class="img-circle img-bordered-sm" src="{{route('news').'/dist/img/avatar.png'}}" alt="User img">--}}
                        <span class="username">
{{--                            <a href="#{{route('admin.user.profile', ['id' => $topic->author->id])}}">{{$topic->author->name}}</a>--}}
                        </span>
                        <span class="description">{{$topic->created_at->format('H:i d.m.Y')}}</span>
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
                            @if(isset($topic->comments) && !empty($topic->comments))
                                @foreach($topic->comments as $comment)
                                    <div class="item row">
                                        @if(auth()->check() && auth()->user()->userViewAvatars())
                                            <img class="img-circle img-bordered-sm"
                                                 src="{{asset($comment->user->avatarOrDefault())}}" alt="avatar">
                                        @endif
                                        @guest()
                                            <img class="img-circle img-bordered-sm"
                                                 src="{{asset($comment->user->avatarOrDefault())}}" alt="avatar">
                                        @endguest()
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i
                                                        class="fa fa-clock-o"></i> {{$comment->created_at->format('H:i d.m.Y')}}
                                                </small>
                                                {{$comment->user->name}}
                                            </a>
                                            {{--<a type="button" class="btn btn-default text-red"  title="Удалить запись" href="#{{route('admin.comments.remove', ['id' => $comment->id])}}"><i class="fa fa-trash"></i></a>--}}
                                            {!! ParserToHTML::toHTML(clean($comment->content),'size') !!}
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="box-footer clearfix pagination-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

