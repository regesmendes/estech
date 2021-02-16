import {createWebHistory, createRouter} from "vue-router";

import Home from '../../pages/Home'
import About from '../../pages/About';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
