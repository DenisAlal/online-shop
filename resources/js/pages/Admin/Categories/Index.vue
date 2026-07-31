<script setup lang="ts">
import { PencilIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import Pagination from '@/components/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedResponse, Category } from '@/types/models';
const page = usePage<{ categories: PaginatedResponse<Category> }>();
const { categories } = page.props;

const categoryToDelete = ref<Category | null>(null);

function destroy() {
    if (!categoryToDelete.value) {
        return;
    }

    const id = categoryToDelete.value.id;
    categoryToDelete.value = null;
    const pageNumber = page.props.categories.current_page;
    router.visit(`/admin/categories/${id}`, {
        method: 'delete',
        data: { page: pageNumber },
        preserveState: false,
    });
}
</script>

<template>
    <AdminLayout>
        <div class="action_panel">
            <h1>Категории</h1>
            <Button href="/admin/categories/create">
                <PlusIcon class="h-5 w-5 text-shadow-white" />Создать</Button
            >
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
                    <td>{{cat.name }}</td>
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
        <Pagination
            v-if="categories.data.length !== 0"
            :links="categories.links"
            :from="categories.from"
            :to="categories.to"
            :total="categories.total"
        />
        <ConfirmModal
            :show="!!categoryToDelete"
            title="Удалить категорию"
            :message="`Вы уверены, что хотите удалить категорию «${categoryToDelete?.name}»?`"
            @confirm="destroy"
            @cancel="categoryToDelete = null"
        />
    </AdminLayout>
</template>
