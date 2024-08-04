<template>
    <v-app-bar app color="primary" dark>
        <v-toolbar-title>Clinica Patusco</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn text @click="logout">Logout</v-btn>
    </v-app-bar>
</template>

<script>
export default {
    name: 'NavBar',
    methods: {
        logout() {
            localStorage.removeItem('auth_token');
            this.$router.push('/login');
        },
    },
};
</script>

<style scoped>
.v-app-bar {
    background-color: #1976D2; /* Azul similar ao do login */
}
</style>
