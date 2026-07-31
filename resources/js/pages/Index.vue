<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import PromoCarousel from '@/components/PromoCarousel.vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import type { Promo } from '@/types/models';

const { promotions } = usePage<{ promotions: Promo[] }>().props;
</script>

<template>
    <DefaultLayout>
        <PromoCarousel :promotions="promotions" />
    </DefaultLayout>
</template>

<style scoped></style>
