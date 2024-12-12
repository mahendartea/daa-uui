<!-- RssFeed.vue -->
<template>
    <div class="max-w-screen-xl mx-auto mb-10">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Berita Terbaru dari UUI</h2>
            <a href="https://uui.ac.id/blog" target="_blank"
                class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 flex items-center">
                Lihat Semua Berita
                <svg class="w-4 h-4 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="item in news" :key="item.guid"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-all duration-300">
                <!-- Title -->
                <h3
                    class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white hover:text-red-600 dark:hover:text-red-400">
                    <a :href="item.link" target="_blank" class="hover:underline">{{ item.title }}</a>
                </h3>

                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-3">
                    <span v-for="category in item.categories" :key="category"
                        class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                        {{ category }}
                    </span>
                </div>

                <!-- Date and Author -->
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3 space-x-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" />
                        </svg>
                        {{ formatDate(item.pubDate) }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 11 14H9a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 10 19Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{ item.creator }} UUI
                    </div>
                </div>

                <!-- Description -->
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3" v-html="item.description"></p>

                <!-- Read More Link -->
                <a :href="item.link" target="_blank"
                    class="inline-flex items-center mt-4 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                    Baca Selengkapnya
                    <svg class="w-4 h-4 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const news = ref([]);

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('id-ID', options);
};

onMounted(async () => {
    try {
        const response = await fetch('https://uui.ac.id/feed');
        const xmlText = await response.text();
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
        const items = xmlDoc.querySelectorAll('item');

        news.value = Array.from(items).slice(0, 3).map(item => ({
            title: item.querySelector('title')?.textContent || '',
            link: item.querySelector('link')?.textContent || '',
            pubDate: item.querySelector('pubDate')?.textContent || '',
            creator: item.querySelector('dc\\:creator')?.textContent || '',
            categories: Array.from(item.querySelectorAll('category')).map(cat => cat.textContent),
            description: item.querySelector('description')?.textContent || '',
            guid: item.querySelector('guid')?.textContent || ''
        }));
    } catch (error) {
        console.error('Error fetching RSS feed:', error);
    }
});
</script>
