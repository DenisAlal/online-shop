<script setup lang="ts">

</script>

<template>
    <header class="header">
        <nav class="nav">
            <a href="/" class="logo">Магазин</a>
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
</style>
