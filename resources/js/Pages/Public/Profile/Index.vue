<template>
    <Head title="Profil DAA" />
    <Layout>
        <div class="max-w-screen-xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Profil Direktorat Administrasi Akademik</h1>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Visi Card -->
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Visi</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        Menjadi Direktorat yang unggul dalam pelayanan administrasi akademik yang efisien,
                        transparan, dan berorientasi pada kepuasan stakeholder berbasis teknologi informasi.
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6.072 10.072 2 2 6-4m3.586 4.314.9-.9a2 2 0 0 0 0-2.828l-.9-.9a2 2 0 0 1-.586-1.414V5.072a2 2 0 0 0-2-2H13.8a2 2 0 0 1-1.414-.586l-.9-.9a2 2 0 0 0-2.828 0l-.9.9a2 2 0 0 1-1.414.586H5.072a2 2 0 0 0-2 2v1.272a2 2 0 0 1-.586 1.414l-.9.9a2 2 0 0 0 0 2.828l.9.9a2 2 0 0 1 .586 1.414v1.272a2 2 0 0 0 2 2h1.272a2 2 0 0 1 1.414.586l.9.9a2 2 0 0 0 2.828 0l.9-.9a2 2 0 0 1 1.414-.586h1.272a2 2 0 0 0 2-2V13.8a2 2 0 0 1 .586-1.414Z"/>
                        </svg>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Misi</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400 space-y-2">
                        <li>Menyelenggarakan pelayanan administrasi akademik yang efisien dan efektif</li>
                        <li>Mengembangkan sistem informasi akademik yang terintegrasi</li>
                        <li>Meningkatkan kualitas sumber daya manusia dalam pelayanan administrasi akademik</li>
                        <li>Membangun kerjasama dengan stakeholder dalam peningkatan mutu akademik</li>
                    </ul>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Tugas Pokok Card -->
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m6 0v3H6V2m6 0a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M5 5h8m-8 5h8m-8 4h8"/>
                        </svg>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tugas Pokok</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        Melaksanakan pengelolaan administrasi akademik di lingkungan Universitas Ubudiyah Indonesia.
                    </p>
                </div>

                <!-- Fungsi Card -->
                <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.333 6.764a3 3 0 1 1 3.141-5.023M2.5 16H1v-2a4 4 0 0 1 4-4m7.379-8.121a3 3 0 1 1 2.976 5M15 10a4 4 0 0 1 4 4v2h-1.761M13 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-4 6h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                        </svg>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Fungsi</h5>
                    </div>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-400 space-y-2">
                        <li>Perencanaan dan pengembangan program akademik</li>
                        <li>Pengelolaan administrasi perkuliahan dan ujian</li>
                        <li>Pengelolaan data dan informasi akademik</li>
                        <li>Pelayanan registrasi dan herregistrasi mahasiswa</li>
                        <li>Pengelolaan administrasi wisuda dan alumni</li>
                    </ul>
                </div>
            </div>

            <!-- Struktur Organisasi Section -->
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 1h10M6 5h10M6 9h10M1.49 1h.01m-.01 4h.01m-.01 4h.01"/>
                    </svg>
                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Struktur Organisasi</h5>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <img src="https://uui.ac.id/wp-content/uploads/2020/01/ldo-STRUKTUR-UUI.jpg" alt="Struktur Organisasi DAA" class="max-w-full h-auto mx-auto">
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
</script>
