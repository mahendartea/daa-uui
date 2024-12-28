<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <div class="flex flex-col items-center">
            <img class="h-16" src="/images/logouui.png" alt="UUI Logo"/>
            <span class="mt-2 text-sm font-semibold text-gray-800">Direktorat Administrasi Akademik</span>
        </div>
    </Link>
</template>
