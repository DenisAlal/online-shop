<script setup lang="ts">
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedResponse, Product } from '@/types/models';

const { products } = usePage<{ products: PaginatedResponse<Product> }>().props;

const productToDelete = ref<Product | null>(null);

function destroy() {
    if (!productToDelete.value) {
        return;
    }

    const id = productToDelete.value.id;
    productToDelete.value = null;
    router.visit(`/admin/products/${id}`, {
        method: 'delete',
        preserveState: false,
    });
}
</script>

<template>
    <AdminLayout>
        <div class="header">
            <h1>Товары</h1>
            <Button href="/admin/products/create">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>
                Создать
            </Button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Скидка</th>
                    <th>Остаток</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>
                        <img
                            v-if="product.image"
                            :src="product.image"
                            class="thumb"
                        />
                        <span v-else class="no-img">—</span>
                    </td>
                    <td>
                        <Link :href="`/admin/products/${product.id}`">{{
                            product.name
                        }}</Link>
                    </td>
                    <td>{{ product.category?.name ?? '—' }}</td>
                    <td>{{ product.price }} ₽</td>
                    <td v-if="product.discount">{{ product.discount }}%</td>
                    <td v-else>—</td>
                    <td>{{ product.stock_quantity }}</td>
                    <td class="actions">
                        <Button
                            :href="`/admin/products/${product.id}/edit`"
                            variant="secondary"
                        >
                            <PencilIcon class="h-5 w-5" />
                        </Button>
                        <Button
                            @click="productToDelete = product"
                            variant="danger"
                        >
                            <TrashIcon class="h-5 w-5" />
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>

        <ConfirmModal
            :show="!!productToDelete"
            title="Удалить товар"
            :message="`Удалить товар «${productToDelete?.name}»?`"
            @confirm="destroy"
            @cancel="productToDelete = null"
        />
    </AdminLayout>
</template>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

h1 {
    margin: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    text-align: left;
    padding: 10px 12px;
    border-bottom: 1px solid #e5e7eb;
}

th {
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #6b7280;
}

.actions {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
}

.thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 6px;
}

.no-img {
    color: #d1d5db;
    font-size: 1.2rem;
}
</style>
