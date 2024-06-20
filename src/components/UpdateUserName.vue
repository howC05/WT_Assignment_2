<template>
    <div>
        <h2>Update User Name</h2>
        <form @submit.prevent="updateUserName">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="userData.name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'UpdateUserName',
    props: {
        user: Object
    },
    data() {
        return {
            userData: { ...this.user }
        };
    },
    methods: {
        async updateUserName() {
            try {
                const response = await fetch(`http://localhost:3000/users/${this.userData.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.userData)
                });
                if (response.ok) {
                    this.$emit('update-success');
                } else {
                    console.error('Failed to update user name');
                }
            } catch (error) {
                console.error('Error updating user name:', error);
            }
        }
    }
};
</script>

<style scoped></style>