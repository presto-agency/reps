window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    const {default: popperDefault} = require('popper.js');

    window.Popper = popperDefault
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
    console.error(e);
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
const metaCsrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (typeof axios !== 'undefined') {
    let {content} = metaCsrfToken || {}
    if (content) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = content;
    } else {
        console.error('CSRF token not found');
    }
}
if (typeof $ !== 'undefined') {
    let {content} = metaCsrfToken || {}
    if (content) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': content
            },
        });
    } else {
        console.error('CSRF token not found');
    }
}

/**
 * Echo
 */

import Echo from 'laravel-echo'

window.io = require('socket.io-client');

if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
        encrypted: true
    });
}
