<template>
    <input class="form-control"
           :id="id"
           :placeholder="placeholder"
           v-el:search-person
           v-model="value"
           debounce="500"
           autocomplete="off">
    <ul class="list-group">
        <li v-for="item in results"
            @click="itemClicked(item)"
            class="list-group-item" style="cursor: pointer;">
            {{ item.last_name }}, {{ item.first_name }}
            <em class="pull-right">{{ item.bio_data }}</em>
        </li>
        <li v-show="results.length == 0"
            class="list-group-item">
            Keine Person gefunden
        </li>
    </ul>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: ['id', 'placeholder', 'src', 'onHit', 'prepareResponse'],

        data() {
            return {
                value: '',
                results: [],
            };
        },

        ready() {
            this.$els.searchPerson.focus();

            this.$watch('value', function (newValue, oldValue) {
                $.get(this.src + newValue, function (response) {
                    this.results = this.preparation(response);
                }.bind(this));
            });
        },

        methods: {
            preparation(response) {
                if (typeof this.prepareResponse == 'function') {
                    return this.prepareResponse(response);
                }

                return response;
            },

            itemClicked(item) {
                this.reset();

                if (typeof this.onHit == 'function') {
                    this.onHit(item);
                }
            },

            reset() {
                this.results = [];
            }
        }
    }
</script>