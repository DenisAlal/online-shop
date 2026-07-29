<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage<{
    auth: { user: { name: string; email: string; role_type: number } | null };
}>();
const user = page.props.auth?.user;

const showDropdown = ref(false);

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
            <a href="/" class="logo">Магазин</a>

            <div v-if="user" class="user-menu">
                <button class="user-btn" @click="showDropdown = !showDropdown">
                    <span class="avatar">{{ user.name[0] }}</span>
                    {{ user.name }}
                    <svg
                        :class="['chevron', { open: showDropdown }]"
                        width="16"
                        height="16"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                        />
                    </svg>
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
                            <a href="/admin" class="dropdown-item">Панель управления</a>
                        </li>
                        <li>
                            <a href="/settings" class="dropdown-item">Настройки</a>
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
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    text-decoration: none;
    letter-spacing: -0.02em;
}

.logo:hover {
    color: #2563eb;
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

.dropdown-enter-active {
    transition:
        opacity 0.15s,
        transform 0.15s;
}

.dropdown-enter-from {
    opacity: 0;
    transform: translateY(-6px);
}

.dropdown-leave-active {
    transition: opacity 0.1s;
}

.dropdown-leave-to {
    opacity: 0;
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
