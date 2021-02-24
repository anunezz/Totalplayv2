import {RouterView} from './RouterView.js';
import store from "../store/modules/user";
import LoginMenu from '../components/views/login/menu/index';
//Modulo configuracion
import LoginConfig from '../components/views/login/menu/config/index';
import LoginUsers from '../components/views/login/menu/config/user';
import LoginFirstSesion from '../components/views/login/menu/fistsesion/Firstsesion';
import LoginCats from '../components/views/login/menu/config/cats/Index';
import LoginPacks from '../components/views/login/menu/config/cats/Packs';
//Modulo de bandeja de entrada de contactos Totalplay
import LoginContacts from '../components/views/login/menu/contscats/Contacts';

//Modulo de reportes Totalplay

//console.log("routers: ",$store.state.user.fullname);


export default {
    path: '/login',
    component: RouterView,
    children: [
        {
            path: '',
            component: LoginMenu,
            name: 'LoginMenu',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token') ) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/configuracion',
            component: LoginConfig,
            name: 'LoginConfig',
            beforeEnter: (to, from, next) => {
                if (    sessionStorage.getItem('access_token')
                && (store.state.profile === 1 || store.state.profile === 2 )) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/configuracion/usuarios',
            component: LoginUsers,
            name: 'LoginUsers',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token')
                && (store.state.profile === 1 || store.state.profile === 2 ) ) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/configuracion/catalogos',
            component: LoginCats,
            name: 'LoginCats',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token')
                && (store.state.profile === 1 || store.state.profile === 2 ) ) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/configuracion/catalogos/paquetes',
            component: LoginPacks,
            name: 'LoginPacks',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token') && store.state.profile === 1) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/contactos',
            component: LoginContacts,
            name: 'LoginContacts',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token')) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        {
            path: '/login/credenciales',
            component: LoginFirstSesion,
            name: 'LoginFirstSesion',
            beforeEnter: (to, from, next) => {
                if (sessionStorage.getItem('access_token')) {
                    next();
                } else {
                    sessionStorage.getItem('access_token')
                    next('/');
                }
            },
        },
        // {
        //     path: 'usuarios/editar/:id',
        //     component: UsersEdit,
        //     name: 'UsersEdit',
        //     props: true
        // },

    ],
}
