<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Category } from '@/types/models';

const { parentCategories } = usePage<{ parentCategories: Category[] }>().props;

const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: '',
});

function submit() {
    form.post('/admin/categories');
}
</script>

<template>
    <AdminLayout>
        <h1>Создать категорию</h1>

        <form @submit.prevent="submit" class="form form--narrow">
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
                <div v-if="form.errors.parent_id" class="error">
                    {{ form.errors.parent_id }}
                </div>
            </div>

            <button type="submit" :disabled="form.processing" class="btn btn--form">Сохранить</button>
        </form>
    </AdminLayout>
</template>
