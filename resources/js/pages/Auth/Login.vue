<script setup lang="ts">
import {
    EnvelopeIcon,
    EyeIcon,
    EyeSlashIcon,
    LockClosedIcon,
} from '@heroicons/vue/24/outline';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthHeader from '@/components/AuthHeader.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

function submit() {
    form.post('/login');
}
</script>

<template>
    <AuthHeader />
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                        />
                    </svg>
                </div>
                <h1>Войти в аккаунт</h1>
                <p class="auth-subtitle">Авторизуйтесь, чтобы делать покупки</p>
            </div>
            <form class="auth-form" @submit.prevent="submit">
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <EnvelopeIcon class="input-icon" />
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="you@example.com"
                            autocomplete="email"
                            :class="{ 'input-error': form.errors.email }"
                        />
                    </div>
                    <div v-if="form.errors.email" class="error">
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="field">
                    <label for="password">Пароль</label>
                    <div class="input-wrap">
                        <LockClosedIcon class="input-icon" />
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Минимум 8 символов"
                            autocomplete="new-password"
                            :class="{ 'input-error': form.errors.password }"
                        />
                        <button
                            type="button"
                            class="eye-btn"
                            @click="showPassword = !showPassword"
                            :aria-label="
                                showPassword
                                    ? 'Скрыть пароль'
                                    : 'Показать пароль'
                            "
                        >
                            <EyeSlashIcon v-if="showPassword" class="h-5 w-5" />
                            <EyeIcon v-else class="h-5 w-5" />
                        </button>
                    </div>
                    <div v-if="form.errors.password" class="error">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="checkbox-div">
                    <label>
                        <input
                            class="checkbox-input"
                            v-model="form.remember"
                            type="checkbox"
                        />
                        Запомнить
                    </label>
                </div>

                <button
                    type="submit"
                    class="submit-btn"
                    :disabled="form.processing"
                >
                    <svg
                        v-if="form.processing"
                        class="spinner"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 0 1 4 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    <span v-if="form.processing">Вход…</span>
                    <span v-else>Войти</span>
                </button>
            </form>
            <p class="auth-footer">
                Еще нет аккаунта?
                <Link href="/register" class="auth-link"
                    >Зарегистрироваться</Link
                >
            </p>
        </div>
    </div>
</template>

<style scoped>
.checkbox-div {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.checkbox-div label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #393d45;
    font-size: 14px;
}

.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: linear-gradient(180deg, #fff 0%, #f2f7fd 50%, #d6e5fd 100%);
}

.auth-card {
    width: 100%;
    max-width: 420px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 40px 36px;
    box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.15);
}

.auth-header {
    text-align: center;
    margin-bottom: 28px;
}
.auth-header h1 {
    margin: 0 0 6px;
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
}

.auth-subtitle {
    margin: 0;
    font-size: 0.9rem;
    color: #6b7280;
}
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.auth-logo {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    background: #eff6ff;
    border-radius: 14px;
}

.auth-footer {
    margin: 24px 0 0;
    text-align: center;
    font-size: 0.9rem;
    color: #6b7280;
}

.auth-link {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.auth-link:hover {
    text-decoration: underline;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 12px;
    width: 18px;
    height: 18px;
    color: #9ca3af;
    pointer-events: none;
}

.input-wrap input {
    width: 100%;
    padding: 11px 12px 11px 40px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #0f172a;
    background: #fafafa;
    outline: none;
    transition:
        border-color 0.15s,
        box-shadow 0.15s,
        background 0.15s;
}

.input-wrap input::placeholder {
    color: #9ca3af;
}

.input-wrap input:focus {
    border-color: #2563eb;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.input-wrap input.input-error {
    border-color: #dc2626;
}
.eye-btn {
    position: absolute;
    right: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: #9ca3af;
    border-radius: 6px;
    cursor: pointer;
}

.eye-btn:hover {
    color: #374151;
    background: #f3f4f6;
}

.error {
    font-size: 0.8rem;
    color: #dc2626;
}

.submit-btn {
    margin-top: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    background: #2563eb;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.15s;
}

.submit-btn:hover {
    background: #1d4ed8;
}

.submit-btn:disabled {
    opacity: 0.6;
    cursor: default;
}

.spinner {
    width: 18px;
    height: 18px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
