<div class="my-topics forum-topics border_shadow">
    <div class="my-topics__title">
        <p class="title__text">{{__('Мои темы')}}</p>
    </div>
    <div class="my-topics__accordion">
        @if(isset($forumSections) && $forumSections->isNotEmpty())
            @foreach($forumSections as $items)
                <div class="btn_flex">
                    <button class="accordion-button change_gray night_text"
                            id="{{$items->id}}">{{$items->title .' | ' . $items->topics_count}}</button>
                </div>
                <div class="panel night_modal" data-id="{{$items->id}}"
                     id="load_more_user_forum_sections_topics_{{$items->id}}"></div>
            @endforeach
        @endif
    </div>
</div>
