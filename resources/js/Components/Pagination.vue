<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    components: { Link },
    props: {
        links: Array,
        from: Number,
        to: Number,
        total: Number,
        currentPage: Number,
        lastPage: Number,
        prevPageUrl: String,
        nextPageUrl: String,
    },
});
</script>

<template>
    <div class="space-x-3 lg:px-10 py-5 px-2 text-center">
        <div class="sm:flex sm:justify-between w-full">
            <div class="sm:flex sm:flex-col">
                <span class="text-sm text-gray-700 dark:text-gray-400 text-left">
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">{{ from }} </span>
                    <span> Sampai {{ to }}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ total }}</span>
                    Data
                </span>
                <span class="text-sm text-slate-700">
                    Halaman : {{ currentPage }} dari
                    {{ lastPage }} halaman
                </span>
            </div>

            <div class="inline-flex mt-2 xs:mt-0">
                <!-- Page Buttons -->
                <!-- <div class="flex items-center space-x-1">
                    <Link v-for="page in links" :key="page.label"
                        :class="{ 'bg-gray-800 text-white': page.active, 'text-gray-800': !page.active, 'opacity-75 pointer-events-none': !page.url }"
                        :href="page.url" as="button"
                        class="flex items-center justify-center px-3 h-8 text-sm font-medium rounded hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    {{ page.label }}
                    </Link>
                </div> -->

                <!-- Previous Button -->
                <Link :class="prevPageUrl ? '' : 'opacity-75 pointer-events-none disabled'" :href="prevPageUrl"
                    as="button"
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    preserve-scroll>
                <svg aria-hidden="true" class="w-3.5 h-3.5 mr-2" fill="none" viewBox="0 0 14 10"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 5H1m0 0 4 4M1 5l4-4" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" />
                </svg>
                Sebelumnya
                </Link>


                <!-- Next Button -->
                <Link :class="nextPageUrl ? '' : 'opacity-75 pointer-events-none disabled'" :href="nextPageUrl"
                    as="button"
                    class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    preserve-scroll>
                Berikutnya
                <svg aria-hidden="true" class="w-3.5 h-3.5 ml-2" fill="none" viewBox="0 0 14 10"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" />
                </svg>
                </Link>
            </div>
        </div>
    </div>
</template>