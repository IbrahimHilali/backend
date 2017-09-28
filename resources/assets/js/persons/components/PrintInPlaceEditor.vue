<template>
    <tr v-if="existing">
        <td v-if="editing">
            <a href="#" class="btn btn-link btn-sm" v-on:click.prevent="stopEdit"><i class="fa fa-times"></i></a>
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingEntry" ref="entryInput"
                   v-on:keyup.enter="savePrint()"/>
        </td>
        <td colspan="2" v-if="!editing">
            <a href="#" v-on:click.prevent="clickEdit" v-if="editable"><i class="fa fa-edit"></i></a> {{ printEntry }}
        </td>
        <td v-if="editing">
            <input type="text" class="form-control input-sm" v-model="editingYear" v-on:keyup.enter="savePrint()"/>
        </td>
        <td v-if="editing">
            <button type="button" class="btn btn-primary btn-sm" v-on:click="savePrint()"><i
                    class="fa fa-spinner fa-spin" v-if="saving"></i> Speichern
            </button>
        </td>
        <td colspan="2" v-if="!editing">{{ printYear }} <a href="#" v-on:click.prevent="deletePrint" v-if="editable"><i
                class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Löschen"></i></a></td>
    </tr>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['printId', 'printEntry', 'printYear', 'baseUrl', 'editable'],

        methods: {
            clickEdit() {
                if (this.editingYear == '') {
                    this.editingYear = this.printYear;
                }
                if (this.editingEntry == '') {
                    this.editingEntry = this.printEntry;
                }
                this.editing = true;
                this.focusEntryInput();
            },

            stopEdit() {
                this.editing = false;
            },

            savePrint() {
                this.saving = true;
                axios.put(this.baseUrl + '/' + this.printId, {
                    entry: this.editingEntry,
                    year: this.editingYear
                }).then(({data}) => {
                    // this.printEntry = data.entry;
                    // this.printYear = data.year;
                    this.editing = false;
                    this.saving = false;
                });
            },

            deletePrint() {
                if (window.confirm("Soll der Druck wirklich gelöscht werden?")) {
                    axios.delete(this.baseUrl + '/' + this.printId).then((response) => {
                        this.existing = false;
                    });
                }
            },

            focusEntryInput() {
                Vue.nextTick((function () {
                    this.$refs.entryInput.focus();
                }).bind(this));
            }
        },

        data() {
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
