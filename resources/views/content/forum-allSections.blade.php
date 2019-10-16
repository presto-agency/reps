@if(!$sections->isEmpty())
<section class="forum_allSections">
    @foreach($sections as $section)
    <div class="wrapper">
        <div class="title_block">
            <div class="left_section">
                <a href="#">
                    <img id="img_menuMob" class="icon_bars" src="{{url('images\speech-bubble.png')}}"/>
                    <span class="title_text">{{ $section->title }}</span>
                </a>
            </div>
            <div class="right_section">
                <div class="block_text">
                    <span>Темы: </span>
                    <span>17118 </span>
                </div>
                <div class="block_text">
                    <span>Комментариев: </span>
                    <span>840174</span>
                </div>
                <a href="#">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" class="svg-inline--fa fa-arrow-right fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>
                </a>
            </div>
        </div>
        <div class="content_allArticle">
            <p class="text_descrArticle">Обсуждение самых разнообразных тем</p>
        </div>
    </div>
    @endforeach
{{--    <div class="wrapper">
        <div class="title_block">
            <div class="left_section">
                <a href="#">
                    <img id="img_menuMob" class="icon_bars" src="{{url('images\speech-bubble.png')}}"/>
                    <span class="title_text">Общий</span>
                </a>
            </div>
            <div class="right_section">
                <div class="block_text">
                    <span>Темы: </span>
                    <span>17118 </span>
                </div>
                <div class="block_text">
                    <span>Комментариев: </span>
                    <span>840174</span>
                </div>
                <a href="#">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" class="svg-inline--fa fa-arrow-right fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>
                </a>
            </div>
        </div>
        <div class="content_allArticle">
            <p class="text_descrArticle">Здесь вы можете сообщить об вашем чемпионате и о его результатах. Так же здесь вы можете вести прямой репортаж с корейских, и не только, лиг или других мероприятий.</p>
        </div>
    </div>
    <div class="wrapper">
        <div class="title_block">
            <div class="left_section">
                <a href="#">
                    <img id="img_menuMob" class="icon_bars" src="{{url('images\speech-bubble.png')}}"/>
                    <span class="title_text">Общий</span>
                </a>
            </div>
            <div class="right_section">
                <div class="block_text">
                    <span>Темы: </span>
                    <span>17118 </span>
                </div>
                <div class="block_text">
                    <span>Комментариев: </span>
                    <span>840174</span>
                </div>
                <a href="#">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" class="svg-inline--fa fa-arrow-right fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>
                </a>
            </div>
        </div>
        <div class="content_allArticle">
            <p class="text_descrArticle">Обсуждение самых разнообразных тем</p>
        </div>
    </div>--}}
</section>
@else
    <h2>No Sections</h2>
@endif
