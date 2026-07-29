<script setup lang="ts"></script>

<template>
    <footer class="footer">
        <div class="footer-inner">
            <p class="copy">&copy; {{ new Date().getFullYear() }} Магазин. Все права защищены.</p>
            <nav class="footer-nav">
                <a href="/">Главная</a>
                <a href="/catalog">Каталог</a>
                <a href="/contacts">Контакты</a>
            </nav>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    background: #111827;
    color: #9ca3af;
    padding: 24px 0;
    margin-top: auto;
}

.footer-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.copy {
    margin: 0;
    font-size: 0.875rem;
}

.footer-nav {
    display: flex;
    gap: 20px;
}

.footer-nav a {
    color: #9ca3af;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.15s;
}

.footer-nav a:hover {
    color: #f9fafb;
}
</style>
