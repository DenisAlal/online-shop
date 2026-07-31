<script setup lang="ts">
import {
    PencilIcon,
    PlusIcon,
    TrashIcon,
    CheckIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import Pagination from '@/components/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { PaginatedResponse, Promo } from '@/types/models';

const page = usePage<{ promotions: PaginatedResponse<Promo> }>();
const { promotions } = page.props;

const promoToDelete = ref<Promo | null>(null);

function destroy() {
    if (!promoToDelete.value) {
        return;
    }

    const id = promoToDelete.value.id;
    promoToDelete.value = null;
    const pageNumber = page.props.promotions.current_page;
    router.visit(`/admin/promotions/${id}`, {
        method: 'delete',
        data: { page: pageNumber },
        preserveState: false,
    });
}

function formatDateOnly(date?: string | null): string {
    if (!date) {
        return '';
    }

    const d = new Date(date);
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');

    return `${y}-${m}-${day}`;
}
</script>

<template>
    <AdminLayout>
        <div class="action_panel">
            <h1>Промо</h1>
            <Button href="/admin/promotions/create">
                <PlusIcon class="h-5 w-5" />
                Создать
            </Button>
        </div>
        <table v-if="promotions.data.length != 0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Заголовок</th>
                    <th>Ссылка</th>
                    <th>Очередь</th>
                    <th>Активен</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="promo in promotions.data" :key="promo.id">
                    <td>{{ promo.id }}</td>
                    <td>
                        <img
                            v-if="promo.image"
                            :src="promo.image"
                            class="thumb"
                            alt=""
                        />
                        <span v-else class="no-img">—</span>
                    </td>
                    <td>
                        {{ promo.title }}
                    </td>
                    <td class="cell-limited" :title="promo.link_url ?? undefined">
                        {{ promo.link_url }}
                    </td>
                    <td>{{ promo.sort_order }}</td>
                    <td>
                        <CheckIcon v-if="promo.is_active" class="h-5 w-5" />
                        <XMarkIcon v-else class="h-5 w-5" />
                    </td>
                    <td>{{ formatDateOnly(promo.starts_at) }}</td>
                    <td>{{ formatDateOnly(promo.ends_at) }}</td>
                    <td class="actions">
                        <Button
                            :href="`/admin/promotions/${promo.id}/edit`"
                            variant="secondary"
                        >
                            <PencilIcon class="h-5 w-5" />
                        </Button>
                        <Button @click="promoToDelete = promo" variant="danger">
                            <TrashIcon class="h-5 w-5" />
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination
            :links="promotions.links"
            :from="promotions.from"
            :to="promotions.to"
            :total="promotions.total"
        />
        <ConfirmModal
            :show="!!promoToDelete"
            title="Удалить промо"
            :message="`Удалить промо «${promoToDelete?.title}»?`"
            @confirm="destroy"
            @cancel="promoToDelete = null"
        />
    </AdminLayout>
</template>
