<template>
    <tr v-if="existing">
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit"><i class="fa fa-edit"></i></a> {{ inheritanceEntry }}
        </td>
        <td v-if="!editing"><a href="#" v-on:click.prevent="deleteInheritance"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a></td>
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingEntry" v-el:entry-input v-on:keyup.enter="saveInheritance()" />
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveInheritance()"><i class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern</button>
        </td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['inheritanceId', 'inheritanceEntry', 'baseUrl'],
        methods: {
            clickEdit: function () {
                if (this.editingEntry == '') {
                    this.editingEntry = this.inheritanceEntry;
                }
                this.editing = true;
                this.focusEntryInput();
            },
            stopEdit: function() {
                this.editing = false;
            },
            saveInheritance: function() {
                this.saving = true;
                $.ajax({
                    data: {
                        'entry': this.editingEntry,
                    },
                    url: this.baseUrl + '/' + this.inheritanceId,
                    method: 'PUT'
                }).done((function(response) {
                    this.inheritanceEntry = response.entry;
                    this.editing = false;
                    this.saving = false;
                }).bind(this));
            },
            deleteInheritance: function() {
                if (window.confirm("Soll der Nachlass wirklich gelöscht werden?")) {
                    $.ajax({
                        url: this.baseUrl + '/' + this.inheritanceId,
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
            }
        }
    }
</script>
