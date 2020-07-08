import {RouterView} from './RouterView.js';
import Secction from '../components/views/catalogs/Secction';

import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/catalogos',
    component: RouterView,
    children: [
        {
            path: '/administracion/catalogos/seccion',
            component: Secction,
            name: 'Secction',
        },
    ],
}
