<template>
    <input class="form-control"
           :id="id"
           :placeholder="placeholder"
           v-el:search-person
           v-model="value"
           debounce="500"
           @keydown.up="up"
           @keydown.down="down"
           @keydown.enter.prevent="hit"
           @keydown.esc="reset"
           autocomplete="off">
    <ul class="list-group">
        <li v-for="item in results"
            @click="itemClicked(item)"
            @mousemove="current = $index"
            class="list-group-item"
            v-bind:class="{'active': $index == current}"
            style="cursor: pointer;">
            <partial :name="templateName"></partial>
        </li>
        <li v-show="searched && results.length == 0"
            class="list-group-item">
            <span v-html="empty"></span>
        </li>
    </ul>
</template>

<script>
    import Vue from 'vue';

    export default {
        props: [
            'id', 'placeholder',
            'templateName', 'template',
            'src', 'onHit', 'prepareResponse',
            'result', 'empty'
        ],

        data() {
            return {
                value: '',
                results: [],
                searched: false,
                current: 0
            };
        },

        partials: {
            'default': '<span v-html="item | highlight value"></span>'
        },

        ready() {
            if (this.templateName && this.templateName !== 'default') {
                Vue.partial(this.templateName, this.template);
            } else {
                this.templateName = 'default';
            }

            this.$els.searchPerson.focus();

            this.$watch('value', function (newValue, oldValue) {
                $.get(this.src + newValue, function (response) {
                    this.results = this.preparation(response);
                    this.searched = true;
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
            },

            hit() {
                this.onHit(this.results[this.current], this);
            },

            up() {
                if (this.current > 0) this.current--
            },

            down() {
                if (this.current < this.results.length - 1) this.current++
            }
        }
    }
</script>