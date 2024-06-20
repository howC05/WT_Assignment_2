<template>
    <div class="container my-4">
        <h1 class="mb-4">User Management</h1>
        <div class="row">
            <div class="col-md-6 mb-4" v-for="user in users" :key="user.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ user.name }}</h5>
                        <p class="card-text">{{ user.email }}</p>
                        <button class="btn btn-secondary mt-2" @click="selectUser(user)">Update Name</button><br>
                        <button class="btn btn-danger mt-2" @click="deleteUser(user.id)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showUpdateModal" @close="closeUpdateModal">
            <UpdateUserName :user="selectedUser" @update-success="handleUpdateSuccess" />
        </Modal>
    </div>
</template>

<script>
import UpdateUserName from './UpdateUserName.vue';
import Modal from './Modal.vue';

export default {
    name: 'UserManagement',
    components: {
        UpdateUserName,
        Modal
    },
    data() {
        return {
            users: [],
            showUpdateModal: false,
            selectedUser: null
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await fetch('http://localhost:3000/users');
                const data = await response.json();
                this.users = data;
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        selectUser(user) {
            this.selectedUser = user;
            this.showUpdateModal = true;
        },
        closeUpdateModal() {
            this.showUpdateModal = false;
        },
        async deleteUser(id) {
            try {
                const response = await fetch(`http://localhost:3000/users/${id}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    this.fetchUsers();
                } else {
                    console.error('Failed to delete user');
                }
            } catch (error) {
                console.error('Error deleting user:', error);
            }
        },
        handleUpdateSuccess() {
            this.fetchUsers();
            this.closeUpdateModal();
        }
    }
};
</script>

<style scoped></style>