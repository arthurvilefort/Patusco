<template>
    <v-app>
      <NavBar />
      <v-main>
        <v-container fluid>
          <v-row class="d-flex justify-center align-center">
            <v-col cols="12" md="8">
              <v-card class="pa-5">
                <v-card-title>
                  <h3>Cadastrar Pet</h3>
                </v-card-title>
                <v-card-text>
                  <v-form @submit.prevent="registerPet" ref="form">
                    <v-text-field
                      v-model="pet.nome"
                      label="Nome"
                      :rules="[v => !!v || 'Nome é obrigatório']"
                      required
                      class="mb-4"
                    ></v-text-field>
                    <v-select
                      v-model="selectedTipo"
                      :items="tipos"
                      label="Tipo"
                      :rules="[v => !!v || 'Tipo é obrigatório']"
                      required
                      class="mb-4"
                    ></v-select>
                    <v-text-field
                      v-model="pet.data_nascimento"
                      label="Data de Nascimento"
                      type="date"
                      :rules="[v => !!v || 'Data de Nascimento é obrigatória']"
                      required
                      class="mb-4"
                    ></v-text-field>
                    <v-btn type="submit" color="primary" block class="mb-2">
                      Cadastrar
                    </v-btn>
                  </v-form>
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
    name: 'RegisterPet',
    components: {
      NavBar,
    },
    data() {
      return {
        pet: {
          nome: '',
          tipo: null,
          data_nascimento: '',
        },
        selectedTipo: '',
        tipos: ['Cão', 'Gato', 'Ave', 'Roedor', 'Outro'],
      };
    },
    methods: {
      getTipoValue(tipoText) {
        const tipoMap = {
          'Cão': 0,
          'Gato': 1,
          'Ave': 2,
          'Roedor': 3,
          'Outro': 4,
        };
        return tipoMap[tipoText] ?? 0;
      },
      async registerPet() {
        if (this.$refs.form.validate()) {
          try {
            const tipo = this.getTipoValue(this.selectedTipo);
            const response = await axios.post('/api/pets', {
              nome: this.pet.nome,
              tipo: tipo,
              data_nascimento: this.pet.data_nascimento,
            }, {
              headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
              },
            });
  
            if (response.status === 201) {
              this.$router.push('/pets');
            } else {
              console.error('Failed to register pet', response.data);
            }
          } catch (error) {
            console.error('Error registering pet', error);
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .v-card {
    border-radius: 20px;
    overflow: hidden;
  }
  </style>
  