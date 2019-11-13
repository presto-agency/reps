<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea rows="10" class="form-control" readonly="">{{ messages.join('\n')}}</textarea>

                <!--<ul class="chat" v-for="message as messages">
                    <li>
                        <b>{{ message }}</b>
                        &lt;!&ndash;<p>{{ message.message }}</p>&ndash;&gt;
                    </li>
                </ul>-->

                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['auth'],
        data(){
          return {
              //наши сообщения
              messages: [],

              // текст сообщения которое хотим отправить
              textMessage: '',
          }
        },
        mounted() {
            console.log('Component mounted.');

            // this.getMessages();

            //в момент монтирования компонента
            // добавляем код для прослушивания
            // в channel - название канала
            // в listen - название события
            window.Echo.channel('chat').listen('NewChatMessageAdded', ({data}) => {
                console.log('Полученые данные через сокет: ');
                console.log(data);
               //добавляем в масив текст сообщения
               this.messages.push(data.message);
            });
        },
        /*created(){
            console.log('Component created.');

            this.getMessages();
        },*/
        methods: {
            getMessages(){

                axios.get('/chat/get_messages').then((response) => {
                    console.log('Полученые список сообщений GET: ');
                    console.log(response.data);
                    // this.messages = response.data;
                });

            },
            sendMessage(){
                // console.log(this.auth);
                axios.post('/chat/insert_message', {
                    user_id: this.auth.id,
                    file_path: "",
                    message: this.textMessage,
                    imo: ""})
                        /*.then((response) => {
                            console.log('Полученые данные методом POST: ');
                            console.log(response);
                            // this.messages = response.data;
                        })*/;

                //после отправки добавляем текст в массив
                // this.messages.push(this.textMessage);

                // очищаем поле для ввода сообщения
                this.textMessage = '';
            }
        }
    }
</script>
