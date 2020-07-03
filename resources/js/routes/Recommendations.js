import {RouterView} from './RouterView.js';
import store from '../store/index';
import {Message} from 'element-ui'

import RecommendationsIndex from '../components/views/recommendations/Index';
import RecommendationCreate from '../components/views/recommendations/Create';
import RecommendationEdit from '../components/views/recommendations/Edit';

export default {
    path: '/recomendaciones',
    component: RouterView,
    children: [
        {
            path: '',
            component: RecommendationsIndex,
            name: 'RecommendationsIndex',
        },
        {
            path:'/nuevo',
            component: RecommendationCreate,
            name: 'RecommendationCreate',
            props:true
        },
        {
            path:'/editar/:id',
            component: RecommendationEdit,
            name: 'RecommendationEdit',
            props: true
        }
    ],
}
