<template>
    <Layout>

        <Head title="Selamat Datang di Sistem Informasi Akademik" />

        <div id="carouselExample" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden md:h-[650px]">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img alt="Campus Building"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                        src="/images/gallery/08a-WEB_REG_.png">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img alt="Library Interior"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        src="/images/gallery/Lab-robotik.jpg">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img alt="Study Area"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        src="/images/gallery/Perpustakaan-1.jpg">
                </div>
                <!-- Item 4 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img alt="Graduation Day"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        src="/images/gallery/Plenary-Hall-UUI.jpg">
                </div>
                <!-- Item 5 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img alt="Campus Life"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        src="/images/gallery/Gedung-UKM.jpg">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                <button id="carousel-indicator-1" aria-current="true" aria-label="Slide 1"
                    class="w-3 h-3 rounded-full bg-white dark:bg-gray-800" data-carousel-slide-to="0"
                    type="button"></button>
                <button id="carousel-indicator-2" aria-current="false" aria-label="Slide 2"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    data-carousel-slide-to="1" type="button"></button>
                <button id="carousel-indicator-3" aria-current="false" aria-label="Slide 3"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    data-carousel-slide-to="2" type="button"></button>
                <button id="carousel-indicator-4" aria-current="false" aria-label="Slide 4"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    data-carousel-slide-to="3" type="button"></button>
                <button id="carousel-indicator-5" aria-current="false" aria-label="Slide 5"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    data-carousel-slide-to="4" type="button"></button>
            </div>
            <!-- Slider controls -->
            <button
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev type="button">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none"
                        viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1 1 5l4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next type="button">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none"
                        viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        <section class="bg-white dark:bg-gray-900 px-2">
            <div class="py-5 mx-auto max-w-screen-xl lg:py-16 flex flex-col gap-5 md:flex-row md:items-start md:gap-10">
                <main class="relative md:w-1/2">
                    <div class="p-8 border rounded-lg dark:border-gray-700">
                        <p class="leading-loose text-gray-500 dark:text-gray-400 text-justify">
                            Assalamu'alaikum Wr.Wb.Puji syukur kami panjatkan kepada Allah SWT atas rahmat dan
                            hidayah-Nya
                            portal media informasi Direktorat Administrasi akademik UUI sudah dapat kita gunakan.
                            Direktorat
                            DAA mempunyai visi Menjadi Pusat Layanan Administrasi Akademik Berbasis Teknologi Informasi
                            Demi
                            Menunjang Pembangunan Dan Pengembangan Universitas Ubudiyah Indonesia Menjadi Cyber
                            University.
                            Kami memiliki Motto Pelayanan Prima, Ramah, Cepat dan Tepat. kami siap memberikan kinerja
                            terbaik
                            dalam melayani mahasiswa dengan dedikasi yang tinggi.
                        </p>

                        <div class="flex items-center mt-5 -mx-2">
                            <img class="object-cover mx-2 rounded-full w-14 shrink-0 h-14 ring-4 ring-gray-300 dark:ring-gray-700"
                                src="/images/dirdaa.png" alt="">

                            <div class="mx-2">
                                <h1 class="font-semibold text-gray-800 dark:text-white">Eva Rosdiana, S.ST., M.K.M</h1>
                                <span class="text-sm text-gray-500">Direktur Administrasi Akademik</span>
                            </div>
                        </div>
                    </div>
                </main>
                <div
                    class="md:w-1/2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                    <a class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 mb-2"
                        href="https://www.youtube.com/watch?v=_amV5yNaZW4">
                        <svg aria-hidden="true" class="w-2.5 h-2.5 me-1.5" fill="currentColor" viewBox="0 0 20 14"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z" />
                        </svg>
                        Video
                    </a>
                    <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2">Penerimaan
                        Mahasiswa Baru 2024</h1>
                    <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">Selamat datang! Kami dengan
                        bangga
                        mengumumkan bahwa penerimaan mahasiswa baru Universitas Ubudiyah Indonesia telah dibuka. Kami
                        berharap Anda dapat bergabung dengan komunitas akademik yang cerdas dan kreatif untuk mencapai
                        prestasi yang lebih tinggi.</p>
                    <a class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                        href="https://sipenmaru.uui.ac.id">
                        Sipenmaru
                        <svg aria-hidden="true" class="w-3.5 h-3.5 ms-2 rtl:rotate-180" fill="none"
                            viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </a>
                </div>

            </div>
        </section>

        <section class="bg-white dark:bg-gray-900 mb-10 mx-2">
            <div
                class="py-5 px-4 mx-auto max-w-screen-xl lg:py-5 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="grid md:grid-cols-2 gap-10 p-5">
                    <!-- Berita Section -->
                    <div>
                        <h2 class="text-3xl font-bold mb-5 text-gray-900 dark:text-white">Berita Terbaru</h2>
                        <div class="space-y-5" v-if="!loaderPost">
                            <div v-for="post in beritaPosts" :key="post.id"
                                class="p-4 bg-white border-b border-gray-200  dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-col justify-between">
                                    <Link :href="route('post.show', post.judul_seo)"
                                        class="text-lg font-semibold text-gray-900 dark:text-white hover:text-red-600 dark:hover:text-red-400">
                                    {{ post . title }}
                                    </Link>
                                    <span
                                        class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(post . tgl) }}</span>
                                    <div class="mt-2 text-gray-600 dark:text-gray-300"
                                        v-html="getFirstNWords(post.content, 10)"></div>
                                </div>
                            </div>
                            <Link :href="route('posts.showAllPublic')"
                                class="inline-block text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                            Lihat Semua Berita
                            </Link>
                        </div>
                        <div v-else class="flex items-center justify-center">
                            <div role="status" class="max-w-sm animate-pulse">
                                <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[330px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[300px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pengumuman Section -->
                    <div>
                        <h2 class="text-3xl font-bold mb-5 text-gray-900 dark:text-white">Pengumuman</h2>
                        <div class="space-y-2" v-if="!loaderPost">
                            <div v-for="post in pengumumanPosts" :key="post.id"
                                class="p-4 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-col justify-between">
                                    <Link :href="route('post.show', post.judul_seo)"
                                        class="text-lg font-semibold text-gray-900 dark:text-white hover:text-red-600 dark:hover:text-red-400">
                                    {{ post . title }}
                                    </Link>
                                    <span
                                        class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(post . tgl) }}</span>
                                    <div class="mt-2 text-gray-600 dark:text-gray-300"
                                        v-html="getFirstNWords(post.content, 10)"></div>
                                </div>
                            </div>
                            <Link :href="route('posts.showAllPublic')"
                                class="inline-block text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                            Lihat Semua Pengumuman
                            </Link>
                        </div>
                        <div v-else class="flex items-center justify-center">
                            <div role="status" class="max-w-sm animate-pulse">
                                <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[330px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[300px] mb-2.5"></div>
                                <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Agenda Section -->

                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-gray-900 mb-10">
            <div
                class="py-5 px-4 mx-auto max-w-screen-xl lg:py-5 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 gap-10 p-5">
                    <!-- <RssFeed /> -->
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Agenda</h2>
                    <div v-if="!loaderAgenda">
                        <div class="grid grid-cols-2 gap-5">
                            <div v-for="agenda in latestAgenda" :key="agenda.id"
                                class="p-4 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex flex-col space-y-2">
                                    <Link :href="route('agenda.show', agenda.id)"
                                        class="text-lg font-semibold text-gray-900 dark:text-white hover:text-red-600 dark:hover:text-red-400">
                                    {{ agenda . nama_agenda }}
                                    </Link>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ formatDate(agenda . jdwl_agenda) }}
                                    </div>
                                    <div v-if="agenda.tempat"
                                        class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                        </svg>
                                        {{ agenda . tempat }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="latestAgenda.length === 0"
                            class="p-4 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-center text-gray-500">
                            Tidak ada agenda terbaru
                        </div>
                        <Link :href="route('agenda.showAllPublic')"
                            class="inline-block text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 mt-5">
                        Lihat Semua Agenda
                        </Link>
                    </div>
                    <div v-else class="flex items-center justify-center">
                        <div role="status" class="max-w-sm animate-pulse">
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[330px] mb-2.5"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[300px] mb-2.5"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900 mx-2">
            <!--  -->
            <p></p>
        </section>
    </Layout>
</template>

<script setup>
    import Layout from '@/Layouts/Layout.vue';
    import {
        Head,
        Link
    } from '@inertiajs/vue3';
    import {
        onMounted,
        ref
    } from 'vue';
    import axios from 'axios';
    import {
        initFlowbite
    } from 'flowbite';
    import RssFeed from '@/Components/RssFeed.vue';

    const beritaPosts = ref([]);
    const pengumumanPosts = ref([]);
    const latestAgenda = ref(null);
    const loaderPost = ref(true);
    const loaderAgenda = ref(true);

    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    const getFirstNWords = (text, n) => {
        if (!text) return '';
        const words = text.trim().split(/\s+/);
        const truncated = words.slice(0, n).join(' ');
        return words.length > n ? `${truncated}...` : truncated;
    };

    onMounted(async () => {
        initFlowbite();
        try {
            const [postsResponse, agendaResponse] = await Promise.all([
                axios.get(route('posts.public')),
                axios.get(route('agenda.latest'))
            ]);

            // Split posts based on category
            beritaPosts.value = postsResponse.data.filter(post => post.category === 'Berita');
            pengumumanPosts.value = postsResponse.data.filter(post => post.category === 'Pengumuman');
            loaderPost.value = false;

            // Set latest agenda
            latestAgenda.value = agendaResponse.data;
            loaderAgenda.value = false;
        } catch (error) {
            console.error('Error fetching data:', error);
        }

    });

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    });
</script>

<style scoped>
    /* Add smooth transition styles */
    [data-carousel-item] {
        transition: transform 0.5s ease-in-out;
    }

    .duration-700 {
        transition-duration: 700ms;
    }

    /* Ensure images cover the carousel area properly */
    [data-carousel-item] img {
        height: 100%;
        object-fit: cover;
    }
</style>
