@inject('rout','App\Services\User\UserActivityLogService')
@inject('commentModel','App\Models\Comment')
@if($comments->isNotEmpty())
    @foreach($comments as $item)
        <div class="panel__wrap">
            <div class="panel__header">
                <div class="header__items">
                    <svg class="items__icon" xmlns="http://www.w3.org/2000/svg" id="Capa_1"
                         enable-background="new 0 0 515.556 515.556" viewBox="0 0 515.556 515.556">
                        <path
                            d="m257.778 64.444c-119.112 0-220.169 80.774-257.778 193.334 37.609 112.56 138.666 193.333 257.778 193.333s220.169-80.774 257.778-193.333c-37.609-112.56-138.666-193.334-257.778-193.334zm0 322.223c-71.184 0-128.889-57.706-128.889-128.889 0-71.184 57.705-128.889 128.889-128.889s128.889 57.705 128.889 128.889c0 71.182-57.705 128.889-128.889 128.889z"/>
                        <path
                            d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/>
                    </svg>
                    <p class="items__info">{{$item->created_at}}</p>
                </div>
            </div>
            <div class="panel__body">
                <a class="body__numb" href="{{asset($rout::getCommentRoute($item))}}">{{$item->id}}</a>
                <a class="body__nick"
                   href="{{route('user_profile',['id'=>$item->user_id])}}">{{$item->user_name}}</a>
                <p class="body__text night_text">{!! ParserToHTML::toHTML($item->content) !!}</p>
            </div>
        </div>
        @php
            $last_commentId = $item->id;
            $relation_id = $commentModel::$relation[$item->commentable_type];
        @endphp
    @endforeach
        <button type="button" name="load_more_user_posts_button" class="button button__download-more night_text buttonEventLoadPosts"
               onclick="button_event(this.value,{{ $last_commentId }})"
                id="load_more_user_posts_button_{{ $relation_id }}"
                value="{{ $relation_id }}">
            {{__('Загрузить еще')}}
        </button>
@else
    <button type="button" name="load_more_user_posts_button" class="button button__download-more night_text">
        {{__('Пусто')}}
    </button>
@endif
