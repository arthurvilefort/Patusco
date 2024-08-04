<template>
    <div>
        <h1>All Users - {{ userName }}</h1>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.name }} ({{ user.email }})
            </li>
        </ul>
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ExampleComponent',
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
    methods: {
        async logout() {
            try {
                await axios.post('/api/logout', {}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    },
                });

                localStorage.removeItem('auth_token');
                this.$router.push('/login');
            } catch (error) {
                console.error('Logout failed', error);
            }
        },
    },
};
</script>
