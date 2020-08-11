import {RouterView} from './RouterView.js';


import ListFormalities from '../components/views/formalities/Index';
import NewFormalities from '../components/views/formalities/MenuForms';
import EditFormalities from '../components/views/formalities/MenuForms';
import ShowFormalities from '../components/views/formalities/Show';



export default {
    path: '/tramites',
    component: RouterView,
    children: [
        {
            path: '',
            component: ListFormalities,
            name: 'ListFormalities',
        },
        {
            path:'nuevo',
            component: NewFormalities,
            name: 'NewFormalities',
            props:true
        },
        {
            path:'editar/:id',
            component: EditFormalities,
            name: 'EditFormalities',
            props: true
        },
        {
            path:'ver/:id',
            component: ShowFormalities,
            name: 'ShowFormalities',
            props: true
        }
    ],
}
