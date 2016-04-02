<template>
    <tr data-id="{{ printId }}">
        <td v-if="editing">
            <a href="#" class="btn btn-link" v-on:click="stopEdit()"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingEntry" v-el:entry-input v-on:keyup.enter="savePrint()" />
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click="clickEdit()"><i class="fa fa-edit"></i></a> {{ printEntry }}
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingYear" v-on:keyup.enter="savePrint()" />
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="savePrint()">Speichern</button>
        </td>
        <td colspan="2" v-if="!editing">{{ printYear }}</td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['printId', 'printEntry', 'printYear', 'baseUrl'],
        methods: {
            clickEdit: function () {
                if (this.editingYear == '') {
                    this.editingYear = this.printYear;
                }
                if (this.editingEntry == '') {
                    this.editingEntry = this.printEntry;
                }
                this.editing = true;
                this.focusEntryInput();
            },
            stopEdit: function() {
                this.editing = false;
            },
            savePrint: function() {
                $.ajax({
                    data: {
                        'entry': this.editingEntry,
                        'year': this.editingYear
                    },
                    url: this.baseUrl,
                    method: 'PUT'
                }).done((function(response) {
                    this.printEntry = response.entry;
                    this.printYear = response.year;
                    this.editing = false;
                }).bind(this));
            },
            focusEntryInput: function() {
                Vue.nextTick((function() {
                    this.$els.entryInput.focus();
                }).bind(this));
            }
        },
        data: function () {
            return {
                editing: false,
                editingEntry: '',
                editingYear: ''
            }
        }
    }
</script>
