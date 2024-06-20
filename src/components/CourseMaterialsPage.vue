<template>
    <div class="container my-4">
        <h1 class="mb-4">Course Materials</h1>
        <button class="btn btn-primary mb-4" @click="showAddModal = true">Add New Course Material</button>
        <div class="row">
            <div class="col-md-6 mb-4" v-for="material in courseMaterials" :key="material.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ material.title }}</h5>
                        <p class="card-text">{{ material.description }}</p>
                        <a :href="material.link" class="btn btn-primary" target="_blank">View Material</a><br>
                        <button class="btn btn-secondary mt-2" @click="selectMaterial(material)">Update</button><br>
                        <button class="btn btn-danger mt-2" @click="deleteMaterial(material.id)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showModal" @close="closeModal">
            <UpdateCourseMaterial :material="selectedMaterial" @update-success="handleUpdateSuccess" />
        </Modal>
        <Modal :show="showAddModal" @close="closeAddModal">
            <AddCourseMaterial @add-success="handleAddSuccess" />
        </Modal>
    </div>
</template>

<script>
import UpdateCourseMaterial from './UpdateCourseMaterial.vue';
import AddCourseMaterial from './AddCourseMaterial.vue';
import Modal from './Modal.vue';

export default {
    name: 'CourseMaterialsPage',
    components: {
        UpdateCourseMaterial,
        AddCourseMaterial,
        Modal
    },
    data() {
        return {
            courseMaterials: [],
            showModal: false,
            showAddModal: false,
            selectedMaterial: null
        };
    },
    created() {
        this.fetchCourseMaterials();
    },
    methods: {
        async fetchCourseMaterials() {
            try {
                // Task 3 php(non-RESTful)
                // const response = await fetch('http://localhost/php-backend/index.php?action=getCourseMaterials&type=courseMaterial');

                // Task 4 php (RESTful)
                const response = await fetch('http://localhost/php-RESTful/api/course-materials');
                const data = await response.json();
                this.courseMaterials = data;
            } catch (error) {
                console.error('Error fetching course materials:', error);
            }
        },
        selectMaterial(material) {
            this.selectedMaterial = material;
            this.showModal = true;
        },
        async deleteMaterial(id) {
            try {
                // Task 2 json server

                // const response = await fetch(`http://localhost:3000/courseMaterials/${id}`, {
                //     method: 'DELETE',
                // });

                // Task 3 php(non-RESTful)
                // const response = await fetch(`http://localhost/php-backend/index.php?action=deleteCourseMaterial&type=courseMaterial&id=${id}`, {

                // Task 4 php (RESTful)
                const response = await fetch(`http://localhost/php-RESTful/api/course-materials/${id}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    this.fetchCourseMaterials();
                } else {
                    console.error('Failed to delete course material');
                }
            } catch (error) {
                console.error('Error deleting course material:', error);
            }
        },
        closeModal() {
            this.showModal = false;
        },
        closeAddModal() {
            this.showAddModal = false;
        },
        handleUpdateSuccess() {
            this.fetchCourseMaterials();
            this.closeModal();
        },
        handleAddSuccess() {
            this.fetchCourseMaterials();
            this.closeAddModal();
        }
    }
};
</script>

<style scoped></style>