<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Promo } from '@/types/models';

function toDateInputValue(date: string | null): string {
    return date?.slice(0, 10) ?? '';
}

const { promotion } = usePage<{ promotion: Promo }>().props;

const form = useForm({
    title: promotion.title,
    description: promotion.description ?? '',
    link_url: promotion.link_url ?? '',
    sort_order: String(promotion.sort_order),
    is_active: promotion.is_active,
    starts_at: toDateInputValue(promotion.starts_at),
    ends_at: toDateInputValue(promotion.ends_at),
    image: null as File | null,
});

const previewUrl = ref<string | null>(null);
const fileName = ref<string>('');

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.image = file;
    fileName.value = file?.name ?? '';
    previewUrl.value = file ? URL.createObjectURL(file) : null;
}

function submit() {
    form.put(`/admin/promotions/${promotion.id}`, {
        forceFormData: true,
    });
}
</script>

<template>
    <AdminLayout>
        <h1>Редактировать промо: {{ promotion.title }}</h1>

        <form @submit.prevent="submit" class="form">
            <div class="field">
                <label>Заголовок</label>
                <input v-model="form.title" />
                <div v-if="form.errors.title" class="error">
                    {{ form.errors.title }}
                </div>
            </div>

            <div class="field">
                <label>Описание</label>
                <textarea v-model="form.description" rows="4" />
            </div>

            <div class="field">
                <label>Ссылка</label>
                <input v-model="form.link_url" placeholder="https://…" />
                <div v-if="form.errors.link_url" class="error">
                    {{ form.errors.link_url }}
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label>Очередь (сортировка)</label>
                    <input v-model="form.sort_order" type="number" min="0" />
                    <div v-if="form.errors.sort_order" class="error">
                        {{ form.errors.sort_order }}
                    </div>
                </div>

                <div class="field">
                    <label>Активен</label>
                    <label class="checkbox">
                        <input v-model="form.is_active" type="checkbox" />
                        Показывать на сайте
                    </label>
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label>Начало</label>
                    <input v-model="form.starts_at" type="date" />
                </div>

                <div class="field">
                    <label>Окончание</label>
                    <input v-model="form.ends_at" type="date" />
                </div>
            </div>

            <div class="field">
                <label>Фото</label>
                <div class="file-upload">
                    <img v-if="previewUrl" :src="previewUrl" class="upload-preview" />
                    <img v-else-if="promotion.image" :src="promotion.image" class="upload-preview" />
                    <div class="upload-placeholder" v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="32" height="32"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/></svg>
                        <span>Нажмите для выбора фото</span>
                    </div>
                    <input type="file" accept="image/*" class="file-input" @change="onFileChange" />
                    <span v-if="fileName" class="file-name">{{ fileName }}</span>
                </div>
                <div v-if="form.errors.image" class="error">
                    {{ form.errors.image }}
                </div>
            </div>

            <div class="actions">
                <Button :disabled="form.processing">Сохранить</Button>
            </div>
        </form>
    </AdminLayout>
</template>
