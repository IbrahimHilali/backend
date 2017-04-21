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
        deleteRelation(bookId, relationType, person) {
            $.ajax({
                url: `/librarybooks/${bookId}/relation/${relationType}`,
                type: 'DELETE',
                data: {
                    _token: Laravel.csrfToken,
                    person
                }
            }).done(response => {
                if (response.status == 'ok') {
                    location.reload(true);
                }
            }).fail(response => {
                console.log(response);
            });
        },

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