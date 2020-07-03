import {RouterView} from './RouterView.js';

import EntiIndex from '../components/views/catalogs/entity/index';



import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/catalogos',
    component: RouterView,
    children: [
        {
            path: '/entidad',
            component: EntiIndex,
            name: 'EntiIndex',
        },
    ],
}
