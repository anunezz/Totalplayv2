import {RouterView} from './RouterView.js';
import Secction from '../components/views/catalogs/Secction';
import Subseries from '../components/views/catalogs/Subseries';
import Series from '../components/views/catalogs/Series';

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
        {
            path: '/administracion/catalogos/series',
            component: Series,
            name: 'Series',
        },
        {
            path: '/administracion/catalogos/subseries',
            component: Subseries,
            name: 'Subseries',
        },
    ],
}
