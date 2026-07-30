<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import Button from '@/components/Button.vue';
import type { Product } from '@/types/models';

type ProductWithRelations = Product & {
    image: string;
    category: { id: number; name: string } | null;
    attributes: { id: number; attribute: { name: string }; value: string }[];
};

const { product } = usePage<{ product: ProductWithRelations }>().props;
</script>

<template>
    <AdminLayout>
        <div class="breadcrumbs">
            <Link href="/admin/products">Товары</Link>
            <span> / {{ product.name }}</span>
        </div>

        <div class="card">
            <div class="card-header">
                <h1>{{ product.name }}</h1>
                <Button :href="`/admin/products/${product.id}/edit`"
                    >Редактировать</Button
                >
            </div>

            <div class="body">
                <div class="image-col">
                    <img
                        v-if="product.image"
                        :src="product.image"
                        class="main-img"
                    />
                    <div v-else class="no-image">Нет фото</div>
                </div>

                <div class="info">
                    <div class="row">
                        <span class="label">ID</span
                        ><span>{{ product.id }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Слаг</span
                        ><span>{{ product.slug }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Категория</span
                        ><span>{{ product.category?.name ?? '—' }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Цена</span
                        ><span>{{ product.price }} ₽</span>
                    </div>
                    <div class="row" v-if="product.discount">
                        <span class="label">Скидка</span
                        ><span>{{ product.discount }}%</span>
                    </div>
                    <div class="row">
                        <span class="label">На складе</span
                        ><span>{{ product.stock_quantity }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Активен</span
                        ><span>{{ product.is_active ? 'Да' : 'Нет' }}</span>
                    </div>
                    <div class="row" v-if="product.description">
                        <span class="label">Описание</span
                        ><span>{{ product.description }}</span>
                    </div>
                </div>
            </div>

            <div class="attrs-section" v-if="product.attributes?.length">
                <h2>Характеристики</h2>
                <div v-for="pa in product.attributes" :key="pa.id" class="row">
                    <span class="label">{{ pa.attribute.name }}</span>
                    <span>{{ pa.value }}</span>
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

.body {
    display: flex;
    gap: 32px;
    padding: 24px;
}

.image-col {
    flex-shrink: 0;
}

.main-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.no-image {
    width: 200px;
    height: 200px;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.9rem;
}

.info {
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
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
