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
        <div class="form-group" v-if="auth.id>0">
            <Smiles :status="chat_action.smile" @turnOffStatus="turnOffStatus"></Smiles>
            <Images :status="chat_action.image" @turnOffStatus="turnOffStatus"></Images>
            <Color :status="chat_action.color" @turnOffStatus="turnOffStatus" @textarealistener="textareafoo(str)"></Color>
            <div class="form-group-toolbar">
                <img src="../../icons/bold.svg" alt="" class="toolbar_item" @click="bold()">
                <img src="../../icons/italic.svg" alt="" class="toolbar_item" @click="italic()">
                <img src="../../icons/underline.svg" alt="" class="toolbar_item" @click="underline()">
                <img src="../../icons/font.svg" alt="" class="toolbar_item" @click="selectItem('color')">
                <img src="../../icons/link.svg" alt="" class="toolbar_item" @click="link()">
                <img src="../../icons/picture.svg" alt="" class="toolbar_item" @click="img()">
                <img src="../../icons/smile.svg" alt="" class="toolbar_item" @click="selectItem('smile')">
                <img src="../../icons/folder.svg" alt="" class="toolbar_item" @click="selectItem('image')">
            </div>
           <textarea v-model="textMessage" @keyup.enter="sendMessage" class="form-control night_input" id="pop_editor">
           </textarea>
            <!--<ckeditor :editor="editor" v-model="textMessage" :config="editorConfig"  tag-name="textarea"  @focus="onEditorFocus($event)"></ckeditor>-->
        </div>

        <div class="login_block" v-else>
         <a href="#">
            <span>LOGIN</span> to chat!
            </a>
        </div>

    </div>
</template>

<script>
    import moment from 'moment'
    import * as chatHelper from '../helper/chatHelper';
    import * as utilsHelper from '../helper/utilsHelper';
    import Smiles from './Smiles.vue'
    import Images from './Images.vue'
    import Color from './FontColor'
    export default {
        name: "Chat",
        components: {
          Smiles,Images,Color
        },
        props: ['auth'],
        data: ()=>({
            isUser: true,
            messagearray: [],
            textMessage: '',
            chat_action: {
                'smile': false,
                'image': false,
                'color': false
            },
            textarea: ''
        }),
        created(){
            axios.get('/chat/get_messages').then((response) => {
                response.data.forEach((item,index)=> {

                    this.messagearray.push({
                        flag: '/images/country_flag.png',
                        ava: item.user.avatar,
                        usernick: item.user_name,
                        date: '13.11',
                        message: chatHelper.strParse(item.message),
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
                    message: chatHelper.strParse(data.message),
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
                        .then((response) => {
                            console.log('Полученые данные методом POST: ');
                            console.log(response.data);
                            // this.messages = response.data;
                        });
                    this.textMessage = '';
                    console.log("send message")
            },
            getSelection: chatHelper.getSelection,
            bold: chatHelper.bold,
            italic: chatHelper.italic,
            underline: chatHelper.underline,
            link: chatHelper.link,
            img: chatHelper.img,
            selectItem: function(type) {
                let self = this;
                Object.keys(self.chat_action).forEach(function(key) {
                    if(type === key){
                        self.chat_action[key] = !self.chat_action[key];
                    }
                    else self.chat_action[key] = false;
                })

            },

            turnOffStatus: function() {
                let self = this;
                Object.keys(self.chat_action).forEach(function(key) {
                    self.chat_action[key] = false;
                });

            },
            textareafoo (str) {
                this.textMessage = str;
            }



        }
    }
</script>

<style >
.form-group-toolbar {
    padding: 15px 15px;
}
.toolbar_item {
    width: 15px;
    height: 15px;
    cursor: pointer;
    margin-left: 5px;
}
.form-group {
    position: relative;

}

</style>
