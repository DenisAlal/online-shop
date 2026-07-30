<script setup lang="ts">
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedResponse, Category } from '@/types/models';
const { categories } = usePage<{ categories: PaginatedResponse<Category> }>()
    .props;

const categoryToDelete = ref<Category | null>(null);

function destroy() {
    if (!categoryToDelete.value) {
        return;
    }

    const id = categoryToDelete.value.id;
    categoryToDelete.value = null;
    router.visit(`/admin/categories/${id}`, {
        method: 'delete',
        preserveState: false,
    });
}
</script>

<template>
    <AdminLayout>
        <div class="header">
            <h1>Категории</h1>
            <Button icon="plus" href="/admin/categories/create">Создать</Button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Слаг</th>
                    <th>Родитель</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cat in categories.data" :key="cat.id">
                    <td>{{ cat.id }}</td>
                    <td>
                        <Link :href="`/admin/categories/${cat.id}`">{{
                            cat.name
                        }}</Link>
                    </td>
                    <td>{{ cat.slug }}</td>
                    <td>{{ cat.parent?.name ?? '—' }}</td>
                    <td class="actions">
                        <Button
                            :href="`/admin/categories/${cat.id}/edit`"
                            variant="secondary"
                        >
                            <PencilIcon class="h-5 w-5 text-[#374151]" />
                        </Button>
                        <Button
                            @click="categoryToDelete = cat"
                            variant="danger"
                        >
                            <TrashIcon class="h-5 w-5 text-red-400" />
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
        <ConfirmModal
            :show="!!categoryToDelete"
            title="Удалить категорию"
            :message="`Вы уверены, что хотите удалить категорию «${categoryToDelete?.name}»?`"
            @confirm="destroy"
            @cancel="categoryToDelete = null"
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
    gap: 8px;
}
</style>
