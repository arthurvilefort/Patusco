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
import fechadoscliente from './views/FechadoCliente.vue'; 
import fechadosmedico from './views/FechadoMedico.vue'; 
import fechadosrec from './views/FechadoRec.vue'; 
import abertosatribuidos from './views/AbertosAtribuidosRec.vue'; 
import abertosrec from './views/AbertosRec.vue'; 
import abertoscliente from './views/AbertosCliente.vue'; 
import abertosmedico from './views/AbertosMedico.vue'; 
import axios from 'axios';
import vuetify from './plugins/vuetify';
// Importação global do vue-multiselect
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

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
    { path: '/fechados/cliente', component: fechadoscliente }, 
    { path: '/medico/fechados', component: fechadosmedico }, 
    { path: '/fechados/rec', component: fechadosrec }, 
    { path: '/abertos/atribuidos', component: abertosatribuidos }, 
    { path: '/abertos/rec', component: abertosrec }, 
    { path: '/abertos/cliente', component: abertoscliente }, 
    { path: '/abertos/medico', component: abertosmedico }, 
    { path: '/users', component: users }, 

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
app.component('Multiselect', Multiselect); // Registro global do componente

app.use(router);
app.use(vuetify);
app.mount('#app');
