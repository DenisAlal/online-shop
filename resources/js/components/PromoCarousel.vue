<script setup lang="ts">
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import type { Promo } from '@/types/models';

const props = withDefaults(
    defineProps<{
        promotions: Promo[];
        autoplay?: boolean;
        interval?: number;
    }>(),
    {
        autoplay: true,
        interval: 5000,
    },
);

const currentIndex = ref(0);
const autoplayTimer = ref<ReturnType<typeof setInterval> | null>(null);
const isPaused = ref(false);

const slideCount = props.promotions.length;

function startAutoplay() {
    stopAutoplay();

    if (!props.autoplay || slideCount < 2) {
        return;
    }

    autoplayTimer.value = setInterval(() => {
        if (!isPaused.value) {
            currentIndex.value = (currentIndex.value + 1) % slideCount;
        }
    }, props.interval);
}

function stopAutoplay() {
    if (autoplayTimer.value) {
        clearInterval(autoplayTimer.value);
        autoplayTimer.value = null;
    }
}

function next() {
    currentIndex.value = (currentIndex.value + 1) % slideCount;
}

function prev() {
    currentIndex.value = (currentIndex.value - 1 + slideCount) % slideCount;
}

function goTo(index: number) {
    currentIndex.value = index;
}

watch(
    () => props.promotions.length,
    () => {
        currentIndex.value = 0;
        startAutoplay();
    },
);

onMounted(startAutoplay);
onBeforeUnmount(stopAutoplay);
</script>

<template>
    <div
        v-if="slideCount"
        class="carousel"
        @mouseenter="isPaused = true"
        @mouseleave="isPaused = false"
    >
        <div class="carousel-viewport">
            <div
                class="carousel-track"
                :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
            >
                <div
                    v-for="promo in promotions"
                    :key="promo.id"
                    class="carousel-slide"
                >
                    <Link
                        v-if="promo.link_url"
                        :href="promo.link_url"
                        class="slide-content"
                        :class="{ 'has-image': promo.image }"
                    >
                        <img
                            v-if="promo.image"
                            :src="promo.image"
                            :alt="promo.title"
                            class="slide-image"
                        />
                        <div class="slide-overlay">
                            <h2 class="slide-title">{{ promo.title }}</h2>
                            <p
                                v-if="promo.description"
                                class="slide-description"
                            >
                                {{ promo.description }}
                            </p>
                        </div>
                    </Link>
                    <div
                        v-else
                        class="slide-content"
                        :class="{ 'has-image': promo.image }"
                    >
                        <img
                            v-if="promo.image"
                            :src="promo.image"
                            :alt="promo.title"
                            class="slide-image"
                        />
                        <div class="slide-overlay">
                            <h2 class="slide-title">{{ promo.title }}</h2>
                            <p
                                v-if="promo.description"
                                class="slide-description"
                            >
                                {{ promo.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <button
                v-if="slideCount > 1"
                type="button"
                class="nav-btn nav-prev"
                aria-label="Предыдущий слайд"
                @click="prev"
            >
                <ChevronLeftIcon class="h-6 w-6" />
            </button>
            <button
                v-if="slideCount > 1"
                type="button"
                class="nav-btn nav-next"
                aria-label="Следующий слайд"
                @click="next"
            >
                <ChevronRightIcon class="h-6 w-6" />
            </button>
        </div>

        <div v-if="slideCount > 1" class="carousel-dots">
            <button
                v-for="(promo, i) in promotions"
                :key="promo.id"
                type="button"
                class="dot"
                :class="{ active: i === currentIndex }"
                :aria-label="`Слайд ${i + 1}`"
                @click="goTo(i)"
            ></button>
        </div>
    </div>
</template>

<style scoped>
.carousel {
    position: relative;
    max-width: 80vw;
    margin: 0 auto;
    padding: 0 24px;
}

.carousel-viewport {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 12px 32px -12px rgba(15, 23, 42, 0.25);
}

.carousel-track {
    display: flex;
    transition: transform 0.5s ease;
}

.carousel-slide {
    flex: 0 0 100%;
    min-width: 100%;
}

.slide-content {
    position: relative;
    display: block;
    height: 30vw;
    background: linear-gradient(120deg, #1e3a8a 0%, #3b82f6 55%, #60a5fa 100%);
    overflow: hidden;
}

.slide-content.has-image {
    background: #0f172a;
}

.slide-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 12px;
    padding: 32px;
    text-align: center;
    color: #fff;
    background: rgba(15, 23, 42, 0.35);
}

.has-image .slide-overlay {
    background: linear-gradient(
        to top,
        rgba(15, 23, 42, 0.75) 0%,
        rgba(15, 23, 42, 0.1) 60%
    );
}

.slide-title {
    margin: 0;
    font-size: 2.25rem;
    font-weight: 700;
    text-shadow: 0 2px 8px rgba(15, 23, 42, 0.4);
}

.slide-description {
    margin: 0;
    max-width: 560px;
    font-size: 1.05rem;
    line-height: 1.5;
    opacity: 0.9;
    text-shadow: 0 1px 4px rgba(15, 23, 42, 0.4);
}

.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    color: #0f172a;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
    cursor: pointer;
    transition:
        background 0.15s,
        transform 0.15s;
}

.nav-btn:hover {
    background: #fff;
    transform: translateY(-50%) scale(1.05);
}

.nav-prev {
    left: 16px;
}

.nav-next {
    right: 16px;
}

.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
}

.dot {
    width: 10px;
    height: 10px;
    border: none;
    border-radius: 50%;
    background: #d1d5db;
    cursor: pointer;
    transition:
        background 0.15s,
        transform 0.15s;
}

.dot:hover {
    background: #9ca3af;
}

.dot.active {
    background: #2563eb;
    transform: scale(1.25);
}
</style>
