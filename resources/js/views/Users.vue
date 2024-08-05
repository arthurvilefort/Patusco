<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        Users
                    </v-card-title>
                    <v-card-text>
                        <DataTable :headers="headers" :users="users"></DataTable>
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
                { text: 'Email', value: 'email' },
                { text: 'Level', value: 'level' },
            ],
            users: [],
        };
    },
    async created() {
        try {
            const response = await axios.get('/api/users', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
                },
            });
            if (response.status === 200) {
                this.users = response.data;
            }
        } catch (error) {
            console.error('Error fetching users', error);
        }
    },
};
</script>
