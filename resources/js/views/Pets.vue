<template>
    <v-app>
      <NavBar />
      <v-main>
        <v-container fluid>
          <v-row class="d-flex justify-center align-center">
            <v-col cols="12" md="8">
              <v-card class="pa-5">
                <v-btn class="ml-auto" @click="$router.push('/register-pet')">Cadastrar Pet</v-btn>
                <v-card-title>
                  <h3>Meus Pets</h3>
                </v-card-title>
                <v-card-text>
                  <v-data-table
                    :headers="headersWithActions"
                    :items="filteredPets"
                    item-value="id"
                    class="elevation-1"
                  >
                    <template v-slot:item.tipo="{ item }">
                      {{ formatTipo(item.tipo) }}
                    </template>
                    <template v-slot:item.data_nascimento="{ item }">
                      {{ formatDate(item.data_nascimento) }}
                    </template>
                    <template v-slot:item.created_at="{ item }">
                      {{ formatDate(item.created_at) }}
                    </template>
                    <template v-slot:item.updated_at="{ item }">
                      {{ formatDate(item.updated_at) }}
                    </template>
                    <template v-slot:item.action="{ item }">
                      <v-btn icon @click="openEditModal(item)">
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                  </v-data-table>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
        <v-dialog v-model="editDialog" max-width="600px">
          <v-card>
            <v-card-title>
              <span class="headline">Editar Pet</span>
            </v-card-title>
            <v-card-text>
              <v-form ref="editForm">
                <v-text-field v-model="editedPet.nome" label="Nome" required></v-text-field>
                <v-select
                  v-model="selectedTipo"
                  :items="tipos"
                  label="Tipo"
                  :rules="[v => !!v || 'Tipo é obrigatório']"
                  required
                  class="mb-4"
                ></v-select>
                <v-text-field
                  v-model="editedPet.data_nascimento"
                  label="Data de Nascimento"
                  type="date"
                  required
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeEditModal">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="updatePet">Salvar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-main>
    </v-app>
  </template>
  
  <script>
  import axios from 'axios';
  import NavBar from '../components/Navbar.vue';
  import moment from 'moment';
  
  export default {
    name: 'Pets',
    components: {
      NavBar,
    },
    data() {
      return {
        pets: [],
        userId: null,
        headers: [
          { key: 'nome', title: 'Nome' },
          { key: 'tipo', title: 'Tipo' },
          { key: 'data_nascimento', title: 'Nascimento' },
          { key: 'created_at', title: 'Cadastrado' },
          { key: 'updated_at', title: 'Ultima atualização' },
          { key: 'action', title: 'Editar', sortable: false }, // Add this line
        ],
        selectedTipo: '',
        tipos: ['Cão', 'Gato', 'Ave', 'Roedor', 'Outro'],
        editDialog: false,
        editedPet: {
          id: '',
          nome: '',
          tipo: null,
          data_nascimento: '',
        },
      };
    },
    computed: {
      headersWithActions() {
        return this.headers;
      },
      filteredPets() {
        return this.pets.filter(pet => pet.proprietario === this.userId);
      },
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
      formatTipo(tipo) {
        const tipoMap = {
          0: 'Cão',
          1: 'Gato',
          2: 'Ave',
          3: 'Roedor',
          4: 'Outro',
        };
        return tipoMap[tipo] ?? 'Desconhecido';
      },
      formatDate(date) {
        return moment(date).format('DD/MM/YYYY');
      },
      openEditModal(pet) {
        this.editedPet = { ...pet };
        this.selectedTipo = this.tipos[this.editedPet.tipo];
        this.editDialog = true;
      },
      closeEditModal() {
        this.editDialog = false;
        this.editedPet = {
          id: '',
          nome: '',
          tipo: null,
          data_nascimento: '',
        };
      },
      async updatePet() {
        try {
          const tipo = this.getTipoValue(this.selectedTipo);
          const response = await axios.put(
            `/api/pets/${this.editedPet.id}`,
            { ...this.editedPet, tipo },
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
              },
            }
          );
  
          if (response.status === 200) {
            const index = this.pets.findIndex(pet => pet.id === this.editedPet.id);
            if (index !== -1) {
              this.pets.splice(index, 1, this.editedPet);
            }
            this.closeEditModal();
            this.fetchPets(); // Fetch the updated list of pets after closing the modal
          } else {
            console.error('Failed to update pet', response.data);
          }
        } catch (error) {
          console.error('Error updating pet', error);
        }
      },
      async fetchPets() {
        try {
          const petsResponse = await axios.get('/api/showpets', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });
  
          if (petsResponse.status === 200) {
            this.pets = petsResponse.data;
          } else {
            console.error('Failed to fetch pets', petsResponse.data);
          }
        } catch (error) {
          console.error('Error fetching pets', error);
        }
      },
    },
    async created() {
      try {
        const userResponse = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
  
        if (userResponse.status === 200) {
          this.userId = userResponse.data.id;
        } else {
          console.error('Failed to fetch user details', userResponse.data);
        }
  
        this.fetchPets();
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
  