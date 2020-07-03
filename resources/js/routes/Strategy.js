import {RouterView} from './RouterView.js';

import StrategiesIndex from '../components/views/strategies/Index';
import StrategiesCreate from '../components/views/strategies/Create';
//import StrategiesEdit from '../components/views/recommendations/Edit';

export default {
    path: '/estrategia',
    component: RouterView,
    children: [
        {
            path: '',
            component: StrategiesIndex,
            name: 'StrategiesIndex',
        },
        {
            path:'/nueva',
            component: StrategiesCreate,
            name: 'StrategiesCreate',
            props:true
        },
 //       {
 //           path:'/editar/:id',
 //           component: StrategiesEdit,
 //           name: 'StrategiesEdit',
 //           props: true
 //       }
    ],
}
