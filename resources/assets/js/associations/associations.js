import Vue from 'vue';
import typeahead from './components/Typeahead.vue';

new Vue({
    el: '#associations',

    data: {
        associations: [],
        person: null,
        createEntry: ''
    },

    ready: function () {
        var url = BASE_URL + '/associations';

        $('#addOccurrence').on('shown.bs.modal', (e) => {
            this.$els.storeOccurrence.focus();
        });
    },

    methods: {
        fillOccurrenceForm(person) {
            this.personSelected(person);
        },
        personSelected(person) {
            this.person = person;
            this.$els.pageField.focus();
        },
        prepareResponse(response) {
            return response.data;
        }
    },

    components: {
        typeahead
    }
});