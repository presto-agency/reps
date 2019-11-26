@extends('layouts.app')

@section('sidebar-left')
    @include('user.components.my-chat', ['contacts' => $contacts])
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--@include('user.messages-partials.messenger')--}}

    <div class="messenger border_shadow">
        <div class="messenger__title">
            <p class="title__text">Мои сообщения</p>
        </div>

        @if($user)
            <div class="messenger__head">
                @if(auth()->check() && auth()->user()->userViewAvatars())
                    <img class="head__avatar" src="{{ asset($user->avatarOrDefault()) }}" alt="avatar">
                @endif
                @guest()
                    <img class="head__avatar" src="{{ asset($user->avatarOrDefault()) }}" alt="avatar">
                @endguest()
                <span class="head__nickname">{{ $user->name }}</span>
                <span class="head__date">2019-06-28 14:11:21</span>
            </div>

            @if($messages && count($messages) > 0)
            <!-- CHAT MESSAGES -->
                <div class="messenger__body messages-wrapper messages-box">
                    @include('user.messages-partials.message_parse')
                </div>
            <!--END CHAT MESSAGES -->
            @else
                <p class="none_text">Нет сообщений</p>
            @endif

        <!-- ADD MESSAGE FORM -->
            {{--@include('user.messages-partials.add-message-form')--}}

            <div class="form-group">

                {{--<label for="replay_content" class="night_text">Вставить HTML код с видео реплеем</label>--}}
                <form action="{{ route('user.send_message') }}" method="POST" class="user-message-form">
                    {{ csrf_field() }}
                    <textarea name="message" class="form-control night_input" id="editor_messenger"></textarea>

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

                    <input type="hidden" name="to_user_id" value="15">
                    <input type="hidden" name="dialog_id" value="1">
                    <div class="messenger__button">
                        <button class="button button__download-more">
                            Отправить
                        </button>
                    </div>
                </form>

            </div>
            <!-- END ADD MESSAGE FORM -->
        @else
            <p class="none_text">Нет сообщений</p>
        @endif
    </div>

@endsection

@section('java-script')
    <script>

        $(function () {

            function appendMyMessage(data) {

                var contentText = $('<div class="content__text"></div>')
                    .append(data.message);

                var messageContent = $('<div class="message-content"></div>')
                    .append(contentText)
                    .append('<span class="content__date">' + data.created_at + '</span>');

                var messageInfo = $('<div class="message-info"></div>')
                    .append('<span class="user-name">{{ auth()->user()->name }}</span>')
                    @if(auth()->check() && auth()->user()->userViewAvatars())
                    .append('<img class="head__avatar" src="{{ asset(auth()->user()->avatarOrDefault()) }}" alt="avatar">')
                    @endif
                    @guest()
                    .append('<img class="head__avatar" src="{{ asset(auth()->user()->avatarOrDefault()) }}" alt="avatar">')
                        @endguest()

                var myMessage = $('<div class="my-message"></div>')
                        .append(messageContent)
                        .append(messageInfo);

                $('.messenger__body')
                    .append(myMessage);

            }

            function appendUserMessage(data) {
                var contentText = $('<div class="content__text"></div>')
                    .append(data.message);

                var messageContent = $('<div class="message-content"></div>')
                    .append(contentText)
                    .append('<span class="content__date">' + data.created_at + '</span>');

                var messageInfo = $('<div class="message-info"></div>')
                    .append('<span class="user-name">' + data.sender.name + '</span>')
                    .append('<img class="head__avatar" src="' + data.sender.avatar + '" alt="avatar">');

                var userMessage = $('<div class="user-message"></div>')
                    .append(messageInfo)
                    .append(messageContent);

                $('.messenger__body')
                    .append(userMessage);
            }


            var socketId = window.Echo.socketId();

            window.Echo.private('dialogue.' + '{{ $dialogue_id }}').listen('NewUserMessageAdded', ({message}) => {
                @if(isset($message) && $message->user_id != Auth()->id())
                    appendUserMessage(message);
                @endif


                // визвати метод для вставки повідослення
                //добавляем в масив текст сообщения
                // this.messages.push(data.body);
            });

            // {'X-Socket-ID': Echo.socketId()}
            $('body').on('submit', '.user-message-form', function (e) {
                e.preventDefault();

                var message = $('#editor_messenger').val().substring(0, 1000);

                axios.post('{{ route('user.send_message') }}', {
                    message: message,
                    from_id: '{{ Auth::id() }}',
                    to_id: '{{ isset($user->id) ? $user->id : "" }}',
                    dialogue_id: '{{ $dialogue_id }}'
                }, {'X-Socket-ID': socketId})
                    .then((response) => {

                        // визвати метод для вставки повідослення
                        appendMyMessage(response.data);

                        /**clean textarea field*/
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                        CKEDITOR.instances[instance].setData('');

                    }, (error) => {
                        console.log(error);
                    });

            });

            $('body').find('.messages-box').scrollTop($(".scroll-to").offset().top);

            $('body').on('click', '.load-more', function () {
                var url = $('.load-more').attr('date-href');

                $.get(
                    url,
                    function (data) {
                        $('.load-more-box').remove();
                        $('.messages-box').prepend(data);
                    }
                );
            })
        });
    </script>
@endsection
