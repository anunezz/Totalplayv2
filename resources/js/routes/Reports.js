import {RouterView} from './RouterView.js';
import ReportIndex from '../components/views/reports/Index';
import Record from '../components/views/reports/Record/Record';

export default {
    path: '/reportes',
    component: RouterView,
    children: [
        {
            path: '',
            component: ReportIndex,
            name: 'ReportIndex',
        },
        {
            path: 'expedientes',
            component: Record,
            name: 'Record',
        },
    ],
}
