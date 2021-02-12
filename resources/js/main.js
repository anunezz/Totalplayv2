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

window.CryptoJS = require("crypto-js");
const hash = CryptoJS.MD5("9TMmz72hQM4ZFWKW").toString();


const eventsHub = new Vue();

moment.suppressDeprecationWarnings = false;

Vue.use( Vuex );
Vue.use( VueRouter );
Vue.use( ElementUI, { locale } );
Vue.use( require('vue-moment'), { moment, momentTz });
Vue.component('tinymce', tinymce);
Vue.mixin(Loading);
Vue.use(VJsoneditor);

Vue.prototype.$version= '1.3';

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

// For common config
axios.defaults.headers.post["Content-Type"] = "application/json";

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'cache-control': 'no-cache="Set-Cookie", no-store, must-revalidate',
    'pragma': 'no-cache',
    'no-cache': 'Set-Cookie, Set-Directiva Cookie2',
    'Accept-C': window.acceptC
};

// if (window.sessionStorage.getItem('SICAR_token')) {
//     window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.sessionStorage.getItem('SICAR_token');
// }

axios.interceptors.request.use(function (config) {



    if(config && config.data && window.acceptC == true){
        let dataApp = JSON.stringify(config.data);
        dataApp = CryptoJS.AES.encrypt(dataApp, hash).toString();
        config.data = {
            'encrypt' : dataApp
        };
    }

    if(config && config.params &&  window.acceptC == true){

        console.log(config.params);
        let paramsApp = JSON.stringify(config.params);

        paramsApp = CryptoJS.AES.encrypt(paramsApp, hash).toString();
        config.params = {
            'encryptParams' : paramsApp
        };
    }

    let token = window.sessionStorage.getItem('SICAR_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    } else {
        config.headers.Authorization = "";
        window.sessionStorage.removeItem('SICAR_token');
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

axios.interceptors.response.use(response => {

   // console.log(response);

    if(response && response.data &&  window.acceptC == true){
        if(response.config &&
            response.config.responseType &&
            response.config.responseType =='blob'){
        }else{
            let bytes  = CryptoJS.AES.decrypt(response.data.toString(), hash);
            let plaintext = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
            response.data = plaintext;
        }
    }

    return response;

}, function (error) {
    if (error.response.status === 401){
        setTimeout(function(){
            location.reload();
        }, 100);
    }
    return Promise.reject(error);
});
