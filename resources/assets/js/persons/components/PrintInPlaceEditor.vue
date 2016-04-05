<template>
    <tr v-if="existing">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingEntry" v-el:entry-input v-on:keyup.enter="savePrint()" />
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit"><i class="fa fa-edit"></i></a> {{ printEntry }}
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingYear" v-on:keyup.enter="savePrint()" />
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="savePrint()"><i class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern</button>
        </td>
        <td colspan="2" v-if="!editing">{{ printYear }} <a href="#" v-on:click.prevent="deletePrint"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a></td>
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
                this.saving = true;
                $.ajax({
                    data: {
                        'entry': this.editingEntry,
                        'year': this.editingYear
                    },
                    url: this.baseUrl + '/' + this.printId,
                    method: 'PUT'
                }).done((function(response) {
                    this.printEntry = response.entry;
                    this.printYear = response.year;
                    this.editing = false;
                    this.saving = false;
                }).bind(this));
            },
            deletePrint: function() {
                if (window.confirm("Soll der Druck wirklich gelöscht werden?")) {
                    $.ajax({
                        url: this.baseUrl + '/' + this.printId,
                        method: 'DELETE'
                    }).done((response) => {
                        this.existing = false;
                    });
                }
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
                existing: true,
                saving: false,
                editingEntry: '',
                editingYear: ''
            }
        }
    }
</script>
