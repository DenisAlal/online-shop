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

<style scoped>
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
</style>
