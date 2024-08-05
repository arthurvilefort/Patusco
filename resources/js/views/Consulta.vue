<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        Consultas
                    </v-card-title>
                    <v-card-text>
                        <DataTable :headers="headers" :users="appointments"></DataTable>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';
import DataTable from '../components/DataTable.vue';

export default {
    components: {
        DataTable,
    },
    data() {
        return {
            headers: [
                { text: 'Nome', value: 'name' },
                { text: 'Nome do Animal', value: 'pet_name' },
                { text: 'Tipo de Animal', value: 'pet_type' },
                { text: 'Idade do Animal', value: 'pet_age' },
                { text: 'Data', value: 'date' },
                { text: 'Período', value: 'period' },
            ],
            appointments: [],
        };
    },
    async created() {
        try {
            const response = await axios.get('/api/appointments', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
                },
            });
            if (response.status === 200) {
                this.appointments = response.data;
            }
        } catch (error) {
            console.error('Error fetching appointments', error);
        }
    },
};
</script>
