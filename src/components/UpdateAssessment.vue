<template>
    <div>
        <h2>Update Assessment</h2>
        <form @submit.prevent="updateAssessment">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" v-model="assessmentData.title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea v-model="assessmentData.description" id="description" class="form-control"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="dueDate" class="form-label">Due Date</label>
                <input type="date" v-model="assessmentData.dueDate" id="dueDate" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'UpdateAssessment',
    props: {
        assessment: Object
    },
    data() {
        return {
            assessmentData: { ...this.assessment }
        };
    },
    methods: {
        async updateAssessment() {
            try {
                // Task 2 json-server
                // const response = await fetch(`http://localhost:3000/assessments/${this.assessmentData.id}`, {
                //     method: 'PUT',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(this.assessmentData)
                // });

                // Task 3 php(non-RESTful)
                const response = await fetch('http://localhost/php-backend/index.php?action=updateAssessment&type=assessment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.assessmentData)
                });

                if (response.ok) {
                    this.$emit('update-success');
                } else {
                    console.error('Failed to update assessment');
                }
            } catch (error) {
                console.error('Error updating assessment:', error);
            }
        }
    }
};
</script>

<style scoped></style>