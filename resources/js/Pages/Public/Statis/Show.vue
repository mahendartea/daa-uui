<template>
    <Layout>
        <Head :title="props.page.title" />
        <div>
            <h1>{{ props.page.title }}</h1>
            <div v-html="page.content"></div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head } from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

const props =defineProps({
    page: Object
});

onMounted(() => {
        initFlowbite();
    });
</script>
