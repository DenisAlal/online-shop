<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { Category, Product } from '@/types/models';

const { product, categories } = usePage<{
    product: Product & { image: string; attributes: { id: number; attribute: { id: number; name: string }; value: string }[] };
    categories: Category[];
}>().props;

const attributes = ref<{ name: string; value: string }[]>(
    product.attributes?.map((a) => ({ name: a.attribute.name, value: a.value })) ?? [],
);
const previewUrl = ref<string | null>(null);
const fileName = ref<string>('');

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.image = file;
    fileName.value = file?.name ?? '';
    previewUrl.value = file ? URL.createObjectURL(file) : null;
}

function addAttribute() {
    attributes.value.push({ name: '', value: '' });
}

function removeAttribute(index: number) {
    attributes.value.splice(index, 1);
}

const form = useForm({
    category_id: product.category_id?.toString() ?? '',
    name: product.name,
    slug: product.slug,
    description: product.description ?? '',
    price: product.price?.toString() ?? '',
    discount: product.discount?.toString() ?? '0',
    stock_quantity: product.stock_quantity?.toString() ?? '0',
    is_active: product.is_active ?? true,
    image: null as File | null,
});

function submit() {
    form
        .transform((data) => ({
            ...data,
            attributes: attributes.value.filter((a) => a.name.trim() && a.value.trim()),
        }))
        .put(`/admin/products/${product.id}`, {
            forceFormData: true,
        });
}
</script>

<template>
    <AdminLayout>
        <h1>Редактировать: {{ product.name }}</h1>

        <form @submit.prevent="submit" class="form">
            <div class="grid">
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
                    <label>Категория</label>
                    <select v-model="form.category_id">
                        <option value="">— нет —</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>Цена (₽)</label>
                    <input v-model="form.price" type="number" min="0" />
                    <div v-if="form.errors.price" class="error">{{ form.errors.price }}</div>
                </div>

                <div class="field">
                    <label>Скидка (%)</label>
                    <input v-model="form.discount" type="number" min="0" max="100" />
                </div>

                <div class="field">
                    <label>На складе</label>
                    <input v-model="form.stock_quantity" type="number" min="0" />
                </div>
            </div>

            <div class="field">
                <label>Описание</label>
                <textarea v-model="form.description" rows="4" />
            </div>

            <div class="field">
                <label>Фото</label>
                <div class="file-upload">
                    <img v-if="previewUrl" :src="previewUrl" class="upload-preview" />
                    <img v-else-if="product.image" :src="product.image" class="upload-preview" />
                    <div class="upload-placeholder" v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="32" height="32"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/></svg>
                        <span>Нажмите для выбора фото</span>
                    </div>
                    <input type="file" accept="image/*" class="file-input" @change="onFileChange" />
                    <span v-if="fileName" class="file-name">{{ fileName }}</span>
                </div>
                <div v-if="form.errors.image" class="error">{{ form.errors.image }}</div>
            </div>

            <fieldset>
                <legend>Характеристики</legend>

                <div v-for="(attr, i) in attributes" :key="i" class="attr-row">
                    <input v-model="attr.name" placeholder="Название" />
                    <input v-model="attr.value" placeholder="Значение" />
                    <button type="button" class="btn-remove" @click="removeAttribute(i)">×</button>
                </div>

                <button type="button" class="btn-add" @click="addAttribute">+ Добавить</button>
            </fieldset>

            <label class="checkbox">
                <input v-model="form.is_active" type="checkbox" />
                Активен
            </label>

            <div class="actions">
                <Button :disabled="form.processing">Сохранить</Button>
            </div>
        </form>
    </AdminLayout>
</template>

