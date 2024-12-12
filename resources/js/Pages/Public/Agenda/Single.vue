<template>
  <Head :title="agenda.nama_agenda" />
  <Layout>
    <div class="max-w-screen-xl mx-auto px-4 py-8">
      <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
        <!-- Title Section -->
        <div class="flex items-center mb-4">
          <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5.757v8.486M5.757 10h8.486M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
          <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ agenda.nama_agenda }}</h1>
        </div>

        <!-- Info Section -->
        <div class="flex flex-col space-y-4 mb-6">
          <!-- Date -->
          <div class="flex items-center text-gray-600 dark:text-gray-400">
            <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
            </svg>
            <span>{{ formatDate(agenda.jdwl_agenda) }}</span>
          </div>

          <!-- Location -->
          <div v-if="agenda.tempat" class="flex items-center text-gray-600 dark:text-gray-400">
            <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3.464V1c0-.553.448-1 1-1s1 .447 1 1v2.464a3.026 3.026 0 0 1-.872-.516 3.025 3.025 0 0 1-.872.516ZM6 4.464a3.026 3.026 0 0 1-.872-.516A3.025 3.025 0 0 1 4.256 4.5 2 2 0 0 0 3 6.37V7h10V6.37a2 2 0 0 0-1.256-1.87 3.026 3.026 0 0 1-.872-.516 3.025 3.025 0 0 1-.872.516V4h-3ZM2 8v5.837a2 2 0 0 0 1.256 1.87l4 1.939a2 2 0 0 0 1.488 0l4-1.939A2 2 0 0 0 14 13.837V8H2Z"/>
            </svg>
            <span>{{ agenda.tempat }}</span>
          </div>

          <!-- Time Range -->
          <div v-if="agenda.jadwal_awal && agenda.jadwal_akhir" class="flex items-center text-gray-600 dark:text-gray-400">
            <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0-8V5m0 6 2.5 2.5"/>
            </svg>
            <span>{{ formatDate(agenda.jadwal_awal) }} - {{ formatDate(agenda.jadwal_akhir) }}</span>
          </div>
        </div>

        <!-- Status Badge -->
        <div class="flex items-center mb-4">
          <span :class="getStatusClass(agenda.jadwal_awal, agenda.jadwal_akhir)" class="text-sm bg-slate-200 font-medium me-2 px-2.5 py-0.5 rounded">
           {{ getStatusText(agenda.jadwal_awal, agenda.jadwal_akhir) }}
          </span>
        </div>

        <!-- Content Section -->
        <div class="mt-6 prose max-w-none text-gray-700 bg-transparent dark:text-gray-300" v-html="agenda.isi_agenda"></div>

        <!-- Footer Section -->
        <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
          <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
            <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 11 14H9a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 10 19Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            <span>Direktorat Administrasi Akademik</span>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layouts/Layout.vue'

const props = defineProps({
  agenda: {
    type: Object,
    required: true
  }
})

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return date.toLocaleDateString('id-ID', options);
}

const getStatusClass = (startDate, endDate) => {
  const now = new Date();
  const start = new Date(startDate);
  const end = new Date(endDate);

  if (now < start) {
    return 'text-yellow-800 dark:text-yellow-300';
  } else if (now >= start && now <= end) {
    return 'text-green-800 dark:text-green-300';
  } else {
    return 'text-gray-800 dark:text-gray-300';
  }
}

const getStatusText = (startDate, endDate) => {
  const now = new Date();
  const start = new Date(startDate);
  const end = new Date(endDate);

  if (now < start) {
    return 'Akan Datang';
  } else if (now >= start && now <= end) {
    return 'Sedang Berlangsung';
  } else {
    return 'Selesai';
  }
}
</script>

<style>
/* Ensure proper styling for rendered HTML content */
.prose {
  max-width: none;
}
.prose img {
  margin: 1.5rem auto;
  border-radius: 0.5rem;
}
.prose h1, .prose h2, .prose h3, .prose h4 {
  color: #1f2937;
  margin-top: 2rem;
  margin-bottom: 1rem;
}
.prose p {
  margin-bottom: 1rem;
}
.prose ul, .prose ol {
  margin-left: 1.5rem;
  margin-bottom: 1rem;
}
@media (prefers-color-scheme: dark) {
  .prose h1, .prose h2, .prose h3, .prose h4 {
    color: #f3f4f6;
  }
}
</style>
