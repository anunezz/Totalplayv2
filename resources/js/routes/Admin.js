import {RouterView} from './RouterView.js';
import AdminIndex from '../components/views/admin/Index';
import CatalogsIndex from '../components/views/catalogs/Index';
import UsersIndex from '../components/views/Admin/users/Index';
import UsersEdit from '../components/views/Admin/users/Edit';



export default {
    path: '/administracion',
    component: RouterView,
    children: [
        {
            path: '',
            component: AdminIndex,
            name: 'AdminIndex',
        },

        {
            path: 'catalogos',
            component: CatalogsIndex,
            name: 'CatalogsIndex',
        },

        {
            path: 'usuarios',
            component: UsersIndex,
            name: 'UsersIndex',
        },
        {
            path: 'usuarios/editar/:id',
            component: UsersEdit,
            name: 'UsersEdit',
            props: true
        },

    ],
}
