<template>
    <div>
        <h2>Update Course Material</h2>
        <form @submit.prevent="updateCourseMaterial">
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
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'UpdateCourseMaterial',
    props: {
        material: Object
    },
    data() {
        return {
            courseMaterial: { ...this.material }
        };
    },
    methods: {
        async updateCourseMaterial() {
            try {
                // Task 2 json-server
                // const response = await fetch(`http://localhost:3000/courseMaterials/${this.courseMaterial.id}`, {
                //     method: 'PUT',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(this.courseMaterial)
                // });

                // Task 3
                // php(non-RESTful)
                // const response = await fetch('http://localhost/php-backend/index.php?action=updateCourseMaterial&type=courseMaterial', {\

                // Task 4 php (RESTful)
                const response = await fetch(`http://localhost/php-RESTful/api/course-materials/${this.courseMaterial.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.courseMaterial)
                });
                if (response.ok) {
                    this.$emit('update-success');
                } else {
                    console.error('Failed to update course material');
                }
            } catch (error) {
                console.error('Error updating course material:', error);
            }
        }
    }
};
</script>

<style scoped></style>