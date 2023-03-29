window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

 import Echo from 'laravel-echo';

 window.Pusher = require('pusher-js');

 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: process.env.MIX_PUSHER_APP_KEY,
     //cluster: process.env.MIX_PUSHER_APP_CLUSTER,
     wsHost: window.location.hostname,
     wsPort: 6001,
     wssPort: 6001,
     disableStats: true,
     forceTLS: true,
     enableTransports: ['ws', 'wss']
 });

 let permission = Notification.permission;

Echo.channel('events')
    .listen('RealTimeMessage', (e) => {
        if(permission === "granted"){
            showNotification();
        } else if(permission === "default"){
            requestAndShowPermission();
        } else {
            alert("Use normal alert");
        }
    });

function requestAndShowPermission() {
    Notification.requestPermission(function (permission) {
        if (permission === "granted") {
            showNotification();
        }
    });
}
function showNotification() {
    let title = "Nuevo servicio";
    let body = "Se ha solicitado un servicio de lavandería";

    let notification = new Notification(title, { body });

    notification.onclick = () => {
            notification.close();
            window.parent.focus();
    }
}
