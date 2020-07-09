import Home from "./components/views/layouts/Home";
import AccessDenied from "./components/views/layouts/AccessDenied";
import Menu from "./components/views/layouts/Menu";
import Admin from "./routes/Admin";
import Formalities from "./routes/Formalities";
import Strategy from "./routes/Strategy";
import Reports from "./routes/Reports";
import Catalogs from "./routes/Catalogs";

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
            { ...Strategy },
            { ...Formalities },
            { ...Reports },
            { ...Catalogs }
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
