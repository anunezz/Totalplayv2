import {RouterView} from './RouterView.js';
import ReportIndex from '../components/views/admin/Index';

export default {
    path: '/administracion',
    component: RouterView,
    children: [
        {
            path: '',
            component: ReportIndex,
            name: 'ReportIndex',
        }

    ],
}
