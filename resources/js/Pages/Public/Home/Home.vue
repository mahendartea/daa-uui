<template>
    <Layout>

        <Head title="Selamat Datang di Sistem Informasi Akademik" />

        <div id="carouselExample" class="relative w-full border-t-4 border-red-600" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden md:h-[800px]">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/images/gallery/08a-WEB_REG_.png"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                        alt="Campus Building">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/images/gallery/Lab-robotik.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        alt="Library Interior">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/images/gallery/Perpustakaan-1.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        alt="Study Area">
                </div>
                <!-- Item 4 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/images/gallery/Plenary-Hall-UUI.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        alt="Graduation Day">
                </div>
                <!-- Item 5 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/images/gallery/Gedung-UKM.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-bottom"
                        alt="Campus Life">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                <button type="button" class="w-3 h-3 rounded-full bg-white dark:bg-gray-800" aria-current="true"
                    aria-label="Slide 1" data-carousel-slide-to="0" id="carousel-indicator-1"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"
                    id="carousel-indicator-2"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"
                    id="carousel-indicator-3"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"
                    id="carousel-indicator-4"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
                    aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"
                    id="carousel-indicator-5"></button>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
                <div
                    class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
                    <a href="https://www.youtube.com/watch?v=_amV5yNaZW4"
                        class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 mb-2">
                        <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 14">
                            <path
                                d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z" />
                        </svg>
                        Tutorial
                    </a>
                    <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2">Penerimaan
                        Mahasiswa Baru 2024</h1>
                    <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">Selamat datang! Kami dengan
                        bangga
                        mengumumkan bahwa penerimaan mahasiswa baru Universitas Ubudiyah Indonesia telah dibuka. Kami
                        berharap Anda dapat bergabung dengan komunitas akademik yang cerdas dan kreatif untuk mencapai
                        prestasi yang lebih tinggi.</p>
                    <a href="https://sipenmaru.uui.ac.id"
                        class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        Sipenmaru
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <div
                        class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                        <a href="#"
                            class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                            <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 18">
                                <path
                                    d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z" />
                            </svg>
                            Design
                        </a>
                        <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Start with Flowbite
                            Design System</h2>
                        <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-4">Static websites are now
                            used to bootstrap lots of websites and are becoming the basis for a variety of tools that
                            even influence both web designers and developers.</p>
                        <a href="#"
                            class="text-blue-600 dark:text-blue-500 hover:underline font-medium text-lg inline-flex items-center">Read
                            more
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                        <a href="#"
                            class="bg-purple-100 text-purple-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 mb-2">
                            <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 4 1 8l4 4m10-8 4 4-4 4M11 1 9 15" />
                            </svg>
                            Code
                        </a>
                        <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Best react libraries
                            around the web</h2>
                        <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-4">Static websites are now
                            used to bootstrap lots of websites and are becoming the basis for a variety of tools that
                            even influence both web designers and developers.</p>
                        <a href="#"
                            class="text-blue-600 dark:text-blue-500 hover:underline font-medium text-lg inline-flex items-center">Read
                            more
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
                <div
                    class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 md:grid-cols-2 bg-white dark:bg-gray-800">
                    <figure
                        class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Very easy this was to
                                integrate
                            </h3>
                            <p class="my-4">If you care for your time, I hands down would go with this."</p>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <img class="rounded-full w-9 h-9"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/karen-nelson.png"
                                alt="profile picture">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                <div>Bonnie Green</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 ">Developer at Open AI</div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure
                        class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 md:rounded-se-lg dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Solid foundation for any
                                project
                            </h3>
                            <p class="my-4">Designing with Figma components that can be easily translated to the
                                utility
                                classes of Tailwind CSS is a huge timesaver!"</p>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <img class="rounded-full w-9 h-9"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/roberta-casas.png"
                                alt="profile picture">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                <div>Roberta Casas</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Lead designer at Dropbox</div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure
                        class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 md:rounded-es-lg md:border-b-0 md:border-e dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mindblowing workflow</h3>
                            <p class="my-4">Aesthetically, the well designed components are beautiful and will
                                undoubtedly
                                level up your next application."</p>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <img class="rounded-full w-9 h-9"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png"
                                alt="profile picture">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                <div>Jese Leos</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Software Engineer at Facebook
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure
                        class="flex flex-col items-center justify-center p-8 text-center bg-white border-gray-200 rounded-b-lg md:rounded-se-lg dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Efficient Collaborating
                            </h3>
                            <p class="my-4">You have many examples that can be used to create a fast prototype for
                                your
                                team."</p>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <img class="rounded-full w-9 h-9"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/joseph-mcfall.png"
                                alt="profile picture">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                <div>Joseph McFall</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">CTO at Google</div>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            </div>
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
        onMounted
    } from 'vue';
    import {
        initFlowbite
    } from 'flowbite';


    onMounted(() => {
        initFlowbite();
    });

    defineProps({
        canLogin: {
            type: Boolean
        },
        canRegister: {
            type: Boolean
        },
        laravelVersion: {
            type: String,
            required: true
        },
        phpVersion: {
            type: String,
            required: true
        },
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
