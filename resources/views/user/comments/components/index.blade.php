<div class="my-post border_shadow">
    <div class="my-post__title">
        <p class="title__text">{{__('Мои посты')}}</p>
    </div>
    <div class="my-post__accordion">
        @isset($sections)
            @foreach($sections as $key => $items)
                <button class="accordion-button change_gray night_text "
                        data-relation_id="{{$key}}">{{$items}}</button>
                <div class="panel night_modal loadUserPosts" id="load_more_user_posts_{{$key}}"></div>
            @endforeach
        @endisset
    </div>
</div>
