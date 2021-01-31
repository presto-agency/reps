import Vue from 'vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

window.Vue = Vue;

window.Vue.component('chat-room', require('../chat/componets/Chat').default);
window.Vue.component('chat-message', require('../chat/componets/Message').default);
export const bus = new Vue()
window.VueApp = new Vue({
    el: '#appchat'
});
