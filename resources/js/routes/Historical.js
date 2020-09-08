import {RouterView} from './RouterView.js';

import HistoricalIndex from  '../components/views/historical/Index';
import HistoricalShow from '../components/views/historical/Show';
import EditFormalities from "../components/views/formalities/MenuForms";
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
            path:'/consulta/:id',
            component: HistoricalShow,
            name: 'HistoricalShow',
            props:true
        },
    ],
}
