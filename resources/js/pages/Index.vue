<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import DiscountProducts from '@/components/DiscountProducts.vue';
import PromoCarousel from '@/components/PromoCarousel.vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import type { DiscountProduct, Promo } from '@/types/models';

const { promotions, products } = usePage<{
    promotions: Promo[];
    products: DiscountProduct[];
}>().props;
</script>

<template>
    <DefaultLayout>
        <PromoCarousel :promotions="promotions" />
        <DiscountProducts :products="products" />
    </DefaultLayout>
</template>

<style scoped></style>
