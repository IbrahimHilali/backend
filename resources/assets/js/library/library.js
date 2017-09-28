import Vue from 'vue';

import Typeahead from '../utils/Typeahead.vue';

new Vue({
    el: '#library',

    data: {
        moreFields: false,
        morePeople: false,
        person: {
            id: null
        },
    },

    mounted() {

    },

    methods: {
        deleteRelation(bookId, relationType, person) {
            console.log(person);

            axios({
                method: 'delete',
                url: `/librarybooks/${bookId}/relation/${relationType}`,
                data: {
                    person
                }
            }).then(response => {
                location.reload(true);
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