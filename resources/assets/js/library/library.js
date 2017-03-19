import Vue from 'vue';

import Typeahead from '../utils/Typeahead.vue';

new Vue({
    el: '#library',

    data: {
        moreFields: false,
        morePeople: false,
        person: null,
    },

    ready: function () {

    },

    methods: {
        personSelected(person) {
            this.person = person;
        },
        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        Typeahead
    }
});