<div class="my-chat border_shadow">
    <div class="my-chat__title">
        <p class="title__text">Мои сообщения</p>
    </div>

    @if(isset($contacts) && count($contacts))

        <div class="my-chat__body">
            @foreach($contacts as $contact)

                @php

                    $date = "";
                    $sender = false;

                    if ($contact->messages_last){
                        $diff = Carbon\Carbon::now()->diffAsCarbonInterval($contact->messages_last);
                        $date = $contact->messages_last->format('H:i:s d.m.Y');

                        if ($diff->d == 0 && $diff->y == 0 && $diff->m == 0){
                            if ($diff->h > 0){
                                $date = "$diff->h часов назад";
                            } elseif($diff->i > 0){
                                $date = "$diff->i минут назад";
                            } elseif($diff->s > 0){
                                $date = "$diff->s секунд назад";
                            }
                        }
                    }
                    foreach ($contact->senders as $item){
                        if ($item->id != Auth::id()){
                            $sender = $item;
                        }
                    }
                @endphp

                @if($sender)
                    <div class="body__user">
                        <div class="user__avatar">
                            <a href="{{ route('user.messages', ['id' => $sender->id]) }}">
                                @if(auth()->check() && auth()->user()->userViewAvatars())
                                    <img class="avatar__image" src="{{ asset($sender->avatarOrDefault()) }}" alt="avatar">
                                @endif
                                @guest()
                                    <img class="avatar__image" src="{{ asset($sender->avatarOrDefault()) }}"
                                         alt="avatar">
                                @endguest()
                            </a>
                        </div>
                        <div class="user__info">
                            <a href="{{ route('user.messages', ['id' => $sender->id]) }}"
                               class="info__nickname">{{ $sender->name }}</a>
                            <span class="info__date">{{ $date }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        {{ $contacts->links() }}
    @else
        <div class="none_text">
            Пожалуйста, добавьте друзей
        </div>
    @endif
</div>
