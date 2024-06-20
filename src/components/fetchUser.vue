<template>
    <div>
        <h1>Users</h1>
        <ul>
            <li v-for="user in users" :key="user.id">{{ user.email }} - {{ user.password }} - {{ user.role }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await fetch('http://localhost:3000/users');
                this.users = await response.json();
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
    },
};
</script>