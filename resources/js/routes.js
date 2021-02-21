import Home from "./components/views/layouts/Home";
import Index from "./components/views/Index";
import Login from "./routes/Login";
import Totalplay from "./routes/Totalplay";
import LoginComponent from './components/views/login/Index';

export const routes = [
    {
        path: '/',
        component: Index,
        children: [
            //{ path: '', component: Menu },
            { ...Totalplay },
            {
                path: '/login',
                name: 'TotalplayLogin',
                component: LoginComponent,
                beforeEnter: (to, from, next) => {
                    if (sessionStorage.getItem('access_token')) {
                        next();
                    } else {
                        next('/');
                    }
                },
                children: [
                    { ...Login }
                ]
            },
        ],
        // beforeEnter: (to, from, next) => {
        //     if (sessionStorage.getItem('access_token')) {
        //         next('/');
        //     } else {
        //         next();
        //     }
        // }
    },
    // {
    //     path: '/',
    //     component: Home,
    //     children: [
    //         { path: '', component: Menu },
    //         { ...Admin }
    //     ],
    //     beforeEnter: (to, from, next) => {
    //         if (sessionStorage.getItem("access_token")) {
    //             next();
    //         } else {
    //             next("/ingresar");
    //         }
    //     }
    // },
    { path: '*', redirect: '/' }
];
