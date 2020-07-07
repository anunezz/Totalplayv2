import Home from "./components/views/layouts/Home";


import AccessDenied from "./components/views/layouts/AccessDenied";
import Menu from "./components/views/layouts/Menu";
import Admin from "./routes/Admin";
import Recommendations from "./routes/Recommendations";

import Strategy from "./routes/Strategy";


export const routes = [
    {
        path: '/ingresar',
        component: AccessDenied,
        beforeEnter: (to, from, next) => {

            if (sessionStorage.getItem('SICAR_token')) {
                next('/');
            } else {
                next();
            }
        }
    },

    {
        path: '/',
        component: Home,
        children: [
            { path: '', component: Menu },

            { ...Admin },
            { ...Recommendations },
             { ...Strategy },
        ],
        beforeEnter: (to, from, next) => {
            if (sessionStorage.getItem("SICAR_token")) {
                next();
            } else {
                next("/ingresar");
            }
        }
    },
    { path: '*', redirect: '/' }
];
