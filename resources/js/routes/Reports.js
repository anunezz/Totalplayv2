import {RouterView} from './RouterView.js';
import ReportIndex from '../components/views/reports/Index';
import Record from '../components/views/reports/Record/Record';
import LabelIndex from '../components/views/reports/label/index';

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
        {
            path: 'etiqueta',
            component: LabelIndex,
            name: 'LabelIndex',
        },
    ],
}
