<template>
    <div>
        <Head>
            <link rel="icon" type="image/png" href="/images/logouui.png" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
            <meta name="description" content="UUI - Universitas Ubudiyah Indonesia" />
            <meta name="author" content="UUI - Universitas Ubudiyah Indonesia (by: Mahendar Dwi Payana)" />
            <meta name="keywords" content="UUI, Universitas Ubudiyah Indonesia, Universitas, Ubudiyah, Indonesia" />
            <meta name="robots" content="index, follow" />
            <meta name="googlebot" content="index, follow" />
            <meta name="googlebot-news" content="index, follow" />
        </Head>

        <Navbar />

        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Pages/Public/Components/Navbar.vue';
</script>
