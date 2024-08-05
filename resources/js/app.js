import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Home from './views/Home.vue';
import Login from './views/Login.vue';
import agendamento from './views/Agendamento.vue';
import consultas from './views/Consulta.vue';
import pets from './views/Pets.vue';
import users from './views/Users.vue';
import Register from './views/Register.vue';
import RegisterPet from './views/RegisterPet.vue'; 
import axios from 'axios';
import vuetify from './plugins/vuetify';

axios.defaults.withCredentials = true;

const routes = [
    { path: '/', component: Home, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/example', component: Home },
    { path: '/agendamento', component: agendamento },
    { path: '/consultas', component: consultas },
    { path: '/pets', component: pets },
    { path: '/users', component: users },
    { path: '/register-pet', component: RegisterPet }, 

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
app.use(vuetify);
app.mount('#app');
