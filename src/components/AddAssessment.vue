<template>
    <div>
        <h2>Add New Assessment</h2>
        <form @submit.prevent="addAssessment">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" v-model="assessment.title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea v-model="assessment.description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="dueDate" class="form-label">Due Date</label>
                <input type="date" v-model="assessment.dueDate" id="dueDate" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'AddAssessment',
    data() {
        return {
            assessment: {
                title: '',
                description: '',
                dueDate: ''
            }
        };
    },
    methods: {
        async addAssessment() {
            try {
                // Task 2 json-server
                // const response = await fetch('http://localhost:3000/assessments', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(this.assessment)
                // });

                // Task 3 php(non-RESTful)
                const response = await fetch('http://localhost/php-backend/index.php?action=createAssessment&type=assessment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.assessment)
                });

                if (response.ok) {
                    this.$emit('add-success');
                    this.assessment = { title: '', description: '', dueDate: '' };
                } else {
                    console.error('Failed to add assessment');
                }
            } catch (error) {
                console.error('Error adding assessment:', error);
            }
        }
    }
};
</script>

<style scoped></style>