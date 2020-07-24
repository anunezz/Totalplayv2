import Vue from "vue"
import Vuex from 'vuex'
import VueRouter from "vue-router"
import axios from 'axios'
import moment from 'moment';
import momentTz from 'moment-timezone';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es';
import VueProgressBar from 'vue-progressbar';
import IdleVue from 'idle-vue'
import tinymce from 'vue-tinymce-editor'
import {getIPs, getIPv4, getIPv6} from 'webrtc-ips';
import Loading from './mixins/Loading';
import VJsoneditor from 'v-jsoneditor';

require('moment/locale/es');
require('../../node_modules/animate.css/animate.css');
require('../../node_modules/normalize.css/normalize.css');
require('../css/app.css');
require('./utils/filters.js');
require('@fortawesome/fontawesome-free/css/all.min.css');

const eventsHub = new Vue();

moment.suppressDeprecationWarnings = false;

Vue.use( Vuex );
Vue.use( VueRouter );
Vue.use( ElementUI, { locale } );
Vue.use( require('vue-moment'), { moment, momentTz });
Vue.component('tinymce', tinymce);
Vue.mixin(Loading);
Vue.use(VJsoneditor);

Vue.prototype.$version= '1.0';

Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    idleTime: 60/*Minutes*/ * 60/*Seconds*/ * 1000/*Miliseconds*/
});

Vue.use(VueProgressBar, {
    color: '#2cbb44',
    failedColor: '#fbbd08',
    height: '10px'
});

window.Vue = Vue;
window.axios = axios;
window._ = require('lodash');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'cache-control': 'no-cache="Set-Cookie", no-store, must-revalidate',
    'pragma': 'no-cache',
    'no-cache': 'Set-Cookie, Set-Directiva Cookie2',
};

if (window.sessionStorage.getItem('SICAR_token')) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.sessionStorage.getItem('SICAR_token');
}
