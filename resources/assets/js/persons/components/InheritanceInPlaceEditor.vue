<template>
    <tr v-if="existing">
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><i class="fa fa-edit"></i></a> {{
            inheritanceEntry }}
        </td>
        <td v-if="!editing"><a href="#" v-on:click.prevent="deleteInheritance" v-if="editable"><i class="fa fa-trash"
                                                                                                  data-toggle="tooltip"
                                                                                                  data-placement="top"
                                                                                                  title="Löschen"></i></a>
        </td>
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingEntry" ref="entryInput"
                   v-on:keyup.enter="saveInheritance()"/>
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="saveInheritance()"><i
                    class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern
            </button>
        </td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['inheritanceId', 'inheritanceEntry', 'baseUrl', 'editable'],

        methods: {
            clickEdit() {
                if (this.editingEntry == '') {
                    this.editingEntry = this.inheritanceEntry;
                }
                this.editing = true;
                this.focusEntryInput();
            },

            stopEdit: function () {
                this.editing = false;
            },

            saveInheritance: function () {
                this.saving = true;

                axios.put(this.baseUrl + '/' + this.inheritanceId, {
                    entry: this.editingEntry,
                }).then(({data}) => {
                    // this.inheritanceEntry = data.entry;
                    this.editing = false;
                    this.saving = false;
                });
            },

            deleteInheritance: function () {
                if (window.confirm("Soll der Nachlass wirklich gelöscht werden?")) {
                    axios.delete(this.baseUrl + '/' + this.inheritanceId).then(() => {
                        this.existing = false;
                    });
                }
            },

            focusEntryInput: function () {
                Vue.nextTick(() => {
                    this.$refs.entryInput.focus();
                });
            }
        },
        data() {
            return {
                editing: false,
                existing: true,
                saving: false,
                editingEntry: '',
            }
        }
    }
</script>
