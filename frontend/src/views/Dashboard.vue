<template>
    <div>
        <h2>Dashboard</h2>
        <p>Welcome, {{ username }}!</p>
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
export default {
    computed: {
        username() {
            return this.$store.state.username;
        }
    },
    methods: {
        logout() {
            this.$store.commit('logout');
            this.$router.push('/login');
        }
    },
    name: 'DashboardPage'

}
</script>
