import CKEditor from '@ckeditor/ckeditor5-vue'
import Vue from 'vue'
window.Vue = require('vue');
window.Vue.component('chat-room', require('../js/componets/Chat').default);
window.Vue.component('chat-message', require('../js/componets/Message').default);
Vue.use(CKEditor);
window.VueApp = new Vue({
    el: '#appchat'
});
