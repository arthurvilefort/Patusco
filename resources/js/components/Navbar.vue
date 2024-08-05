<template>
    <v-app-bar app color="primary" dark>
        <v-toolbar-title  @click="$router.push('/')">Clinica Patusco</v-toolbar-title>
        <div class="menu-buttons">
            <v-btn text v-if="userLevel !== 2" @click="$router.push('/agendamento')">Agendar Consulta</v-btn>
            <v-btn text @click="goToConsultas">Consultas Abertas</v-btn>
            <v-btn text v-if="userLevel !== 2" @click="$router.push('/pets')">Pets</v-btn>
            <v-btn text v-if="userLevel === 1" @click="$router.push('/users')">Users</v-btn>
        </div>
        <v-spacer></v-spacer>
        <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn v-bind="props" text>
           Bem Vindo, {{ userName }}
            <v-icon right>mdi-menu-down</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item @click="logout">
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
</template>

<script>
import axios from 'axios';

export default {
    name: 'NavBar',
    data() {
        return {
            userName: '',
            userLevel: null,
        };
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
                    },
                });
                if (response.status === 200) {
                    this.userName = response.data.name;
                    this.userLevel = response.data.level;
                }
            } catch (error) {
                console.error('Error fetching user data', error);
            }
        },
        logout() {
            localStorage.removeItem('auth_token');
            this.$router.push('/login');
        },
        goToConsultas() {
    let route;
    switch (this.userLevel) {
      case 0:
        route = '/abertos/cliente';
        break;
      case 1:
        route = '/abertos/rec';
        break;
      case 2:
        route = '/abertos/medico';
        break;
      default:
        route = '/consultas'; 
        break;
    }
    this.$router.push(route);
  },
    },
    created() {
        this.fetchUserData();
    },
};
</script>

<style>
</style>
