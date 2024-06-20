<template>
    <div class="main">
        <Navbar />
        <Content :user-email="userEmail" @open-modal="$emit('open-modal', $event)" />
    </div>
</template>

<script>
import Navbar from './NavBar.vue'
import Content from './Content.vue'
import { RouterView } from 'vue-router';

export default {
    name: "HomePage",
    components: {
        Navbar,
        Content
    },
    props: {
        userEmail: {
            type: String,
            default: null
        }
    }
};
</script>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.main {
    width: 100%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5)50%, rgba(0, 0, 0, 0.5)50%), url(/src/assets/3.jpg);
    background-position: center;
    background-size: cover;
    height: 100vh;
}
</style>