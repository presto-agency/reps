<template>
    <div class="wrapper block_chat border_shadow ">
        <div class="container_titleChat">
            <div class="col-xl-6 col-lg-6 col-md-6 col-6 content_left">
                <img id="img_menuMob" class="icon_bars" src="/images/speech-bubble.png"/>
                <p class="title_text">Guest</p>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-6 content_right">
                <div class="popup_chat">
                    <button type="button" class="btn btn-primary " data-toggle="modal"
                            data-target="#exampleModalLong">
                        <svg viewBox="0 0 59 55" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11 8C10.4477 8 10 8.44772 10 9V44.2641L27.4258 28H15.9999V26H28.9999H29.9999V27V40H27.9999V30.2L11.0713 46H47C47.5523 46 48 45.5523 48 45V9C48 8.44772 47.5523 8 47 8H11Z"
                                  fill="white"/>
                        </svg>
                    </button>
                    <!-- Modal insert need -->
                    <div class="  modal  fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header title_block modal-header_chat">
                                            <img id="img_menuMob" class="icon_bars"
                                                 src=""/>
                                            <p class="title_text_modal">Guest</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="close_modal close_btn">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body popup_contant messanger night_modal">
                                            <chat-message :messagearray="messagearray" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
            <chat-message :messagearray="messagearray" />
        <div class="form-group" v-if="isUser">
            <textarea v-model="textMessage" @keyup.enter="sendMessage" class="form-control night_input"></textarea>

        </div>

        <div class="login_block" v-else>
         <a href="#">
            <span>LOGIN</span> to chat!
            </a>
        </div>

    </div>
</template>

<script>

    export default {
        name: "Chat",
        props: ['auth'],
        data: ()=>({
            isUser: true,
            messagearray: [],
            textMessage: ''
        }),
        created(){
            axios.get('/chat/get_messages').then((response) => {
                let number= response.data.length;
                response.data.forEach((item,index)=> {
                    this.messagearray.push({
                        flag: '/images/country_flag.png',
                        ava: item.user.avatar,
                        usernick: item.user_name,
                        date: '13.11',
                        message: item.message,
                        user_id: item.user_id,
                        visible: true
                    })
                })
            })
        },
        mounted() {
            window.Echo.channel('chat').listen('NewChatMessageAdded', ({data}) => {
                console.log('Полученые данные через сокет: ');
                console.log(data);
                this.messagearray.unshift({
                    flag: '/images/country_flag.png',
                    ava: data.user.avatar,
                    usernick: data.user_name,
                    date: '13.11',
                    message: data.message,
                    user_id: data.user.id,
                    visible: true
                });
                console.log(this.messagearray)
            });
        },
        methods: {
            sendMessage(){
                    // console.log(this.auth); this.auth.id
                    axios.post('/chat/insert_message', {
                        user_id: this.auth.id,
                        file_path: "",
                        message: this.textMessage,
                        imo: ""})
                        /*.then((response) => {
                            console.log('Полученые данные методом POST: ');
                            console.log(response.data);
                            // this.messages = response.data;
                        })*/;
                    this.textMessage = '';
            }

        }
    }
</script>

<style >

</style>
