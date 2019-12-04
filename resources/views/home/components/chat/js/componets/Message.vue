<template>
    <div>
        <div class="messanger">
            <div class="row_contentChat" v-for="(item,index) in messagearray" :key="index">
                <div class=" block_user_akk">
                    <div class="user" >
                        <img class="icon_bars" :src="item.flag">
                        <img class="icon_bars icon_avatar" :src="item.ava"/>
                        <span class="blue_text usernick" @click="UserClick(item.user_id, item.usernick)">{{item.usernick}}</span>
                        <a :href="item.user_path+item.user_id" target="_blank">
                            <span class="number_mess night_text">#{{item.user_id}}</span>
                        </a>
                    </div>
                    <div class=" block_close">
                        <button @click="deleteMessage(item.id)" v-if="not_user==1">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times"
                                 class="svg-inline--fa fa-times fa-w-11" role="img"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
                                <path fill="#bfc3ce"
                                      d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class=" block_date">
                        <span>{{item.date}}</span>
                    </div>
                </div>
                <div class=" block_userMessage">
                    <span class="user_text night_text" v-html="item.message"></span>
                </div>
            </div>
        </div>
        <div class="form-group" v-if="auth.id>0 && auth.email_verified_at">
            <Smiles :status="chat_action.smile" @turnOffStatus="turnOffStatus" @insert_smile="addSmile($event)"></Smiles>
            <Images :status="chat_action.image" @turnOffStatus="turnOffStatus" @insert_image="addImage($event)"></Images>
            <Color :status="chat_action.color"  @turnOffStatus="turnOffStatus" @textarealistener="textareafoo($event)" :selection="selection" ></Color>
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
        </div>
        <div   class="login_block"  v-else-if=" auth.id>0 && !auth.email_verified_at">
            <p>
                <span>Verify</span> your email!
            </p>
        </div>
        <div   class="login_block" v-else>
            <p data-target="#authorizationModal" data-toggle="modal">
                <span>LOGIN</span> to chat!
            </p>
        </div>

    </div>
</template>
<script>
    import * as chatHelper from '../helper/chatHelper';
    import Smiles from './Smiles.vue'
    import Images from './Images.vue'
    import Color from './FontColor'

export default {
    props: ['messagearray','not_user','auth'],
    components: {
        Smiles,Images,Color
    },
    data: ()=>({
        ignored_users: [{}],
        chat_action: {
            'smile': false,
            'image': false,
            'color': false
        },
        textMessage: '',
        textarea: '',
        smiles: [],
        images: {},
        linkProfile: '',
        selection: '',
        user_id: '',
        user_nick: ''
    }),
    methods: {
        deleteMessage(id) {
            this.$emit('on_delete',id);
            axios.delete(`chat/delete/${id}\'`);
        },
        bold() {
             this.textMessage=chatHelper.bold(this.textMessage)
        },
        italic() {
            this.textMessage = chatHelper.italic(this.textMessage)
        },
        underline() {
            this.textMessage=chatHelper.underline(this.textMessage)
        },
        link() {
           this.textMessage= chatHelper.link(this.textMessage)
        },
        img() {
            this.textMessage= chatHelper.img(this.textMessage)
        } ,
        selectItem: function(type) {
            this.selection = chatHelper.color(this.textMessage);
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
        },
        addSmile(smile_object) {
            this.textMessage += smile_object.str;
            this.smiles = smile_object.smlies;
        },
        addImage(image_object) {
            this.textMessage += image_object.str;
            this.images = image_object.images;
        },
        sendMessage(){
            let mes = chatHelper.parsePath(this.textMessage, this.smiles, this.images);
            mes = chatHelper.parseUser(mes,this.user_id, this.user_nick,this.messagearray);
            axios.post('/chat/insert_message', {
                user_id: this.auth.id,
                file_path: "",
                message: mes,
                imo: ""});
            this.textMessage = '';
            this.user_id = '';
            this.user_nick = '';
        },
        UserClick(id,usernick) {
            this.textMessage += "@" + id + ",";

        }
    }
}

</script>
<style lang="scss" scoped >
.login_block {
    p {
        cursor: pointer;
        color: #0567cc;
        text-decoration: underline;
    }
}
.usernick {
    cursor: pointer;
    &:hover {
        text-decoration: underline;
    }
}
.blue_text {
    font-size: 12px !important;
    letter-spacing: 1px;
}
.number_mess {
    font-size: 10px !important;
    letter-spacing: 1px;
}
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
