<template>
    <div class="wrapper block_chat border_shadow ">
        <div class="container_titleChat">
            <div class="col-xl-6 col-lg-6 col-md-6 col-6 content_left">
                <img id="img_menuMob" class="icon_bars" src="/images/speech-bubble.png"/>
                <p class="title_text">{{username}}</p>
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
                                            <img id="img_menuMob1" class="icon_bars"
                                                 src=""/>
                                            <p class="title_text_modal">Guest</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" class="close_modal close_btn">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body popup_contant messanger night_modal">
                                           <chat-message :messagearray="messagearray" :not_user="not_user" :auth="auth" @on_delete="deleteMessage($event)"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
            <chat-message :messagearray="messagearray" :not_user="not_user" :auth="auth" @on_delete="deleteMessage($event)"/>
    </div>
</template>

<script>
    import moment from 'moment'
    import * as chatHelper from '../helper/chatHelper';
    import * as utilsHelper from '../helper/utilsHelper';

    export default {
        name: "Chat",
        props: ['auth','not_user'],
        data: ()=>({
            isUser: true,
            messagearray: [],
            username: ''
        }),
        beforeCreate(){
            axios.get('/chat/get_messages').then((response) => {
                console.log(response.data);
                response.data.forEach((item,index)=> {
                    this.messagearray.push({
                        id: item.id,
                        flag: item.country_flag,
                        ava: chatHelper.CheckAvatar(item.user.avatar),
                        usernick: item.user_name,
                        date: item.time,
                        message: chatHelper.strParse(item.message),
                        user_id: item.user_id,
                        user_path: '/user/',
                        visible: true
                    })
                });
            });

        },
        created() {
            if(this.auth.id>0) {
                this.username = this.auth.name
            }
            else {
                this.username = 'Guest'
            }
        },
        mounted() {
            window.Echo.channel('repschat').listen('NewChatMessageAdded', ({data}) => {
                this.messagearray.unshift({
                    id: data.id,
                    flag: data.country_flag,
                    ava: chatHelper.CheckAvatar(data.user.avatar),
                    usernick: data.user_name,
                    date: data.time,
                    message: chatHelper.strParse(data.message),
                    user_id: data.user.id,
                    user_path: '/user/',
                    visible: true
                });
            });

        },
        methods: {
            deleteMessage(id) {
                this.messagearray = this.messagearray.filter(item => item.id!=id );
            }
        }
    }
</script>

<style >

</style>
