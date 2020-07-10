import {RouterView} from './RouterView.js';

import HistoricalIndex from  '../components/views/historical/Index';
import HistoricalShow from '../components/views/historical/Show';
// import StrategiesCreate from '../components/views/historical/Create';


export default {
    path: '/historico',
    component: RouterView,
    children: [
        {
            path: '',
            component: HistoricalIndex,
            name: 'HistoricalIndex',
        },
        {
            path:'/consulta',
            component: HistoricalShow,
            name: 'HistoricalShow',
            props:true
        },

    ],
}
