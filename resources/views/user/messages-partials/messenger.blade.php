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
            <div class="messenger__button">
                <button class="button button__download-more">
                    Создать
                </button>
            </div>
        </form>

    </div>
</div>
@section('custom-script')
    @parent
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}" defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace('editor_messenger', {});
        });
    </script>
@endsection
