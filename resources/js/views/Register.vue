<template>
    <v-container fluid class="d-flex align-center justify-center blue-background">
        <v-row class="d-flex justify-center align-center" style="height: 100vh;">
            <v-col cols="12" md="4">
                <v-card class="pa-5">
                    <v-card-title>
                        <h2 class="mb-5">Sign Up</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="register" ref="form">
                            <v-text-field v-model="name" label="Name" required class="mb-4"></v-text-field>
                            <v-text-field v-model="email" label="Email" required class="mb-4"></v-text-field>
                            <v-text-field v-model="password" label="Password" type="password" required class="mb-4"></v-text-field>
                            <v-text-field v-model="password_confirmation" label="Confirm Password" type="password" required class="mb-4"></v-text-field>
                            <v-select
                                v-model="selectedLevel"
                                :items="levels"
                                label="Tipo de Usuario"
                                :rules="[v => !!v || 'O tipo de usuário é obrigatório']"
                                required
                            ></v-select>
                            <v-btn type="submit" color="primary" block class="mb-2">Cadastrar</v-btn>
                        </v-form>
                        <v-btn text class="mt-4" @click="goToLogin">ja possui uma conta? Fazer login</v-btn>
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
            selectedLevel: '',
            levels: ['Cliente', 'Recepcionista', 'Medico'],
        };
    },
    methods: {
        getLevelValue(levelText) {
            const levelMap = {
                'Cliente': 0,
                'Recepcionista': 1,
                'Medico': 2,
            };
            return levelMap[levelText] ?? 0;
        },
        async register() {
            if (this.$refs.form.validate()) {
                try {
                    const level = this.getLevelValue(this.selectedLevel);
                    const response = await axios.post('/api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                        level: level,
                    });

                    if (response.status === 201) {
                        this.$router.push('/login');
                    } else {
                        console.error('Registration failed', response.data);
                    }
                } catch (error) {
                    console.error('Registration failed', error);
                }
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
    background-color: #1976D2;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
