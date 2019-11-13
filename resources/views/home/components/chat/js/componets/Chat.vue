<template>
    <div class="wrapper block_chat border_shadow ">
        <div class="container_titleChat">
            <div class="col-xl-6 col-lg-6 col-md-6 col-6 content_left">
                <img id="img_menuMob" class="icon_bars" src="/images/speech-bubble.png"/>
                <p class="title_text">{{test}}</p>
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
                                        <div class="modal-header title_block">
                                            <img id="img_menuMob" class="icon_bars"
                                                 src=""/>
                                            <p class="title_text">Guest</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span class="btn_close" aria-hidden="true">&times;</span>
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
            <textarea v-model="message" v-on:keyup.enter="sendMessage($event)" class="form-control night_input"></textarea>

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
        data: ()=>({
            isUser: true,
            messagearray: [],
            message: '',
            test: 'qweqwe'
        }),
        methods: {
            sendMessage(event) {
                event.preventDefault();
                this.messagearray.unshift({
                flag: '/images/country_flag.png',
                ava: '/images/ava.png',
                usernick: 'hetman',
                date: '11.11',
                message: this.message
                });
                this.message = ''

            },

        }
    }
</script>

<style >

</style>
