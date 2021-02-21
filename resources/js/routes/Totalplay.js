import {RouterView} from './RouterView.js';
//import Menu from "../components/views/layouts/Menu";
import Main from "../components/views/Main/Main";
import netflix from '../components/views/netflix/Index';
import amazon from '../components/views/amazon/Index';
import term from "../components/views/terms/Index";

export default {
    path: '',
    component: RouterView,
    children: [
        {
            path: '',
            component: Main,
            name: 'TotalplayMain',
        },
        {
            path: '/netflix',
            component: netflix,
            name: 'PublicNetflix',
        },
        {
            path: '/amazon',
            component: amazon,
            name: 'PublicAmazon',
        },

        {
            path: '/terminos-y-condiciones',
            component: term,
            name: 'TotalplayTerm',
        },
        // {
        //     path: 'usuarios/editar/:id',
        //     component: UsersEdit,
        //     name: 'UsersEdit',
        //     props: true
        // },

    ],
}
