<template>
    <v-app>
      <NavBar />
      <v-main>
        <v-container fluid>
          <v-row class="d-flex justify-center align-center">
            <v-col cols="12" md="8">
              <v-card class="pa-5">
                <v-card-title>
                  <h3>Todos Usuarios</h3>
                </v-card-title>
                <v-card-text>
                  <DataTable :items="users" :headers="headers" />
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
  </template>
  
    
  <script>
  import axios from 'axios';
  import NavBar from '../components/Navbar.vue';
  import DataTable from '../components/DataTable.vue';
  
  export default {
    name: 'Home',
    components: {
      NavBar,
      DataTable,
    },
    data() {
      return {
        users: [],
        userName: '',
        headers: [
          { key: 'name', title: 'Name' },
          { key: 'email', title: 'Email' },
          { key: 'level', title: 'Level' },
        ],
      };
    },
    async created() {
      try {
        const userResponse = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
  
        if (userResponse.status === 200) {
          this.userName = userResponse.data.name;
        } else {
          console.error('Failed to fetch user details', userResponse.data);
        }
  
        const usersResponse = await axios.get('/api/example', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
  
        if (usersResponse.status === 200) {
          this.users = usersResponse.data;
        } else {
          console.error('Failed to fetch users', usersResponse.data);
        }
      } catch (error) {
        console.error('Error fetching data', error);
      }
    },
  };
  </script>
    
    <style scoped>
    .v-card {
      border-radius: 20px;
      overflow: hidden;
    }
    </style>
    