<template>
    <Head>
        <title>Headline</title>
        <meta name="description" content="Headline" />
    </Head>

    <LoggedInLayout title="Headline">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Headline</h1>
                </div>
                <div v-if="!headline">
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Headline" type="button"
                        @click="createHeadline" />
                </div>
            </div>

            <Card v-if="headline" class="border">
                <template #content>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="font-bold">Isi Headline</label>
                            <div v-html="headline.isi_headline"></div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-bold">Gambar</label>
                            <img :src="'/uploads/headline/' + headline.gambar_headline"
                                :alt="headline.isi_headline"
                                class="max-w-md rounded cursor-pointer"
                                @click="showImage(headline.gambar_headline)" />
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-2">Tanggal Dibuat:</h3>
                            <div>{{ formatDate(headline.created_at) }}</div>
                        </div>

                        <div class="flex justify-end">
                            <Button class="p-button-primary"
                                icon="pi pi-pencil" label="Edit Headline"
                                @click="editHeadline(headline.id_headline)" />
                        </div>
                    </div>

                    <!-- Image Preview Dialog -->
                    <Dialog v-model:visible="imagePreviewVisible" :style="{ width: '90vw', maxWidth: '960px' }"
                        header="Preview Gambar" modal>
                        <div class="flex justify-center">
                            <img :src="selectedImageUrl" class="max-w-full max-h-[70vh] object-contain" />
                        </div>
                    </Dialog>
                </template>
            </Card>

            <Card v-else class="border">
                <template #content>
                    <div class="text-center py-8">
                        <i class="pi pi-info-circle text-4xl text-gray-400 mb-4"></i>
                        <p class="text-xl text-gray-600">Belum ada headline</p>
                        <p class="text-gray-500 mt-2">Klik tombol "Tambah Headline" untuk membuat headline baru</p>
                    </div>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Card } from 'primevue';
import { onMounted, ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    headline: Object,
    message: Object
});

const toast = useToast();
const imagePreviewVisible = ref(false);
const selectedImageUrl = ref('');

// Show toast message when available
onMounted(() => {
    if (props.message) {
        toast.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000
        });
    }
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Headline' }
]);

const formatDate = (dateString) => {
    if (!dateString) return '';

    const date = new Date(dateString.replace(' ', 'T'));
    // Check if date is valid
    if (isNaN(date.getTime())) return '';

    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(date);
};

const showImage = (imageName) => {
    selectedImageUrl.value = `/uploads/headline/${imageName}`;
    imagePreviewVisible.value = true;
};

const createHeadline = () => {
    router.get(route('headline.create'));
};

const editHeadline = (id) => {
    router.get(route('headline.edit', id));
};
</script>
