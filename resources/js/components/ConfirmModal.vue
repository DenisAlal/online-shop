<script setup lang="ts">
defineProps<{
    show: boolean;
    title: string;
    message: string;
}>();

const emit = defineEmits<{
    confirm: [];
    cancel: [];
}>();
</script>

<template>
    <Teleport to="body">
        <Transition name="fade">
            <div v-if="show" class="overlay" @click.self="emit('cancel')">
                <div class="modal">
                    <h3>{{ title }}</h3>
                    <p>{{ message }}</p>
                    <div class="actions">
                        <button class="btn btn-cancel" @click="emit('cancel')">Отмена</button>
                        <button class="btn btn-danger" @click="emit('confirm')">Удалить</button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modal h3 {
    margin: 0 0 8px;
}

.modal p {
    margin: 0 0 20px;
    color: #6b7280;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.btn {
    padding: 8px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
}

.btn-danger {
    background: #dc2626;
    color: #fff;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
