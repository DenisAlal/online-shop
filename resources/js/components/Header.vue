<script setup lang="ts">
import { ChevronDownIcon } from '@heroicons/vue/24/outline';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import IconShop from '@/assets/icons/shop.svg';
import type { CatalogCategory } from '@/types/models';

const page = usePage<{
    auth: { user: { name: string; email: string; role_type: number } | null };
    catalog: CatalogCategory[];
}>();
const user = page.props.auth?.user;
const catalog = page.props.catalog;

const showDropdown = ref(false);
const showDropdownCatalog = ref(false);
const activeCatalogIndex = ref(0);

function handleLogout() {
    router.visit('/logout', {
        method: 'post',
        preserveState: false,
        preserveScroll: true,
    });
}
</script>

<template>
    <header class="header">
        <nav class="nav">
            <div class="nav-catalog">
                <a href="/" class="logo">
                    <IconShop class="icon-logo" />
                </a>

                <button
                    class="nav-catalog-button"
                    @click="showDropdownCatalog = !showDropdownCatalog"
                >
                    Категории
                    <ChevronDownIcon
                        :class="['nav-chevron', { open: showDropdownCatalog }]"
                    />
                </button>
                <Transition name="catalog-dropdown">
                    <div
                        v-if="showDropdownCatalog"
                        class="catalog-dropdown"
                        @mouseleave="showDropdownCatalog = false"
                    >
                        <div
                            class="catalog-menu"
                            @mouseenter="activeCatalogIndex = 0"
                        >
                            <a
                                v-for="(cat, i) in catalog"
                                :key="cat.id"
                                :href="`/category/${cat.slug}`"
                                class="catalog-menu-item"
                                :class="{ active: activeCatalogIndex === i }"
                                @mouseenter="activeCatalogIndex = i"
                            >
                                {{ cat.name }}
                                <svg
                                    v-if="cat.children.length"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="menu-arrow"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                    />
                                </svg>
                            </a>
                        </div>

                        <div v-if="catalog.length" class="catalog-panel">
                            <div
                                v-for="child in catalog[activeCatalogIndex]?.children ?? []"
                                :key="child.id"
                                class="catalog-panel-group"
                            >
                                <Link
                                    :href="`/category/${child.slug}`"
                                    class="group-title"
                                >
                                    {{ child.name }}
                                </Link>
                                <ul v-if="child.children.length" class="group-list">
                                    <li v-for="sub in child.children" :key="sub.id">
                                        <Link :href="`/category/${sub.slug}`">
                                            {{ sub.name }}
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>

            <div v-if="user" class="user-menu">
                <button class="user-btn" @click="showDropdown = !showDropdown">
                    <span class="avatar">{{ user.name[0] }}</span>
                    {{ user.name }}
                    <ChevronDownIcon
                        :class="['chevron', { open: showDropdown }]"
                    />
                </button>

                <Transition name="dropdown">
                    <ul
                        v-if="showDropdown"
                        class="dropdown"
                        @mouseleave="showDropdown = false"
                    >
                        <li>
                            <a href="/orders" class="dropdown-item"
                                >Мои заказы</a
                            >
                        </li>
                        <li v-if="user.role_type === 1">
                            <a href="/admin" class="dropdown-item"
                                >Панель управления</a
                            >
                        </li>
                        <li>
                            <a href="/settings" class="dropdown-item"
                                >Настройки</a
                            >
                        </li>
                        <li><hr class="divider" /></li>
                        <li>
                            <a
                                href="/logout"
                                class="dropdown-item logout"
                                @click.prevent="handleLogout"
                            >
                                Выйти
                            </a>
                        </li>
                    </ul>
                </Transition>
            </div>

            <div v-else class="auth-links">
                <a href="/login" class="btn btn-outline">Войти</a>
                <a href="/register" class="btn btn-primary">Регистрация</a>
            </div>
        </nav>
    </header>
</template>

<style scoped>
.header {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    position: sticky;
    top: 0;
    z-index: 100;
}

.nav {
    max-width: 80vw;
    margin: 0 auto;
    padding: 0 24px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav-catalog {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    padding: 6px 12px 6px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    background: #fff;
    cursor: pointer;
    color: #374151;
    transition:
        box-shadow 0.15s,
        border-color 0.15s;
}

.nav-catalog:hover {
    border-color: #d1d5db;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
}

.nav-catalog-button {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.nav-chevron {
    width: 16px;
    height: 16px;
    stroke-width: 3px;
    transition: transform 0.2s;
    color: #9ca3af;
}

.nav-chevron.open {
    transform: rotate(180deg);
}

.catalog-dropdown {
    position: absolute;
    left: 11.5vw;
    top: calc(100% + 2px);
    display: flex;
    min-width: 360px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.catalog-menu {
    flex: 0 0 240px;
    display: flex;
    flex-direction: column;
    padding: 6px;
    border-right: 1px solid #e5e7eb;
}

.catalog-menu-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 12px;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
}

.catalog-menu-item:hover {
    background: #f3f4f6;
}

.catalog-menu-item.active {
    background: #eff6ff;
    color: #2563eb;
    font-weight: 600;
}

.menu-arrow {
    width: 14px;
    height: 14px;
    color: #9ca3af;
}

.catalog-panel {
    flex: 1;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
    gap: 20px;
    min-width: 280px;
    padding: 16px 20px;
}

.catalog-panel-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.group-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    text-decoration: none;
}

.group-title:hover {
    color: #2563eb;
}

.group-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.group-list a {
    color: #6b7280;
    text-decoration: none;
    font-size: 0.88rem;
}

.group-list a:hover {
    color: #2563eb;
}

.dropdown-leave-active {
    transition: opacity 0.15s;
}

.user-menu {
    position: relative;
}

.user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px 6px 6px;
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    background: #fff;
    cursor: pointer;
    font-size: 0.875rem;
    color: #374151;
    transition:
        box-shadow 0.15s,
        border-color 0.15s;
}

.user-btn:hover {
    border-color: #d1d5db;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 999px;
    background: #2563eb;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
}

.chevron {
    transition: transform 0.2s;
    color: #9ca3af;
    width: 16px;
    height: 16px;
}

.icon-logo {
    width: 30px;
    height: 30px;
}

.chevron.open {
    transform: rotate(180deg);
}

.dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    width: 200px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    list-style: none;
    margin: 0;
    padding: 6px;
}

.dropdown-leave-active {
    transition: opacity 0.15s;
}

.dropdown-item {
    display: block;
    padding: 8px 12px;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-size: 0.875rem;
    transition: background 0.1s;
}

.dropdown-item:hover {
    background: #f3f4f6;
}

.logout {
    color: #dc2626;
}

.logout:hover {
    background: #fef2f2;
}

.divider {
    margin: 4px 0;
    border: none;
    border-top: 1px solid #e5e7eb;
}

.auth-links {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition:
        background 0.15s,
        color 0.15s;
}

.btn-outline {
    border: 1px solid #d1d5db;
    color: #374151;
    background: #fff;
}

.btn-outline:hover {
    background: #f3f4f6;
}

.btn-primary {
    background: #2563eb;
    color: #fff;
    border: 1px solid transparent;
}

.btn-primary:hover {
    background: #1d4ed8;
}
</style>
