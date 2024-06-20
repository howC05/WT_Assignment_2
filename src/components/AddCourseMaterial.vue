<template>
    <div>
        <h2>Add New Course Material</h2>
        <form @submit.prevent="addCourseMaterial">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" v-model="courseMaterial.title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea v-model="courseMaterial.description" id="description" class="form-control"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" v-model="courseMaterial.link" id="link" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'AddCourseMaterial',
    data() {
        return {
            courseMaterial: {
                title: '',
                description: '',
                link: ''
            }
        };
    },
    methods: {
        async addCourseMaterial() {
            try {
                // Task 2 json server
                // const response = await fetch('http://localhost:3000/courseMaterials', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(this.courseMaterial)
                // });

                // Task 3
                // php(non-RESTful)
                const response = await fetch('http://localhost/php-backend/index.php?action=createCourseMaterial&type=courseMaterial', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.courseMaterial)
                });
                if (response.ok) {
                    this.$emit('add-success');
                    this.courseMaterial = { title: '', description: '', link: '' };
                } else {
                    console.error('Failed to add course material');
                }
            } catch (error) {
                console.error('Error adding course material:', error);
            }
        }
    }
};
</script>

<style scoped></style>