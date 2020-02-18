@foreach($players as $item)
    @if(!empty($item->user))
        <div class="players_content">
            <div class="left_block">
                <span>{{'#'.$loop->iteration}}</span>
                <a href="{{route('user_profile',['id'=>$item->user->id])}}">
                    @if(auth()->check() && $item->user->view_avatars)
                        <img src="{{asset($player->user->avatarOrDefault())}}"
                             class="author__avatar img-fluid" alt="avatar">
                    @endif
                    @guest
                        <img src="{{asset($item->user->avatarOrDefault())}}"
                             class="author__avatar img-fluid" alt="avatar">
                    @endguest
                    <span class="name_player" title="{{$item->user->name.' ('.$item->description.')'}}">
                        {{$item->user->name}}
                        <small> {{' ('.$item->description.')'}}</small>
                    </span>
                </a>
                @if($item->check)
                    <span class="name_player">
                        <small>{{__('CheckIn:YES')}}</small>
                    </span>
                @else
                    <span class="name_player">
                        <small>{{__('CheckIn:NO')}}</small>
                    </span>
                @endif
            </div>
            <div class="center_block">
                @if(!empty($item->user->countries))
                    <img class="info__flag" alt="flag" title="{{$item->user->countries->name}}"
                         src="{{asset($item->user->countries->flagOrDefault())}}">
                @endif
                @if(!empty($item->user->races))
                    <img class="info__cube" alt="game" title="{{$item->user->races->title}}"
                         src="{{asset('images/default/game-races/' . $item->user->races->title . '.png')}}">
                @endif
            </div>
            <div class="right_block">
                <span>{{$item->victory_points}}</span>
                @if($loop->iteration === 1)
                    <img src="{{asset("images/icons/goldMedal.png")}}" alt="medal">
                @elseif($loop->iteration === 2)
                    <img src="{{asset("images/icons/silverMedal.svg")}}" alt="medal">
                @elseif($loop->iteration === 3)
                    <img src="{{asset("images/icons/bronzeMedal.svg")}}" alt="medal">
                @else
                    <img src="{{asset("images/icons/medal.svg")}}" alt="medal">
                @endif
            </div>
        </div>
    @endif
@endforeach
