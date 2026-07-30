<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login');
}
</script>

<template>
    <form @submit.prevent="submit">
        <div v-if="form.errors.email">{{ form.errors.email }}</div>

        <input v-model="form.email" type="email" placeholder="Email" />
        <input v-model="form.password" type="password" placeholder="Пароль" />
        <label>
            <input v-model="form.remember" type="checkbox" /> Запомнить
        </label>

        <button :disabled="form.processing">Войти</button>
    </form>
</template>
