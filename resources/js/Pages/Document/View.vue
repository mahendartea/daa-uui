<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Breadcrumb from 'primevue/breadcrumb';
import Card from 'primevue/card';

const props = defineProps({
    document: {
        type: Object,
        required: true
    }
});

const items = ref([
    { label: 'Dokumen', to: { name: 'documents.index' } },
    { label: 'Detail' },
]);

const home = ref({ icon: 'pi pi-home' });

const formatDate = (date) => {
    return new Date(date).toLocaleString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const isPDF = computed(() => {
    return props.document.path.toLowerCase().endsWith('.pdf');
});

const fileUrl = computed(() => route('documents.view', props.document.id));

const downloadUrl = computed(() => route('documents.download', props.document.id));

const handleDownload = () => {
    window.location.href = downloadUrl.value;
};
</script>

<template>
    <LoggedInLayout title="Detail Dokumen">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Detail Dokumen</h2>
                <Button icon="pi pi-arrow-left" label="Kembali" class="p-button-secondary"
                    @click="router.get(route('documents.index'))" />
            </div>

            <Card>
                <template #content>
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Nama File</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ document.nama_file }}</p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Tanggal Upload</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ formatDate(document.tgl_upload) }}</p>
                        </div>

                        <div class="col-span-full">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Aksi</h3>
                            <div class="flex gap-2">
                                <Button icon="pi pi-download" label="Download" @click="handleDownload"
                                    class="p-button-primary" />
                                <Button icon="pi pi-pencil" label="Edit"
                                    @click="router.get(route('documents.edit', document.id))"
                                    class="p-button-secondary" />
                            </div>
                        </div>
                    </div>

                    <!-- PDF Viewer -->
                    <div v-if="isPDF" class="col-span-full mt-6">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Preview Dokumen</h3>
                        <div class="w-full h-[800px] border border-gray-200 rounded-lg overflow-hidden">
                            <object :data="fileUrl" type="application/pdf" class="w-full h-full">
                                <p>Tidak dapat menampilkan PDF. <a :href="fileUrl" target="_blank">Klik disini untuk
                                        membuka</a></p>
                            </object>
                        </div>
                    </div>
                </template>
            </Card>
        </section>
    </LoggedInLayout>
</template>
