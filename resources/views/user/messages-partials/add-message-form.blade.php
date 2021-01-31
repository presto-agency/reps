<div class="form-group">
    <label for="replay_content" class="night_text">Вставить HTML код с видео реплеем</label>
    <form>
        <textarea name="message" class="form-control night_input" id="editor_messenger"></textarea>
        <div class="messenger__button">
            <button class="button button__download-more">
                Создать
            </button>
        </div>
    </form>
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
