@php
$revers_messages = collect($messages->items())->sortBy('created_at');

@endphp

@if(isset($dialogue_id) && $messages->lastPage() > $messages->currentPage())
<div class="messenger__load-more load-more-box">
    <span class="load-more"
          date-href="{{route('user.message_load',['dialogue_id' => $dialogue_id, 'page' => $page??2])}}">
        Load more
    </span>
</div>
@endif

@foreach($revers_messages as $message)
    @if($message->user_id == Auth()->id())
        <div class="my-message">
            <div class="message-content">
                <div class="content__text">
                    {!! $message->message !!}
                    {{--<img class="content__img" src="{{ asset($message->sender->avatar) }}" alt="message-image">--}}
                </div>
                <span class="content__date">{{ $message->created_at->format('h:m d.m.Y')}}</span>
            </div>
            <div class="message-info">
                <span class="user-name">{{ $message->sender->name }}</span>
                @if(auth()->check() && auth()->user()->userViewAvatars())
                    <img class="head__avatar" src="{{ asset($message->sender->avatarOrDefault()) }}"
                         alt="avatar">
                @endif
                @guest()
                    <img class="head__avatar" src="{{ asset($message->sender->avatarOrDefault()) }}"
                         alt="avatar">
                @endguest()
            </div>
        </div>
    @else
        <div class="user-message">
            <div class="message-info">
                <span class="user-name">{{ $message->sender->name }}</span>
                @if(auth()->check() && auth()->user()->userViewAvatars())
                    <img class="head__avatar" src="{{ asset($message->sender->avatarOrDefault()) }}"
                         alt="avatar">
                @endif
                @guest()
                    <img class="head__avatar" src="{{ asset($message->sender->avatarOrDefault()) }}"
                         alt="avatar">
                @endguest()
            </div>
            <div class="message-content">
                <div class="content__text">
                    {!! $message->message !!}
                    {{--<img class="content__img" src="{{ asset($message->sender->avatar) }}" alt="message-image">--}}
                </div>
                <span class="content__date">{{ $message->created_at->format('h:m d.m.Y')}}</span>
            </div>
        </div>
    @endif
@endforeach
<div class="scroll-to"></div>
