import Vue from 'vue';
import Pusher from 'pusher-js';

new Vue({
    el: '#deployment',

    data: {
        messages: []
    },

    ready() {
        this.pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER
        });
        var channel = 'user.' + USER_ID;
        this.pusherChannel = this.pusher.subscribe('user.' + USER_ID);
        console.log("Subscribed to", channel);

        this.pusherChannel.bind('App\\Events\\DeployProgress', (message) => {
            console.log(message.type, message.amount);
            this.messages.push({
                type: "update",
                entity: message.type,
                amount: message.amount
            });
        });
    },

    methods: {
        deploy(event) {
            event.preventDefault();
            $.post(BASE_URL + '/trigger').done((response) => {
                this.messages.push({
                    type: "start"
                });
                console.log('Job pushed');
            }).fail((response) => {
                alert('Die Veröffentlichung konnte nicht gestartet werden!');
            });
        }
    }
});
