@php
    $last_id = '';
@endphp
<section class="forum_allSections">
    @isset($sections)
        @if(!$sections->isEmpty())
            @foreach($sections as $section)
                <div class="wrapper border_shadow">
                    <div class="title_block">
                            <div class="left_section">
                                <a href="{{ route('forum.show', $section->id) }}">
                                    <img id="img_menuMob" class="icon_bars" src="{{asset('images\speech-bubble.png')}}"/>
                                    <span class="title_text">{{ $section->title }}</span>
                                </a>
                            </div>
                        <div class="right_section">
                            <div class="block_text night_text">
                                <span>{{__('Темы: ')}}</span>
                                <span>{{ $section->topics_count }} </span>
                            </div>
                            <div class="block_text night_text">
                                <span>{{__('Комментариев: ')}}</span>
                                <span>{{ $section->section_comments_count }}</span>
                            </div>
                            <a href="{{ route('forum.show', $section->id) }}">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right"
                                     class="svg-inline--fa fa-arrow-right fa-w-14" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                          d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="content_allArticle">
                        <p class="text_descrArticle night_text">{{ $section->description }}</p>
                    </div>
                </div>
                @php
                    $last_id = $section->id;
                @endphp
            @endforeach
            <div id="load_more_forum_sections" class="gocu-replays__button night_modal">
                <button type="button" name="load_more_forum_sections_index"
                        class="btn btn-info form-control night_text"
                        id="load_more_forum_sections_index_button" data-id="{{ $last_id }}">
                    {{__('Загрузить еще')}}
                </button>
            </div>
        @else
            <div id="load_more_forum_sections" class="gocu-replays__button night_modal">
                <button type="button" name="load_more_forum_sections_index"
                        class="btn btn-info form-control night_text">
                    {{__('Пусто')}}
                </button>
            </div>
        @endif
    @endisset
</section>
