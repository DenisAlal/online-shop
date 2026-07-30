<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import type { Category } from '@/types/models';

const { category, parentCategories } = usePage<{ category: Category; parentCategories: Category[] }>().props;

const form = useForm({
    name: category.name,
    slug: category.slug,
    description: category.description ?? '',
    parent_id: category.parent_id ?? '',
});

function submit() {
    form.put(`/admin/categories/${category.id}`);
}
</script>

<template>
    <AdminLayout>
        <h1>Редактировать: {{ category.name }}</h1>

        <form @submit.prevent="submit" class="form">
            <div class="field">
                <label>Название</label>
                <input v-model="form.name" />
                <div v-if="form.errors.name" class="error">{{ form.errors.name }}</div>
            </div>

            <div class="field">
                <label>Слаг</label>
                <input v-model="form.slug" />
                <div v-if="form.errors.slug" class="error">{{ form.errors.slug }}</div>
            </div>

            <div class="field">
                <label>Описание</label>
                <textarea v-model="form.description" />
            </div>

            <div class="field">
                <label>Родительская категория</label>
                <select v-model="form.parent_id">
                    <option value="">— нет —</option>
                    <option v-for="cat in parentCategories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <button type="submit" :disabled="form.processing" class="btn">Сохранить</button>
        </form>
    </AdminLayout>
</template>

<style scoped>
h1 {
    margin-bottom: 20px;
}

.form {
    max-width: 500px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.field label {
    font-weight: 600;
    font-size: 0.9rem;
}

.field input, .field select, .field textarea {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
}

.error {
    color: #dc2626;
    font-size: 0.8rem;
}

.btn {
    align-self: flex-start;
    padding: 10px 24px;
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn:disabled {
    opacity: 0.5;
}
</style>
