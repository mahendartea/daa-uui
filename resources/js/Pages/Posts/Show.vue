<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';
import Card from "primevue/card";
import { Button } from "primevue";
import { router } from "@inertiajs/vue3";

defineProps({
    post: Object
});
const home = ref({
    icon: 'pi pi-home'
});
const items = ref([
    { label: 'Postingan' },
    { label: 'Detail' },
]);

const formatDate = (dateString) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', options);
};
</script>

<template>
    <LoggedInLayout title="Detail Postingan">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <Card class="border bg-gray-50">
            <template #title>
                <h2 class="text-2xl font-bold text-primary p-3">{{ post.title }}
                    <sup v-if="post.draft == true" class="text-white bg-red-400 px-1 rounded">Draf</sup>
                </h2>
            </template>
            <template #content>
                <div class="mt-3 mb-5 bg-primary text-white font-bold text-lg flex justify-between px-3">
                    <span>{{ post.category }}</span>
                </div>
                <div class="mb-10">
                    <p class="font-bold inline-block">Tag :</p>
                    <span v-for="tag in post.tag.split(',')" :key="tag.trim()"
                        class="tag-item mx-0.5 bg-gray-200 px-1 rounded">{{
                            tag.trim()
                        }}</span>
                </div>
                <div class="m-0 px-2 py-2 " v-html="post.content"></div>
            </template>

            <template #footer>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-5">Perbaharui pada : {{ formatDate(post.updated)
                    }}</p>
                <div class="flex justify-between mt-5">
                    <p>Created by : {{ post.created }}</p>

                    <div class="flex justify-end gap-2">
                        <Button icon="pi pi-arrow-left" label="Kembali" severity="secondary" type="button"
                            @click="router.get('/admin/posts/')" />

                        <Button icon="pi pi-pencil" label="Edit" type="button"
                            @click="router.get(`/admin/posts/edit/${post.id}`)" />
                    </div>
                </div>
            </template>
        </Card>
    </LoggedInLayout>
</template>
