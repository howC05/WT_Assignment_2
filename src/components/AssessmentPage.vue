<template>
    <div class="container my-4">
        <h1 class="mb-4">Assessments</h1>
        <button class="btn btn-primary mb-4" @click="showAddModal = true">Add New Assessment</button>
        <div class="row">
            <div class="col-md-6 mb-4" v-for="assessment in assessments" :key="assessment.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ assessment.title }}</h5>
                        <p class="card-text">{{ assessment.description }}</p>
                        <p class="card-text"><small class="text-muted">Due Date: {{ assessment.dueDate }}</small></p>
                        <button class="btn btn-secondary mt-2" @click="selectAssessment(assessment)">Update</button>
                        <br>
                        <button class="btn btn-danger mt-2" @click="deleteAssessment(assessment.id)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showModal" @close="closeModal">
            <UpdateAssessment :assessment="selectedAssessment" @update-success="handleUpdateSuccess" />
        </Modal>
        <Modal :show="showAddModal" @close="closeAddModal">
            <AddAssessment @add-success="handleAddSuccess" />
        </Modal>
    </div>
</template>

<script>
import Navbar from './NavBar.vue'
import UpdateAssessment from './UpdateAssessment.vue';
import AddAssessment from './AddAssessment.vue';
import Modal from './Modal.vue';

export default {
    name: 'AssessmentPage',
    components: {
        UpdateAssessment,
        AddAssessment,
        Modal,
        Navbar
    },
    data() {
        return {
            assessments: [],
            showModal: false,
            showAddModal: false,
            selectedAssessment: null
        };
    },
    created() {
        this.fetchAssessments();
    },
    methods: {
        async fetchAssessments() {
            try {
                // Task 2 json-server
                // const response = await fetch('http://localhost:3000/assessments');
                // const data = await response.json();
                // this.assessments = data;

                // Task 3 php(non-restful)
                // const response = await fetch('http://localhost/php-backend/index.php?action=getAssessments&type=assessment');

                // Task 4 php(RESTful)
                const response = await fetch('http://localhost/php-RESTful/api/assessments');
                const data = await response.json();
                this.assessments = data;
            } catch (error) {
                console.error('Error fetching assessments:', error);
            }
        },
        selectAssessment(assessment) {
            this.selectedAssessment = assessment;
            this.showModal = true;
        },
        async deleteAssessment(id) {
            try {
                // Task 2 json-server
                // const response = await fetch(`http://localhost:3000/assessment/${id}`, {
                //     method: 'DELETE',
                // });

                // Task 3 php(non-RESTful)
                // const response = await fetch(`http://localhost/php-backend/index.php?action=deleteAssessment&type=assessment&id=${id}`, {

                // Task 4 php(RESTful)
                const response = await fetch(`http://localhost/php-RESTful/api/assessments/${id}`, {
                    method: 'DELETE',
                });
                if (response.ok) {
                    this.fetchAssessments();
                } else {
                    console.error('Failed to delete assessment');
                }
            } catch (error) {
                console.error('Error deleting assessment:', error);
            }
        },
        closeModal() {
            this.showModal = false;
        },
        closeAddModal() {
            this.showAddModal = false;
        },
        handleUpdateSuccess() {
            this.fetchAssessments();
            this.closeModal();
        },
        handleAddSuccess() {
            this.fetchAssessments();
            this.closeAddModal();
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here if needed */
</style>