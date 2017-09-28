import Vue from 'vue';

import Typeahead from '../utils/Typeahead.vue';

new Vue({
    el: '#library',

    data: {
        moreFields: false,
        morePeople: false,
        person: null,
    },

    mounted() {

    },

    methods: {
        deleteRelation(bookId, relationType, person) {
            axios.delete(`/librarybooks/${bookId}/relation/${relationType}`, {
                person
            }).then(response => {
                if (response.status == 'ok') {
                    location.reload(true);
                }
            }).catch(response => {
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