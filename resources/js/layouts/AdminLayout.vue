<script setup lang="ts">
import AdminHeader from '@/components/AdminHeader.vue';

const navItems = [
    { label: 'Категории', href: '/admin/categories' },
    { label: 'Товары', href: '/admin/products' },
    { label: 'Промо', href: '/admin/promotions' },
    { label: 'Заказы', href: '/admin/orders' },
];
</script>

<template>
    <div class="admin-layout">
        <AdminHeader />
        <div class="admin-body">
            <aside class="sidebar">
                <nav>
                    <a
                        v-for="item in navItems"
                        :key="item.label"
                        :href="item.href"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith(item.href) }"
                    >
                        {{ item.label }}
                    </a>
                </nav>
            </aside>
            <main class="content">
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
/* ─── Layout ─────────────────────────────────────────── */
.admin-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.admin-body {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 220px;
    background: #f9fafb;
    border-right: 1px solid #e5e7eb;
    padding: 16px 0;
    flex-shrink: 0;
}

.nav-link {
    display: block;
    padding: 10px 20px;
    color: #374151;
    text-decoration: none;
    font-size: 0.9rem;
    transition: background 0.1s;
}

.nav-link:hover {
    background: #e5e7eb;
}

.nav-link.active {
    background: #e0e7ff;
    color: #2563eb;
    font-weight: 600;
}

.content {
    flex: 1;
    padding: 24px;
    background: #fff;
}

/* ─── Общие заголовки и таблицы ─────────────────────── */
h1 {
    margin-bottom: 20px;
}

.action_panel {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.action_panel h1 {
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

.cell-limited {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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

/* ─── Формы ─────────────────────────────────────────── */
.form {
    max-width: 640px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form--narrow {
    max-width: 500px;
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

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.85rem;
    text-decoration: none;
    cursor: pointer;
}

.btn--form {
    align-self: flex-start;
    padding: 10px 24px;
}

.btn:disabled {
    opacity: 0.5;
}

/* ─── Загрузка изображений ──────────────────────────── */
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
    transition:
        border-color 0.15s,
        background 0.15s;
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

/* ─── Характеристики ────────────────────────────────── */
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

/* ─── Карточка товара / детали ──────────────────────── */
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

.card--narrow {
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
