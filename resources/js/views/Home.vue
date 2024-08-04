<template>
    <v-app>
        <NavBar />
        <v-main>
            <v-container fluid class="d-flex align-center justify-center" style="height: calc(50vh - 64px);">
                <v-row class="d-flex justify-center align-center">
                    <v-col cols="12" md="8">
                        <v-card class="pa-5">
                            <v-card-title>
                                <h1>All Users - {{ userName }}</h1>
                            </v-card-title>
                            <v-card-text>
                                <ul>
                                    <li v-for="user in users" :key="user.id">
                                        {{ user.name }} ({{ user.email }})
                                    </li>
                                </ul>
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
    data() {
        return {
            users: [],
            userName: '',
        };
    },
    async created() {
        try {
            const userResponse = await axios.get('/api/user', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                },
            });

            if (userResponse.status === 200) {
                this.userName = userResponse.data.name;
            } else {
                console.error('Failed to fetch user details', userResponse.data);
            }

            const usersResponse = await axios.get('/api/example', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
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
