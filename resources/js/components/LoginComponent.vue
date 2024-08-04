<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email</label>
                <input type="email" v-model="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" v-model="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'LoginComponent',
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password,
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Login failed', errorData);
                    return;
                }

                const data = await response.json();
                localStorage.setItem('auth_token', data.access_token);
                this.$router.push('/');
            } catch (error) {
                console.error('Login failed', error);
            }
        },
    },
};
</script>
