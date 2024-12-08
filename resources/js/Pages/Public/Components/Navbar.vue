<template>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700 shadow-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a class="flex items-center space-x-3 rtl:space-x-reverse flex-col " href="/">
                <img alt="Flowbite Logo" class="h-10 "
                     src="images/logouui.png"/>
                <span class="self-center text-md text-gray-800 font-semibold whitespace-nowrap dark:text-white">Direktorat Administrasi Akademik</span>
            </a>
            <button aria-controls="navbar-multi-level" aria-expanded="false"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    @click="toggleMobileMenu"
                    type="button">
                <span class="sr-only">Open main menu</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="none" viewBox="0 0 17 14"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1h15M1 7h15M1 13h15" stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"/>
                </svg>
            </button>
            <div :class="{ 'hidden': !isMobileMenuOpen }" class="w-full md:block md:w-auto z-40" id="navbar-multi-level">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a aria-current="page"
                           class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500"
                           href="/">Home</a>
                    </li>
                    <li>
                        <a class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500"
                           href="/pages/profile">Profil</a>
                    </li>
                    <li>
                        <a class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500"
                           href="#">Mobility Student</a>
                    </li>
                    <li class="relative">
                        <button @click="toggleAkademikDropdown"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                            Akademik
                            <svg aria-hidden="true" class="w-2.5 h-2.5 ms-2.5" fill="none"
                                 viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <path d="m1 1 4 4 4-4" stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                        </button>
                        <div v-show="isAkademikOpen"
                             class="z-10 absolute left-0 md:left-auto font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                             @click.away="isAkademikOpen = false">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#">Kurikulum</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#">Pedoman</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#">Surat Penting</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#">SOP</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                       href="#">Evaluasi</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500"
                           href="#">Download</a>
                    </li>
                    <li>
                        <a class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500"
                           href="#">Hubungi Kami</a>
                    </li>
                    <li>
                        <Link :href="route('login')"
                              class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Login
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

// State for mobile menu and dropdown
const isMobileMenuOpen = ref(false)
const isAkademikOpen = ref(false)

// Toggle functions
const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const toggleAkademikDropdown = () => {
    isAkademikOpen.value = !isAkademikOpen.value
}

// Close dropdown when clicking outside
const closeDropdown = (event) => {
    if (!event.target.closest('.dropdown')) {
        isAkademikOpen.value = false
    }
}
</script>

<style scoped>
/* Add transition for dropdown */
[v-show] {
    transition: all 0.3s ease-in-out;
}

/* Adjust dropdown position for mobile and desktop */
@media (min-width: 768px) {
    .relative .z-10 {
        margin-top: 0.5rem;
    }
}
</style>
