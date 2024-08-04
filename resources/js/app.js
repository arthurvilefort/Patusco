import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import axios from 'axios';

axios.defaults.withCredentials = true;

const routes = [
    { path: '/', component: ExampleComponent, meta: { requiresAuth: true } },
    { path: '/login', component: LoginComponent },
    { path: '/register', component: RegisterComponent },
    { path: '/example', component: ExampleComponent },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('auth_token');
    if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
        next('/login');
    } else {
        next();
    }
});

const app = createApp(App);
app.use(router);
app.mount('#app');
