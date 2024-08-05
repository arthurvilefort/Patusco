<template>
    <v-app>
      <NavBar />
      <v-main>
        <v-container fluid>
          <v-row class="d-flex justify-center align-center">
            <v-col cols="12" md="8">
              <v-card class="pa-5">
                <v-card-title>
                  <h3>Agendar Consulta</h3>
                </v-card-title>
                <v-card-text>
                  <v-form @submit.prevent="scheduleAppointment" ref="form">
                    <v-text-field
                      v-model="appointment.proprietario_nome"
                      label="Nome do Proprietário"
                      :rules="[v => !!v || 'Nome do Proprietário é obrigatório']"
                      required
                      disabled
                      class="mb-4"
                    ></v-text-field>
                    <v-text-field
                      v-model="appointment.proprietario_email"
                      label="Email do Proprietário"
                      :rules="[v => !!v || 'Email do Proprietário é obrigatório']"
                      required
                      disabled
                      class="mb-4"
                    ></v-text-field>
                    <v-select
                      v-model="appointment.pet_id"
                      :items="filteredPets"
                      label="Nome do Animal"
                      item-text="nome"
                      item-value="id"
                      :rules="[v => !!v || 'Nome do Animal é obrigatório']"
                      required
                      class="mb-4"
                      @change="updatePetDetails"
                    ></v-select>
                    <v-text-field
                      v-model="appointment.tipo_animal"
                      label="Tipo de Animal"
                      disabled
                      class="mb-4"
                    ></v-text-field>
                    <v-text-field
                      v-model="appointment.idade_animal"
                      label="Idade do Animal"
                      disabled
                      class="mb-4"
                    ></v-text-field>
                    <v-text-field
                      v-model="appointment.sintomas"
                      label="Sintomas"
                      :rules="[v => !!v || 'Sintomas são obrigatórios']"
                      required
                      class="mb-4"
                    ></v-text-field>
                    <v-text-field
                      v-model="appointment.data_atendimento"
                      label="Data do Atendimento"
                      type="date"
                      :rules="[v => !!v || 'Data do Atendimento é obrigatória']"
                      required
                      class="mb-4"
                    ></v-text-field>
                    <v-select
                      v-model="appointment.turno"
                      :items="['Manhã', 'Tarde', 'Noite']"
                      label="Turno"
                      :rules="[v => !!v || 'Turno é obrigatório']"
                      required
                      class="mb-4"
                    ></v-select>
                    <v-btn type="submit" color="primary" block class="mb-2">
                      Agendar
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
  import moment from 'moment';
  
  export default {
    name: 'Agendamento',
    components: {
      NavBar,
    },
    data() {
      return {
        appointment: {
          proprietario_nome: '',
          proprietario_email: '',
          pet_id: '',
          tipo_animal: '',
          idade_animal: '',
          sintomas: '',
          data_atendimento: '',
          turno: '',
        },
        pets: [],
        userId: null,
      };
    },
    computed: {
      filteredPets() {
        return this.pets.filter(pet => pet.proprietario === this.userId);
      },
    },
    methods: {
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
      updatePetDetails(petId) {
        const selectedPet = this.filteredPets.find(pet => pet.id === petId);
        if (selectedPet) {
          this.appointment.tipo_animal = this.formatTipo(selectedPet.tipo);
          this.appointment.idade_animal = this.calculateAge(selectedPet.data_nascimento);
        }
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
      calculateAge(dataNascimento) {
        const birthDate = moment(dataNascimento);
        const currentDate = moment();
        return currentDate.diff(birthDate, 'years');
      },
      async fetchUserDetails() {
        try {
          const userResponse = await axios.get('/api/user', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });
  
          if (userResponse.status === 200) {
            this.userId = userResponse.data.id;
            this.appointment.proprietario_nome = userResponse.data.name;
            this.appointment.proprietario_email = userResponse.data.email;
          } else {
            console.error('Failed to fetch user details', userResponse.data);
          }
        } catch (error) {
          console.error('Error fetching user details', error);
        }
      },
      async scheduleAppointment() {
        if (this.$refs.form.validate()) {
          try {
            const response = await axios.post('/api/agendamentos', this.appointment, {
              headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
              },
            });
  
            if (response.status === 201) {
              this.$router.push('/consultas');
            } else {
              console.error('Failed to schedule appointment', response.data);
            }
          } catch (error) {
            console.error('Error scheduling appointment', error);
          }
        }
      },
    },
    async created() {
      await this.fetchUserDetails();
      await this.fetchPets();
    },
  };
  </script>
  
  <style scoped>
  .v-card {
    border-radius: 20px;
    overflow: hidden;
  }
  </style>
  