import Vue from 'vue';
import InPlaceEditor from './components/PrintInPlaceEditor.vue';

Vue.component('in-place', InPlaceEditor);

new Vue({
    el: '#prints',
});