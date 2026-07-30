<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import type { Category } from '@/types/models';

const { category } = usePage<{ category: Category }>().props;
</script>

<template>
    <AdminLayout>
        <div class="breadcrumbs">
            <Link href="/admin/categories">Категории</Link>
            <span> / </span>
            <span>{{ category.name }}</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h1>{{ category.name }}</h1>
                <Link :href="`/admin/categories/${category.id}/edit`" class="btn">Редактировать</Link>
            </div>

            <div class="info">
                <div class="row">
                    <span class="label">ID</span>
                    <span>{{ category.id }}</span>
                </div>
                <div class="row">
                    <span class="label">Слаг</span>
                    <span>{{ category.slug }}</span>
                </div>
                <div class="row">
                    <span class="label">Родитель</span>
                    <span>{{ category.parent?.name ?? '—' }}</span>
                </div>
                <div class="row">
                    <span class="label">Описание</span>
                    <span>{{ category.description ?? '—' }}</span>
                </div>
                <div class="row">
                    <span class="label">Товаров</span>
                    <span>{{ category.products.length }}</span>
                </div>
                <div class="row">
                    <span class="label">Создана</span>
                    <span>{{ category.created_at }}</span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.breadcrumbs {
    margin-bottom: 16px;
    font-size: 0.9rem;
    color: #6b7280;
}

.breadcrumbs a {
    color: #2563eb;
    text-decoration: none;
}

.card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    max-width: 600px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h1 {
    margin: 0;
    font-size: 1.25rem;
}

.btn {
    padding: 8px 16px;
    background: #2563eb;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
}

.info {
    padding: 16px 24px 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.row {
    display: flex;
    gap: 12px;
}

.label {
    min-width: 100px;
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
}
</style>
