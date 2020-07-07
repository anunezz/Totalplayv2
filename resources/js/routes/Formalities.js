import {RouterView} from './RouterView.js';


import ListFormalities from '../components/views/formalities/Index';
import NewFormalities from '../components/views/formalities/Form';



export default {
    path: '/formalities',
    component: RouterView,
    children: [
        {
            path: '',
            component: ListFormalities,
            name: 'ListFormalities',
        },
        {
            path:'/nuevo',
            component: NewFormalities,
            name: 'NewFormalities',
            props:true
        },/*
        {
            path:'/editar/:id',
            component: EditFormalities,
            name: 'EditFormalities',
            props: true
        }*/
    ],
}
