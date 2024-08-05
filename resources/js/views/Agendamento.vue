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
                    :rules="[v => !!v || 'Nome do proprietário é obrigatório']"
                    required
                    class="mb-4"
                    readonly
                  ></v-text-field>
                  <v-text-field
                    v-model="appointment.proprietario_email"
                    label="Email do Proprietário"
                    :rules="[v => !!v || 'Email do proprietário é obrigatório']"
                    required
                    class="mb-4"
                    readonly
                  ></v-text-field>
                  <v-select
                    v-model="selectedPet"
                    :items="petNames"
                    label="Selecione um Pet"
                    @change="updatePetDetails"
                    class="mb-4"
                  ></v-select>
                  <v-text-field
                    v-model="appointment.sintomas"
                    label="Sintomas"
                    :rules="[v => !!v || 'Sintomas são obrigatórios']"
                    required
                    class="mb-4"
                  ></v-text-field>
                  <v-text-field
                    v-model="appointment.data_atendimento"
                    label="Data de Atendimento"
                    type="date"
                    :rules="[v => !!v || 'Data de Atendimento é obrigatória']"
                    required
                    class="mb-4"
                  ></v-text-field>
                  <v-select
                    v-model="appointment.turno"
                    :items="turnos"
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
        pet_id: 1, // Valor fixo para teste
        sintomas: '',
        data_atendimento: '',
        turno: '',
      },
      selectedPet: null,
      pets: [],
      petNames: [],
      turnos: ['Manhã', 'Tarde'],
    };
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
          const userId = await this.fetchUserId();
          this.pets = petsResponse.data.filter(pet => pet.proprietario === userId);
          this.petNames = this.pets.map(pet => pet.nome);
        } else {
          console.error('Failed to fetch pets', petsResponse.data);
        }
      } catch (error) {
        console.error('Error fetching pets', error);
      }
    },
    async fetchUserId() {
      try {
        const userResponse = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });

        if (userResponse.status === 200) {
          return userResponse.data.id;
        } else {
          console.error('Failed to fetch user details', userResponse.data);
        }
      } catch (error) {
        console.error('Error fetching user details', error);
      }
      return 1;
    },
    updatePetDetails() {
      const selectedPet = this.pets.find(pet => pet.nome === this.selectedPet);
      if (selectedPet) {
        this.appointment.pet_id = selectedPet.id;
      }
    },
    async fetchUserDetails() {
      try {
        const userResponse = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });

        if (userResponse.status === 200) {
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
          const userId = await this.fetchUserId();
          const appointmentData = {
            usuario_id: userId,
            pet_id: this.appointment.pet_id,
            sintomas: this.appointment.sintomas,
            data_atendimento: this.appointment.data_atendimento,
            turno: this.appointment.turno === 'Manhã' ? 0 : 1, // Ajustando turno para boolean
          };

          console.log('Dados do Agendamento:', appointmentData);

          const response = await axios.post('/api/agendamentos', appointmentData, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });

          if (response.status === 201) {
            this.$router.push('/');
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
