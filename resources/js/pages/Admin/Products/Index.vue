<script setup lang="ts">
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import Pagination from '@/components/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedResponse, Product } from '@/types/models';

const page = usePage<{ products: PaginatedResponse<Product> }>();
const { products } = page.props;

const productToDelete = ref<Product | null>(null);

function destroy() {
    if (!productToDelete.value) {
        return;
    }

    const id = productToDelete.value.id;
    productToDelete.value = null;
    const pageNumber = page.props.products.current_page;
    router.visit(`/admin/products/${id}`, {
        method: 'delete',
        data: { page: pageNumber },
        preserveState: false,
    });
}
</script>

<template>
    <AdminLayout>
        <div class="action_panel">
            <h1>Товары</h1>
            <Button href="/admin/products/create">
                <PlusIcon class="h-5 w-5 text-shadow-white" />
                Создать
            </Button>
        </div>

        <table v-if="products.data.length != 0">
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
                    <td>{{product.name}}</td>
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

        <Pagination
            v-if="products.data.length !== 0"
            :links="products.links"
            :from="products.from"
            :to="products.to"
            :total="products.total"
        />

        <ConfirmModal
            :show="!!productToDelete"
            title="Удалить товар"
            :message="`Удалить товар «${productToDelete?.name}»?`"
            @confirm="destroy"
            @cancel="productToDelete = null"
        />
    </AdminLayout>
</template>
