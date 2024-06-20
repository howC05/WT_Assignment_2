<template>
    <div v-if="show" class="modal-overlay" @click.self="close">
        <div class="modal-content">
            <button class="close-btn" @click="close">X</button>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: {
        show: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    position: relative;
    width: 500px;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}
</style>