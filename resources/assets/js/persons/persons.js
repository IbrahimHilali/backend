import Vue from 'vue';
import InPlaceEditor from './components/PrintInPlaceEditor.vue';
import InheritanceInPlaceEditor from './components/InheritanceInPlaceEditor.vue';

Vue.component('in-place', InPlaceEditor);
Vue.component('inheritance-in-place', InheritanceInPlaceEditor);

new Vue({
    el: '#prints',

    data: {
        prints: [],
        createEntry: '',
        createYear: ''
    },

    ready: function () {
        var url = BASE_URL + '/prints';
        $.get(url).done((response) => {
            this.prints = response;
        });
        $('#addPrint').on('shown.bs.modal', (e) => {
            this.$els.createEntryField.focus();
        });
    },

    methods: {
        storePrint: function () {
            var url = $('#createPrintForm').attr('action');

            $.ajax({
                url: url,
                data: {entry: this.createEntry, year: this.createYear},
                method: 'POST'
            }).done((response) => {
                this.prints = response;
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

    ready: function () {
        var url = BASE_URL + '/inheritances';
        $.get(url).done((response) => {
            this.inheritances = response;
        });
        $('#addInheritance').on('shown.bs.modal', (e) => {
            this.$els.createEntryField.focus();
        });
    },

    methods: {
        storeInheritance: function () {
            var url = $('#createInheritanceForm').attr('action');

            $.ajax({
                url: url,
                data: {'entry': this.createEntry},
                method: 'POST'
            }).done((response) => {
                this.inheritances = response;
                this.createEntry = '';
                $('#addInheritance').modal('hide');
            });
        }
    }
});