
import Vue from 'vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
window.Vue = require('vue');
window.Vue.component('chat-room', require('../js/componets/Chat').default);
window.Vue.component('chat-message', require('../js/componets/Message').default);
window.VueApp = new Vue({
    el: '#appchat'
});
