<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import Button from '@/components/Button.vue';
import type { Category } from '@/types/models';

const { categories } = usePage<{ categories: Category[] }>().props;

const attributes = ref<{ name: string; value: string }[]>([]);
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
    category_id: '',
    name: '',
    slug: '',
    description: '',
    price: '',
    discount: '0',
    stock_quantity: '0',
    is_active: true,
    image: null as File | null,
});

function submit() {
    form
        .transform((data) => ({
            ...data,
            attributes: attributes.value.filter((a) => a.name.trim() && a.value.trim()),
        }))
        .post('/admin/products', {
            forceFormData: true,
        });
}
</script>

<template>
    <AdminLayout>
        <h1>Создать товар</h1>

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
                    <input v-model="form.price" type="number" step="0.01" min="0" />
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

<style scoped>
h1 { margin-bottom: 20px; }

.form {
    max-width: 640px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.field label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #374151;
}

.field input,
.field select,
.field textarea {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.9rem;
}

.error {
    color: #dc2626;
    font-size: 0.8rem;
}

.file-upload {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    background: #fafafa;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
}

.file-upload:hover {
    border-color: #2563eb;
    background: #f0f4ff;
}

.file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.upload-preview {
    max-width: 100%;
    max-height: 160px;
    object-fit: contain;
    border-radius: 6px;
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: #9ca3af;
    font-size: 0.85rem;
}

.file-name {
    font-size: 0.8rem;
    color: #374151;
    font-weight: 500;
}

fieldset {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 16px;
}

legend {
    font-weight: 600;
    font-size: 0.85rem;
    color: #374151;
    padding: 0 6px;
}

.attr-row {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
}

.attr-row input {
    flex: 1;
    padding: 6px 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.9rem;
}

.btn-remove {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #fca5a5;
    border-radius: 6px;
    background: #fff;
    color: #dc2626;
    cursor: pointer;
    font-size: 1.2rem;
}

.btn-add {
    padding: 6px 14px;
    border: 1px dashed #d1d5db;
    border-radius: 6px;
    background: transparent;
    color: #6b7280;
    cursor: pointer;
    font-size: 0.85rem;
}

.btn-add:hover {
    border-color: #2563eb;
    color: #2563eb;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    cursor: pointer;
}

.actions {
    display: flex;
    gap: 8px;
}
</style>
