import {RouterView} from './RouterView.js';
import ReportIndex from '../components/views/reports/Index';
import Record from '../components/views/reports/Record/Record';
import Transfer from '../components/views/reports/Transfer/Transfer';
import Inventory from '../components/views/reports/Transfer/Inventory';
import Prevaluation from '../components/views/reports/Prevaluation/Prevaluation';
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
            path: 'transferencia',
            component: Transfer,
            name: 'Transfer',
        },
        {
            path: 'transferencia/inventario',
            component: Inventory,
            name: 'Inventory',
        },
        {
            path: 'transferencia/prevaloración',
            component: Prevaluation,
            name: 'Prevaluation',
        },
        {
            path: 'etiqueta',
            component: LabelIndex,
            name: 'LabelIndex',
        },
    ],
}
