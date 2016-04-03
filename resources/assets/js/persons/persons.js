import Vue from 'vue';
import InPlaceEditor from './components/PrintInPlaceEditor.vue';
import InheritanceInPlaceEditor from './components/InheritanceInPlaceEditor.vue';

Vue.component('in-place', InPlaceEditor);
Vue.component('inheritance-in-place', InheritanceInPlaceEditor);

new Vue({
    el: '#prints',
});

new Vue({
    el: '#inheritances',
});