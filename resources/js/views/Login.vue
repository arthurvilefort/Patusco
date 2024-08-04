<template>
    <v-container fluid class="d-flex align-center justify-center blue-background">
        <v-row class="d-flex justify-center align-center" style="height: 100vh;">
            <v-col cols="12" md="4">
                <v-card class="pa-5">
                    <v-card-title>
                        <h2 class="mb-5">Sign In</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="login">
                            <v-text-field
                                v-model="email"
                                label="Email"
                                required
                                class="mb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="password"
                                label="Password"
                                type="password"
                                required
                                class="mb-4"
                            ></v-text-field>
                            <v-btn type="submit" color="primary" block class="mb-2">Sign In</v-btn>
                        </v-form>
                        <v-btn text class="mb-6" @click="goToRegister">Register</v-btn>
                        <v-btn text class="mb-6" @click="forgotPassword">Forgot your password?</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                });

                if (response.status === 200) {
                    const data = response.data;
                    localStorage.setItem('auth_token', data.access_token);
                    this.$router.push('/');
                } else {
                    console.error('Login failed', response.data);
                }
            } catch (error) {
                console.error('Login failed', error);
            }
        },
        forgotPassword() {
            alert('Redirect to forgot password page.');
        },
        goToRegister() {
            this.$router.push('/register');
        },
    },
};
</script>

<style scoped>
.v-card {
    border-radius: 20px;
    overflow: hidden;
}
.blue-background {
    background-color: #1976D2; /* Use the desired blue color */
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
