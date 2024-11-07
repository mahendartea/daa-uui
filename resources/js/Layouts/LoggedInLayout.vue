<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimeMenuBar from '../Components/PrimeMenuBar.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="px-10">

        <Head :title="title" />
        <div class="card mt-5 sticky top-0 z-10 bg-white dark:bg-black">
            <PrimeMenuBar @logout="logout" />
        </div>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
