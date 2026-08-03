<script setup lang="ts">
import { ref } from 'vue';
import type { DiscountProduct } from '@/types/models';

defineProps<{
    products: DiscountProduct[];
}>();

const container = ref<HTMLDivElement | null>(null);

const scroll = (step: number) => {
    if (!container.value) {
        return;
    }

    container.value.scrollBy({
        left: step * 200,
        behavior: 'smooth',
    });
};

const canScrollLeft = () => {
    if (!container.value) {
        return false;
    }

    return container.value.scrollLeft > 0;
};

const canScrollRight = () => {
    if (!container.value) {
        return false;
    }

    const c = container.value;

    return c.scrollLeft + c.clientWidth < c.scrollWidth;
};

const finalPrice = (price: number, percent: number): string => {
    const discountValue = price * (percent / 100);
    const test = Number(price - discountValue);

    return test.toFixed(0);
};
</script>

<template>
    <div class="discount-catalog">
        <div class="catalog-header">
            <h3 class="font-bold text-Sxl">Товары со скидкой</h3>
            <div class="scroll-controls">
                <button
                    :disabled="!canScrollLeft()"
                    @click="scroll(-1)"
                    class="scroll-btn"
                >
                    ←
                </button>
                <button
                    :disabled="!canScrollRight()"
                    @click="scroll(1)"
                    class="scroll-btn"
                >
                    →
                </button>
            </div>
        </div>

        <div ref="container" class="products-container">
            <div v-for="item in products" :key="item.id" class="product-card">
                <div class="product-name">{{ item.name }}</div>
                <div class="image-wrapper">
                    <img
                        v-if="item.image"
                        :src="item.image"
                        alt=""
                        class="product-image"
                    />
                    <span v-else class="no-img">—</span>
                    <div
                        v-if="item.discount > 0"
                        class="product-discount-badge"
                    >
                        −{{ item.discount }}%
                    </div>
                </div>
                <div class="product-price-block">
                    <div class="product-final-price">
                        {{ finalPrice(item.price, item.discount) }} ₽
                    </div>
                    <div v-if="item.discount > 0" class="product-old-price">
                        {{ item.price }} ₽
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.discount-catalog {
    padding: 16px 11vw;
}

.image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 6px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.product-discount-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-weight: 500;
}

.scroll-controls {
    display: flex;
    gap: 8px;
}

.scroll-btn {
    width: 32px;
    height: 32px;
    border: 1px solid #e5e7eb;
    background: #f5f5f5;
    cursor: pointer;
}

.scroll-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.products-container {
    display: flex;
    overflow-x: auto;
    gap: 16px;
    padding-bottom: 8px;
}

.products-container::-webkit-scrollbar {
    height: 6px;
}
.products-container::-webkit-scrollbar-track {
    background: transparent;
}
.products-container::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.product-card {
    width: 250px;
    padding: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.product-name {
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price-block {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 4px;
}

.product-old-price {
    color: #999;
    text-decoration: line-through;
    font-size: 13px;
}

.product-final-price {
    font-weight: 700;
    font-size: 18px;
    color: #222;
}

.product-discount-badge {
    align-self: flex-start;
    background: #ff4d4d;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
}
</style>
