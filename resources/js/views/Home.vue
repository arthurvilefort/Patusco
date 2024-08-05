<template>
  <v-app>
    <NavBar />
    <v-main>
      <v-container fluid>
        <v-row class="d-flex justify-center align-center">
          <v-col cols="12" md="8">
            <v-card class="pa-5">
              <v-card-title>
                <h3>Bem Vindo a Clinica Patusco </h3>
              </v-card-title>
              <v-card-text>
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

export default {
  name: 'Home',
  components: {
    NavBar,
     },
}
</script>
  
  <style scoped>
  .v-card {
    border-radius: 20px;
    overflow: hidden;
  }
  </style>
  