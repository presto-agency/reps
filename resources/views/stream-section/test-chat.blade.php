@extends('stream-section.test-layout.app')

@section('content')

    {{--<div class="container">
        <div class="row">
            <ul class="chat">
                @foreach($messages as $message)
                    <li>
                        <b>{{ $message->user_name }}</b>
                        <p>{{ $message->message }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="container">
            <form action="{{ route('chat.add_message') }}" method="POST" class="user-message-form">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="message">Написать сообщение:</label>
                    <br>

                    <textarea name="message" id="message" class="form-control send-message-text" rows="10" maxlength="1000"></textarea>

                    <input type="hidden" name="user_id" value="14">
                    <input type="hidden" name="file_path" value="">
                    <input type="hidden" name="imo" value="">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-blue btn-form">Отправить</button>
                </div>
            </form>
        </div>

    </div>--}}


    <chat-component :auth="{{ Auth::check() ? Auth::user() : 0 }}"></chat-component>

@endsection


{{--
@section('javascript')
    <script>
        // var socket = io(':6001');
        // var messages = [];

        function appendMessage(data){
            $('.chat').append(
                $('<li/>').append(
                    $('<b/>').text(data.user_name),
                    $('<p/>').text(data.message),
                )
            );
        }

        window.Echo.channel('chat').listen('NewChatMessageAdded', ({data}) => {
            console.log(data);
            //добавляем в масив текст сообщения
            // this.messages.push(message);

            appendMessage(data);
        });

        /*socket.on('laravel_database_chat:message', function (data) {
            console.log(data);
            appendMessage(data);
        });*/

    </script>
@endsection--}}
