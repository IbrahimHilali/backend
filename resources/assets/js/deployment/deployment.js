import Vue from 'vue';
import Pusher from 'pusher-js';

new Vue({
    el: '#deployment',

    data: {
        messages: [],
        started: false,
        done: false,
        books: 0,
        people: 0,
        last: null,
        blank: false
    },

    ready() {
        this.pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER
        });

        let channel = 'user.' + USER_ID;
        this.pusherChannel = this.pusher.subscribe(channel);

        this.pusherChannel.bind('App\\Events\\DeployProgress', (message) => {
            this.messages.push({
                type: "update",
                entity: message.type,
                amount: message.amount
            });
        });

        this.pusherChannel.bind('App\\Events\\DeploymentDone', (message) => {
            this.done = true;
            this.started = false;
        });

        $.get(BASE_URL + '/status').done((response) => {
            this.started = response.data.inProgress;
            this.last = new Date(response.data.last);
            this.blank = response.data.blank;
        });
    },

    methods: {
        deploy(event) {
            event.preventDefault();
            $.post(BASE_URL + '/trigger').done((response) => {
                this.messages.push({
                    type: "start"
                });
                this.books = response.data.books;
                this.people = response.data.people;
                this.started = true;
            }).fail((response) => {
                alert('Die Veröffentlichung konnte nicht gestartet werden!');
            });
        }
    },

    computed: {
        personProgress() {
            return this.messages.filter((val) =>
                    val.type == 'update' && val.entity == 'Grimm\\Person'
                ).slice(-1)[0].amount || 0;
        },
        bookProgress() {
            return this.messages.filter((val) =>
                    val.type == 'update' && val.entity == 'Grimm\\Book'
                ).slice(-1)[0].amount || 0;
        }
    }
});
