<div class="container_round">
    <div class="row winner_round">
        <div class="col-xl-1 col-lg-1 col-md-1 col-1  left_block">
            <span>{{'#'.$item->match_number }}</span>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-7 center_block">
            @if(!empty($item->player1->user))
                <div class="one_player">
                    @if(auth()->check() && auth()->user()->userViewAvatars())
                        <img src="{{asset($item->player1->user->avatarOrDefault())}}"
                             class="icon_bars" alt="avatar">
                    @endif
                    @guest
                        <img src="{{asset($item->player1->user->avatarOrDefault())}}"
                             class="icon_bars" alt="avatar">
                    @endguest
                    <span title="{{$item->player1->description}}">
                        {{$item->player1->description}}
                    </span>
                </div>
            @else
                {{__('- FreeSlot -')}}
            @endif
            @if($item->player1_score > $item->player2_score)
                <span class="blue_span">
                    {{$item->player1_score.' > ' .$item->player2_score}}
                </span>
            @endif
            @if($item->player1_score < $item->player2_score)
                <span class="blue_span">
                    {{$item->player1_score.' < ' .$item->player2_score}}
                </span>
            @endif
            @if(!empty($item->player2->user))
                <div class="one_player">
                    @if(auth()->check() && auth()->user()->userViewAvatars())
                        <img class="icon_bars" alt="avatar"
                             src="{{asset($item->player2->user->avatarOrDefault())}}">
                    @endif
                    @guest()
                        <img class="icon_bars" alt="avatar"
                             src="{{asset($item->player2->user->avatarOrDefault())}}">
                    @endguest()
                    <span title="{{$item->player2->description}}">
                        {{$item->player2->description}}
                    </span>
                </div>
            @else
                {{__('- FreeSlot -')}}
            @endif
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-4 right_block">
            @if(!empty($item->reps))
                @foreach(json_decode($item->reps) as $item)
                    @if(!empty($item->url) && checkFile::checkFileExists($item->url))
                        <a href="{{asset($item->url)}}"
                           title="{{!empty($item->title) ? $item->title : "rep$loop->iteration"}}">
                            {{!empty($item->title) ? $item->desc : "rep$loop->iteration"}}
                        </a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
