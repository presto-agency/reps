@if($visible_title)
    <div class="my-topics__title">
        <p class="title__text">{{__('Мои темы')}}</p>
    </div>
@endif
<div class="my-topics__accordion">
    @if($forumSections->isNotEmpty())
        @foreach($forumSections as $items)
            <button class="accordion-button change_gray night_text">{{$items->title}}</button>
            {{--            topics for sections--}}
            <div id="load_more_user_forum_sections_topics"></div>
            {{--            topics for sections--}}
            @php
                $last_sectionId = $items->id;
            @endphp
        @endforeach
        <div id="load_more_user_forum_sections" class="gocu-replays__button night_modal">
            <button type="button" name="load_more_user_gallery_button"
                    class="button button__download-more night_text"
                    id="load_more_user_forum_sections_button" data-section_id="{{ $last_sectionId }}">
                {{__('Загрузить еще')}}
            </button>
        </div>
    @else
        <div class="gocu-replays__button night_modal">
            <button type="button" name="load_more_user_forum_sections"
                    class="button button__download-more night_text">
                {{__('Пусто')}}
            </button>
        </div>
    @endif
</div>
