require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Toasted from 'vue-toasted';
import routes from './router'

import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'vue-sweetalert2';

Vue.use(VueRouter)
Vue.use(Toasted)
Vue.use(Swal);

Vue.component('sidebar', require('./components/Sidebar.vue').default);
Vue.component('topbar', require('./components/Topbar.vue').default);
Vue.component('footer-vue', require('./components/Footer.vue').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
});
