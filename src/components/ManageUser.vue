<template>
    <div class="container my-4">
        <h1 class="mb-4">User Management</h1>
        <div class="row">
            <div class="col-md-6 mb-4" v-for="user in users" :key="user.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Name: {{ user.name }}</h5>
                        <p class="card-text">ID: {{ user.id }}</p>
                        <p class="card-text">Email: {{ user.email }}</p>
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
    name: 'ManageUser',
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
                // Task 2 json-server
                // const response = await fetch('http://localhost/3000/users');

                // Task 3 php(non-RESTful)
                const response = await fetch('http://localhost/php-backend/index.php?action=getUsers&type=user');
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
                const response = await fetch(`http://localhost/php-backend/index.php?action=deleteUser&type=user&id=${id}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    this.fetchUsers();
                } else {
                    const data = await response.json();
                    console.error('Failed to delete user:', data.error);
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
