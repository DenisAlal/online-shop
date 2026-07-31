<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface PageLink {
    url: string | null;
    label: string;
    active: boolean;
}

defineProps<{
    links: PageLink[];
    from?: number;
    to?: number;
    total?: number;
}>();
</script>

<template>
    <nav v-if="links.length > 1" class="pagination">
        <template v-if="total">
            <span class="pagination-info">
                {{ from }}–{{ to }} из {{ total }}
            </span>
        </template>

        <template v-for="(link, i) in links" :key="i">
            <Link
                v-if="link.url"
                :href="link.url"
                class="pagination-btn"
                :class="{ active: link.active }"
                preserve-scroll
            >
                <span v-if="link.label.includes('Previous')">‹</span>
                <span v-else-if="link.label.includes('Next')">›</span>
                <span v-else v-html="link.label"></span>
            </Link>
            <span
                v-else
                class="pagination-btn disabled"
                v-html="
                    link.label.includes('Previous')
                        ? '‹'
                        : link.label.includes('Next')
                          ? '›'
                          : '…'
                "
            ></span>
        </template>
    </nav>
</template>

<style scoped>
.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 20px;
}

.pagination-info {
    margin-right: auto;
    font-size: 0.85rem;
    color: #6b7280;
}

.pagination-btn {
    min-width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 8px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #fff;
    color: #374151;
    font-size: 0.85rem;
    text-decoration: none;
    transition: border-color 0.15s, background 0.15s, color 0.15s;
}

.pagination-btn:hover {
    border-color: #2563eb;
    color: #2563eb;
}

.pagination-btn.active {
    background: #2563eb;
    border-color: #2563eb;
    color: #fff;
    font-weight: 600;
}

.pagination-btn.disabled {
    color: #d1d5db;
    border-color: #e5e7eb;
    cursor: default;
}
</style>
