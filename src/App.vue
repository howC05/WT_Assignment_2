<!-- src/App.vue -->
<script setup>
import { ref } from 'vue';
import HomePage from './components/HomePage.vue';
import Modal from './components/Modal.vue';
import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegisterForm.vue';
import { RouterView } from 'vue-router';


const showModal = ref(false);
const modalComponent = ref(null);
const userEmail = ref(null);

function openModal(componentName) {
  if (componentName === 'LoginForm') {
    modalComponent.value = LoginForm;
  } else if (componentName === 'RegisterForm') {
    modalComponent.value = RegisterForm;
  }
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  modalComponent.value = null;
}

function handleLoginSuccess(email) {
  userEmail.value = email;
  closeModal();
}
</script>

<template>
  <div id="app">
    <NavBar></NavBar>
    <RouterView :user-email="userEmail" @open-modal="openModal" />
    <Modal :show="showModal" @close="closeModal">
      <component :is="modalComponent" @login-success="handleLoginSuccess" />
    </Modal>
  </div>
</template>

<style scoped></style>
