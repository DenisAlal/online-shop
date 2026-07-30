<script setup lang="ts">
withDefaults(
    defineProps<{
        variant?: 'primary' | 'secondary' | 'danger' | 'ghost';
        size?: 'sm' | 'md' | 'lg';
        href?: string;
        disabled?: boolean;
        loading?: boolean;
    }>(),
    {
        variant: 'primary',
        size: 'sm',
        disabled: false,
        loading: false,
    },
);

const emit = defineEmits<{
    click: [e: MouseEvent];
}>();
</script>

<template>
    <a
        v-if="href && !disabled"
        :href="href"
        class="btn"
        :class="[variant, size]"
    >
        <slot />
    </a>

    <button
        v-else
        :disabled="disabled || loading"
        class="btn"
        :class="[variant, size]"
        @click="emit('click', $event)"
    >
        <slot />
    </button>
</template>

<style scoped>
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.1s, border-color 0.1s, color 0.1s;
}

.btn:disabled {
    opacity: 0.5;
    pointer-events: none;
}

/* sizes */
.sm {
    padding: 6px 12px;
    font-size: 0.85rem;
}

.md {
    padding: 10px 18px;
    font-size: 0.9rem;
}

.lg {
    padding: 12px 24px;
    font-size: 1rem;
}

/* variants */
.primary {
    background: #2563eb;
    color: #fff;
    border: 1px solid #2563eb;
}

.primary:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}

.secondary {
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
}

.secondary:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}

.danger {
    background: #fff;
    color: #dc2626;
    border: 1px solid #fca5a5;
}

.danger:hover {
    background: #fef2f2;
    border-color: #dc2626;
}

.ghost {
    background: transparent;
    color: #6b7280;
    border: 1px solid transparent;
}

.ghost:hover {
    background: #f3f4f6;
    color: #374151;
}
</style>
