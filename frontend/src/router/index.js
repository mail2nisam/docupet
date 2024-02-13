import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/views/Login.vue';
import NewPet from '@/views/NewPet.vue';
import Dashboard from '@/views/Dashboard.vue';
import store from '@/store';

const routes = [
    { path: '/login', component: Login },
    { path: '/new', component: NewPet, meta: { requiresAuth: true } },
    { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/', redirect: '/dashboard' }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isLoggedIn = store.state.isLoggedIn || localStorage.getItem('token');
    if (to.meta.requiresAuth && !isLoggedIn) {
        next('/login');
    } else {
        next();
    }
});

export default router;
