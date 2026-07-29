<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
</script>

<template>
    <div class="layout">
        <Header />
        <main class="content">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<style scoped>
.layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.content {
    flex: 1;
}
</style>
