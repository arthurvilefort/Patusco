<template>
    <v-container fluid class="d-flex align-center justify-center blue-background">
        <v-row class="d-flex justify-center align-center" style="height: 100vh;">
            <v-col cols="12" md="4">
                <v-card class="pa-5">
                    <v-card-title>
                        <h2 class="mb-5">Sign Up</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="register">
                            <v-text-field
                                v-model="name"
                                label="Name"
                                required
                                class="mb-4"
                            ></v-text-field>
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
                            <v-text-field
                                v-model="password_confirmation"
                                label="Confirm Password"
                                type="password"
                                required
                                class="mb-4"
                            ></v-text-field>
                            <v-btn type="submit" color="primary" block class="mb-2">Sign Up</v-btn>
                        </v-form>
                        <v-btn text class="mt-4" @click="goToLogin">Already have an account? Sign In</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name: 'register',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });

                if (response.status === 201) {
                    this.$router.push('/login');
                } else {
                    console.error('Registration failed', response.data);
                }
            } catch (error) {
                console.error('Registration failed', error);
            }
        },
        goToLogin() {
            this.$router.push('/login');
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
