<template>
    <v-app>
      <NavBar />
      <v-main>
        <v-container fluid>
          <v-row class="d-flex justify-center align-center">
            <v-col cols="12" md="10">
              <v-card class="pa-5">
                <v-card-title>
                  <h3>Consultas</h3>
                  <v-spacer></v-spacer>
                  <v-btn v-if="userLevel === 1" @click="goToAtribuidos" color="primary">Abertos Sem Atribuição</v-btn>
                  <v-btn @click="goToFechados" color="primary">Consultas Encerradas</v-btn>
                </v-card-title>
                <v-card-text>
                  <v-text-field
                    v-model="search"
                    label="Pesquisar"
                    prepend-inner-icon="mdi-magnify"
                    class="mb-4"
                  ></v-text-field>
                  <v-data-table
                    :headers="headers"
                    :items="filteredConsultas"
                    item-value="id"
                    class="elevation-1"
                  >
                    <template v-slot:item.turno="{ item }">
                      <span>{{ item.turno }}</span>
                    </template>
                    <template v-slot:item.data_atendimento="{ item }">
                      <span>{{ formatDate(item.data_atendimento) }}</span>
                    </template>
                    <template v-slot:item.created_at="{ item }">
                      <span>{{ formatDate(item.created_at) }}</span>
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
              <span class="headline">Editar Consulta</span>
            </v-card-title>
            <v-card-text>
              <v-form ref="editForm">
                <v-text-field v-model="editedConsulta.sintomas" label="Sintomas" required></v-text-field>
                <v-text-field
                  v-model="editedConsulta.data_atendimento"
                  label="Data de Atendimento"
                  type="date"
                  required
                ></v-text-field>
                <v-select
                  v-model="editedConsulta.turno"
                  :items="turnos"
                  label="Turno"
                  required
                  class="mb-4"
                ></v-select>
                <v-select
                  v-model="editedConsulta.medico_id"
                  :items="medicos"
                  item-text="name"
                  item-value="id"
                  label="Médico"
                  class="mb-4"
                ></v-select>
                <v-select
                  v-model="editedConsulta.status"
                  :items="statuses"
                  label="Status"
                  required
                  class="mb-4"
                ></v-select>
                <v-text-field v-model="editedConsulta.obs" label="Observações" required></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-btn color="red darken-1" text @click="deleteConsulta">Excluir</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeEditModal">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="updateConsulta">Salvar</v-btn>
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
    name: 'Consulta',
    components: {
      NavBar,
    },
    data() {
      return {
        consultas: [],
        medicos: [],
        search: '',
        headers: [
          { title: 'Proprietário', key: 'usuario_nome' },
          { title: 'Pet', key: 'pet_nome' },
          { title: 'Tipo do Pet', key: 'tipo_pet' },
          { title: 'Sintomas', key: 'sintomas' },
          { title: 'Data de Atendimento', key: 'data_atendimento' },
          { title: 'Turno', key: 'turno' },
          { title: 'Médico', key: 'medico_nome' },
          { title: 'Observações', key: 'obs' },
          { title: 'Criado em', key: 'created_at' },
          { title: 'Ações', key: 'action', sortable: false },
        ],
        userLevel: null,
        editDialog: false,
        editedConsulta: {
          id: '',
          sintomas: '',
          data_atendimento: '',
          turno: '',
          medico_id: null,
          status: 0,
          obs: '',
        },
        turnos: ['Manhã', 'Tarde'],
        statuses: ['Aberto', 'Fechado'],
      };
    },
    computed: {
      filteredConsultas() {
        return this.consultas.filter(consulta => {
          const searchTerm = this.search.toLowerCase();
          return (
            consulta.usuario_nome.toLowerCase().includes(searchTerm) ||
            consulta.pet_nome.toLowerCase().includes(searchTerm) ||
            consulta.tipo_pet.toLowerCase().includes(searchTerm) ||
            consulta.sintomas.toLowerCase().includes(searchTerm) ||
            this.formatDate(consulta.data_atendimento).includes(searchTerm) ||
            consulta.turno.toLowerCase().includes(searchTerm) ||
            (consulta.medico_nome && consulta.medico_nome.toLowerCase().includes(searchTerm)) ||
            (consulta.obs && consulta.obs.toLowerCase().includes(searchTerm)) ||
            this.formatDate(consulta.created_at).includes(searchTerm)
          );
        });
      },
    },
    methods: {
  async fetchConsultas() {
    try {
      const response = await axios.get('/api/abertos/atribuidos', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
        },
      });

      if (response.status === 200) {
        console.log('Consultas recebidas:', response.data);  // Adicionando log para inspecionar os dados
        this.consultas = response.data.map(consulta => ({
          ...consulta,
          turno: consulta.turno === 0 ? 'Manhã' : 'Tarde',
        }));
      } else {
        console.error('Failed to fetch consultas', response.data);
      }
    } catch (error) {
      console.error('Error fetching consultas', error);
    }
  },

      async fetchMedicos() {
        try {
          const response = await axios.get('/api/medicos', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });
  
          console.log('API Response:', response.data);
  
          if (response.status === 200) {
            this.medicos = response.data.map(medico => ({
              id: medico.id,
              name: medico.name
            }));
            console.log('Medicos recebidos:', this.medicos);
          } else {
            console.error('Failed to fetch medicos', response.data);
          }
        } catch (error) {
          console.error('Error fetching medicos', error);
        }
      },
      formatDate(date) {
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return new Date(date).toLocaleDateString('pt-BR', options);
      },
      goToFechados() {
        let route;
        switch (this.userLevel) {
          case 1:
            route = '/fechados/rec';
            break;
          case 2:
            route = '/medico/fechados';
            break;
          case 0:
          default:
            route = '/fechados/cliente';
            break;
        }
        this.$router.push(route);
      },
      goToAtribuidos() {
        this.$router.push('/abertos/rec');
      },
      async fetchUserLevel() {
        try {
          const response = await axios.get('/api/user', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });
  
          if (response.status === 200) {
            this.userLevel = response.data.level;
          } else {
            console.error('Failed to fetch user level', response.data);
          }
        } catch (error) {
          console.error('Error fetching user level', error);
        }
      },
      openEditModal(consulta) {
        this.editedConsulta = { ...consulta, medico_id: consulta.medico_id || null };
        this.editDialog = true;
      },
      closeEditModal() {
        this.editDialog = false;
        this.editedConsulta = {
          id: '',
          sintomas: '',
          data_atendimento: '',
          turno: '',
          medico_id: null,
          status: 0,
          obs: '',
        };
      },
      async updateConsulta() {
        console.log('Updating consulta with ID:', this.editedConsulta.id);
        console.log('Data being sent:', {
          sintomas: this.editedConsulta.sintomas,
          data_atendimento: this.editedConsulta.data_atendimento,
          turno: this.editedConsulta.turno === 'Manhã' ? 0 : 1,
          medico_id: this.editedConsulta.medico_id,
          status: this.editedConsulta.status === 'Aberto' ? 0 : 1,
          obs: this.editedConsulta.obs,
        });
  
        try {
          const response = await axios.put(`/api/abertos/atribuidos/${this.editedConsulta.id}`, {
            sintomas: this.editedConsulta.sintomas,
            data_atendimento: this.editedConsulta.data_atendimento,
            turno: this.editedConsulta.turno === 'Manhã' ? 0 : 1,
            medico_id: this.editedConsulta.medico_id,
            status: this.editedConsulta.status === 'Aberto' ? 0 : 1,
            obs: this.editedConsulta.obs,
          }, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          });
  
          if (response.status === 200) {
            const index = this.consultas.findIndex(consulta => consulta.id === this.editedConsulta.id);
            if (index !== -1) {
              this.consultas.splice(index, 1, this.editedConsulta);
            }
            this.closeEditModal();
            this.fetchConsultas();
          } else {
            console.error('Failed to update consulta', response.data);
          }
        } catch (error) {
          console.error('Error updating consulta', error);
        }
      },
      async deleteConsulta() {
    try {
      const response = await axios.delete(`/api/consultas/${this.editedConsulta.id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
        },
      });
  
      if (response.status === 200) {
        const index = this.consultas.findIndex(consulta => consulta.id === this.editedConsulta.id);
        if (index !== -1) {
          this.consultas.splice(index, 1);
        }
        this.closeEditModal();
        this.fetchConsultas();
      } else {
        console.error('Failed to delete consulta', response.data);
      }
    } catch (error) {
      console.error('Error deleting consulta', error);
    }
  },
    },
    async created() {
      await this.fetchUserLevel();
      await this.fetchMedicos();
      await this.fetchConsultas();
    },
  };
  </script>
  
  <style scoped>
  .v-card {
    border-radius: 20px;
    overflow: hidden;
  }
  </style>
  