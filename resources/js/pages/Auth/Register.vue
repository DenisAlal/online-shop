<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register');
}
</script>

<template>
    <form @submit.prevent="submit">
        <div v-if="form.errors.name">{{ form.errors.name }}</div>
        <div v-if="form.errors.email">{{ form.errors.email }}</div>
        <div v-if="form.errors.password">{{ form.errors.password }}</div>

        <input v-model="form.name" placeholder="Имя" />
        <input v-model="form.email" type="email" placeholder="Email" />
        <input v-model="form.password" type="password" placeholder="Пароль" />
        <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Подтверждение"
        />

        <button :disabled="form.processing">Зарегистрироваться</button>
    </form>
</template>
