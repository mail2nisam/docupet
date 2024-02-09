<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input type="text" v-model="username" placeholder="Username" required>
            <input type="password" v-model="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>

export default {
    name: 'LoginPage',
    data() {
        return {
            username: '',
            password: ''
        };
    },
    methods: {
         async login() {
            const success = await this.$store.dispatch('login', {
                username: this.username,
                password: this.password
            });
            console.log(success)
            if (success) {
                this.$router.push('/dashboard');
            } else {
                alert('Invalid credentials');
            }
        }


    }
}
</script>