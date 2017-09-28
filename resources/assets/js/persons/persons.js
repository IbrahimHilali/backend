import '../bootstrap';

import InPlaceEditor from './components/PrintInPlaceEditor.vue';
import InheritanceInPlaceEditor from './components/InheritanceInPlaceEditor.vue';

import levenshtein from '../utils/Levenshtein';

Vue.component('in-place', InPlaceEditor);
Vue.component('inheritance-in-place', InheritanceInPlaceEditor);

new Vue({
    el: '#prints',

    data: {
        prints: [],
        createEntry: '',
        createYear: ''
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/prints';

            axios.get(url).then(({ data }) => {
                this.prints = data;
            });

            $('#addPrint').on('shown.bs.modal', (e) => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storePrint() {
            var url = $('#createPrintForm').attr('action');

            console.log(url);

            axios.post(url, {
                entry: this.createEntry,
                year: this.createYear
            }).then(({ data }) => {
                this.prints = data;
                this.createEntry = '';
                this.createYear = '';
                $('#addPrint').modal('hide');
            });
        }
    }
});

new Vue({
    el: '#inheritances',

    data: {
        inheritances: [],
        createEntry: ''
    },

    mounted() {
        this.$nextTick(() => {
            var url = BASE_URL + '/inheritances';

            axios.get(url).then(({ data }) => {
                this.inheritances = data;
            });

            $('#addInheritance').on('shown.bs.modal', (e) => {
                this.$refs.createEntryField.focus();
            });
        });
    },

    methods: {
        storeInheritance() {
            var url = $('#createInheritanceForm').attr('action');

            axios.post(url, {
                entry: this.createEntry
            }).then(({ data }) => {
                this.inheritances = data;
                this.createEntry = '';
                $('#addInheritance').modal('hide');
            });
        }
    }
});

/**
 * On save, we calculate the change in the name and according to that,
 * we will ask if the user wants to really change the entry
 * to prevent accidental overwriting.
 */
$('#person-editor').on('submit', function (event) {
    let prevLastName = $('input[name=prev_last_name]').val();
    let prevFirstName = $('input[name=prev_first_name]').val();
    let prevName = `${prevLastName}, ${prevFirstName}`;

    let currentLastName = $('input[name=last_name]').val();
    let currentFirstName = $('input[name=first_name]').val();
    let currentName = `${currentLastName}, ${currentFirstName}`;

    let distance = levenshtein(prevName, currentName);

    if (distance > 3) {
        let message = `Der Name wurde an ${distance} Stellen bearbeitet. Soll der Datensatz wirklich geändert werden?\n\nBisheriger Name: ${prevName}\n\nNeuer Name: ${currentName}`;
        if (!confirm(message)) {
            event.preventDefault();
        }
    }
});
