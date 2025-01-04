<template>
    <Layout>
        <Head title="Dokumen" />

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Dokumen</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Daftar dokumen yang tersedia untuk diunduh.
                        </p>
                    </div>

                    <!-- Table -->
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama File</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Upload</th>
                                    <th scope="col" class="px-6 py-3">Dibuat Oleh</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(document, index) in documents.data" :key="document.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ (documents.current_page - 1) * documents.per_page + index + 1 }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ document.nama_file }}
                                    </td>
                                    <td class="px-6 py-4">{{ formatDate(document.tgl_upload) }}</td>
                                    <td class="px-6 py-4">{{ document.created }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <!-- Download Button -->
                                            <a :href="document.path" :download="document.nama_file" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                            </a>
                                            <!-- External Link -->
                                            <a v-if="document.link_external" :href="document.link_external" target="_blank" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        <Pagination :links="documents.links" />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    documents: Object,
    filters: Object
});

const formatDate = (date) => {
    return new Date(date).toLocaleString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>
