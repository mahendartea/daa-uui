<template>
  <Head :title="post.title" />
  <Layout>
    <div class="max-w-screen-xl mx-auto px-4 py-8">
      <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
        <!-- Title Section -->
        <div class="flex items-center mb-4">
          <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h9M5 9h5m8-8H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4l3.5 4 3.5-4h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
          </svg>
          <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ post.title }}</h1>
        </div>

        <!-- Date Section -->
        <div class="flex items-center mb-4 text-gray-600 dark:text-gray-400">
          <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
          </svg>
          <span>{{ formatDate(post.tgl) }}</span>
        </div>

        <!-- Category Badge if available -->
        <div v-if="post.kategori" class="flex items-center mb-4">
          <span class="text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
            {{ post.kategori }}
          </span>
        </div>

        <!-- Content Section -->
        <div class="mt-6 prose max-w-none text-gray-700 bg-transparent dark:text-gray-300" v-html="post.content"></div>

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
import Layout from '@/Layouts/Layout.vue';

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
})

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return date.toLocaleDateString('id-ID', options);
};
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
