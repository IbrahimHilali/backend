import Vue from 'vue';
import typeahead from '../utils/Typeahead.vue';

new Vue({
    el: '#associations',

    data: {
        associations: [],
        person: {
            id: null,
        },
        createEntry: ''
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/associations';

            $('#addOccurrence').on('shown.bs.modal', (e) => {
                this.$refs.storeOccurrence.focus();
            });
        });
    },

    methods: {
        fillOccurrenceForm(person) {
            this.personSelected(person);
        },

        personSelected(person) {
            this.person = person;
            this.$refs.pageField.focus();
        },

        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        typeahead
    }
});