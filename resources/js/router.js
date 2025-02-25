// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import ProductList from './pages/ProductList.vue';

const routes = [
    { path: '/', component: ProductList },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
