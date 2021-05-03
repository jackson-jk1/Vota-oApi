
require('./bootstrap');

import Vue from 'vue';
import App from "./view/App";
import Vuetify from "./plugins/vuetify";
import VueRouter from 'vue-router';
import routes from './router/router.js';
import DatetimePicker from 'vuetify-datetime-picker';
import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);
Vue.use(DatetimePicker)

Vue.use(VueRouter);

Vue.use(Vuetify);


const router = new VueRouter({
    mode: 'history',
    base: process.env.APP_URL,
    routes
});

const app = new Vue({
    vuetify:Vuetify,
    el: '#app',
    components: {App},
    router
});
