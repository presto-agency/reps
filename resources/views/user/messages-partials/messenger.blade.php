<div class="messenger border_shadow">
    <div class="messenger__title">
        <p class="title__text">Мои сообщения</p>
    </div>

    <div class="messenger__head">
        <img class="head__avatar" src="{{ url('/images/avatar.jpg') }}" alt="avatar">
        <span class="head__nickname">lorem</span>
        <span class="head__date">2019-06-28 14:11:21</span>
    </div>

    <div class="messenger__body">
        <div class="messenger__load-more">
            <span class="load-more">
                Load more
            </span>
        </div>


        <div class="my-message">
            <div class="message-content">
                <div class="content__text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eveniet iure voluptatibus. Eos magni nesciunt perspiciatis tempora. Magni sequi, ut?
                    <img class="content__img" src="{{ url('/images/avatar.jpg') }}" alt="message-image">
                </div>
                <span class="content__date">2011-05-17 16:44:19</span>
            </div>
            <div class="message-info">
                <span class="user-name">lorem</span>
                <img class="head__avatar" src="{{ url('/images/avatar.jpg') }}" alt="avatar">
            </div>
        </div>
        <div class="user-message">
            <div class="message-info">
                <span class="user-name">lorem</span>
                <img class="head__avatar" src="{{ url('/images/avatar.jpg') }}" alt="avatar">
            </div>
            <div class="message-content">
                <div class="content__text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eveniet iure voluptatibus. Eos magni nesciunt perspiciatis tempora. Magni sequi, ut?
                    <img class="content__img" src="{{ url('/images/avatar.jpg') }}" alt="message-image">
                </div>
                <span class="content__date">2011-05-17 16:44:19</span>
            </div>
        </div>

    </div>
    <div class="form-group">

        <label for="replay_content" class="night_text">Вставить HTML код с видео реплеем</label>
        <form>
                 <textarea name="editor_messenger" class="form-control night_input"
                           id="editor_messenger"></textarea>
            <script>

                CKEDITOR.replace('editor_messenger', {
                    // Define the toolbar groups as it is a more accessible solution.
                    extraPlugins: 'autoembed',
                    toolbarGroups: [
                        {name: 'document', groups: ['mode', 'document', 'doctools']},
                        '/',
                        {name: 'clipboard', groups: ['clipboard', 'undo']},
                        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                        {name: 'forms', groups: ['forms']},
                        '/',
                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                        {name: 'links', groups: ['links']},
                        {name: 'insert', groups: ['insert']},
                        '/',
                        {name: 'styles', groups: ['styles']},
                        {name: 'colors', groups: ['colors']},
                        {name: 'tools', groups: ['tools']},
                        {name: 'others', groups: ['others']},
                        {name: 'about', groups: ['about']}
                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Strike,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Unlink,Image,Flash,Table,HorizontalRule,SpecialChar,PageBreak,ShowBlocks,Maximize,About,Checkbox'
                });
            </script>
            <div class="messenger__button">
                <button class="button button__download-more">
                    Создать
                </button>
            </div>
        </form>

    </div>
</div>
