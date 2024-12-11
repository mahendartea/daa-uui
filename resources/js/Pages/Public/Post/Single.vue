<template>
  <Head :title="post.title" />
  <Layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
          <h1 class="text-3xl font-bold mb-4">{{ post.title }}</h1>
          <div class="text-gray-600 mb-4">
            <span>{{ formatDate(post.tgl) }}</span>
          </div>
          <div class="prose max-w-none" v-html="post.content"></div>
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
