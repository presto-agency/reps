<template>
    <div class="wrapper block_chat border_shadow ">
        <div class="container_titleChat">
            <div class="col-xl-7col-lg-7 col-md-7 col-6 content_left">
                <img id="img_menuMob" class="icon_bars" src="/images/speech-bubble.png"/>
                <p class="title_text" :title="username">{{username}}</p>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-6 content_right">
                <div class="popup_chat">
                    <button type="button" class="btn btn-primary " onclick="window.open('/chat','_blank', 'Toolbar=0, Scrollbars=1, Resizable=0, Width=320, resize=no, Height=650');return false;">
                        <svg viewBox="0 0 59 55" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11 8C10.4477 8 10 8.44772 10 9V44.2641L27.4258 28H15.9999V26H28.9999H29.9999V27V40H27.9999V30.2L11.0713 46H47C47.5523 46 48 45.5523 48 45V9C48 8.44772 47.5523 8 47 8H11Z"
                                  fill="white"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
            <chat-message :textareaId="textareaId1" :messagearray="messagearray" :not_user="not_user" :auth="auth" @on_delete="deleteMessage($event)"/>
    </div>
</template>

<script>
    import moment from 'moment'
    import * as chatHelper from '../helper/chatHelper';
    import * as utilsHelper from '../helper/utilsHelper';
    import {bus} from "../chat";
    export default {
        name: "Chat",
        props: ['auth','not_user'],
        data: ()=>({
            isUser: true,
            messagearray: [],
            username: '',
            textareaId1: 'pop_editor1',
            textareaId2: 'pop_editor2',
            smiles: [],
            all_images: [],
            category_images: {},
            helper_text: ''
        }),
        beforeCreate(){
            axios.get('/chat/get_messages').then((response) => {
                response.data.forEach((item,index)=> {
                    this.messagearray.push({
                        id: item.id,
                        flag: item.country_flag,
                        ava: item.avatar,
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
            axios.get('/chat/helps').then((response) => {
                this.helper_text = response.data.helps;
                bus.$emit('got-helper', this.helper_text)
            });
            axios.get('/chat/get_externalsmiles').then((response) => {
                response.data.smiles.forEach((item, index) => {
                    this.smiles.push({
                        src: item.filename,
                        charactor: item.charactor
                    })
                });
                bus.$emit('got-smiles', this.smiles)
            });
            axios.get('chat/get_externalimages').then((response) => {
                let i = 0;
                for (let key in response.data.images) {
                    this.all_images.push({
                        category: key,
                        active: false,
                        array: Object.values(response.data.images)[i]
                    });
                    i++;
                }
                if(this.all_images.length>0) {
                    this.all_images[0].active = true;
                    this.category_images = this.all_images[0];
                }
                bus.$emit('got-images', {category: this.category_images, images: this.all_images})
            });
            window.Echo.channel('repschat').listen('NewChatMessageAdded', ({data}) => {
                this.messagearray.unshift({
                    id: data.id,
                    flag: data.country_flag,
                    ava: data.avatar,
                    usernick: data.user_name,
                    date: data.time,
                    message: chatHelper.strParse(data.message),
                    user_id: data.user_id,
                    user_path: '/user/',
                    visible: true
                });
            });

        },
        methods: {
            deleteMessage(id) {
                this.messagearray = this.messagearray.filter(item => item.id!==id );
            }
        }
    }
</script>

<style >

</style>
