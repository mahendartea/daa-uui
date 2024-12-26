<template>
    <div class="bg-[#1c1b39] shadow-sm sticky top-0 z-40 dark:bg-red-900 dark:bg-opacity-50 dark:backdrop-blur-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-end space-x-5 text-xs mx-auto p-2">
            <a href="https://uui.ac.id" class="text-gray-100 font-mono" target="_blank"> Website UUI </a>
            <a href="https://elearning.uui.ac.id" class="text-gray-100 font-mono" target="_blank"> Elearning </a>
            <Link :href="route('login')" class="text-gray-100 font-mono">Admnistrator</Link>
        </div>
    </div>
    <nav class="bg-white bg-opacity-90 backdrop-blur-xl shadow-sm sticky top-0 z-40 dark:bg-gray-800 dark:bg-opacity-90 dark:backdrop-blur-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img class="h-10"
                     src="/images/logouui.png"/>
                <span class="self-center text-md text-gray-800 font-semibold whitespace-nowrap dark:text-white">Direktorat Administrasi Akademik</span>
            </a>
            <div class="hidden lg:flex lg:gap-x-8">
                <template v-for="menu in mainmenu" :key="menu.id_main">
                    <!-- Menu without submenu -->
                    <Link v-if="!menu.submenu || menu.submenu.length === 0"
                        :href="menu.link"
                        :class="{'text-red-600 dark:text-red-400': route().current(menu.link)}"
                        class="text-sm font-semibold leading-6 text-gray-900 hover:text-red-600 dark:text-white dark:hover:text-red-400 transition duration-150 ease-in-out">
                        {{ menu.nama_menu }}
                    </Link>
                    <!-- Menu with submenu -->
                    <div v-else class="relative group">
                        <button
                            class="flex items-center text-sm font-semibold leading-6 text-gray-900 hover:text-red-600 dark:text-white dark:hover:text-red-400 transition duration-150 ease-in-out">
                            {{ menu.nama_menu }}
                            <svg class="w-2.5 h-2.5 ms-2.5 transition-transform duration-200 group-hover:rotate-180"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="absolute left-0 z-10 mt-2 w-48 origin-top-left rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                            <template v-for="submenu in menu.submenu" :key="submenu.id_sub">
                                <!-- External link -->
                                <a v-if="isExternalLink(submenu.link_sub)"
                                    :href="submenu.link_sub"
                                    target="_blank"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-red-600 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                    {{ submenu.nama_sub }}
                                    <i class="pi pi-external-link ml-1 text-xs"></i>
                                </a>
                                <!-- Internal link -->
                                <Link v-else
                                    :href="submenu.link_sub"
                                    :class="{'bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400': route().current(submenu.link_sub)}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-red-600 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                    {{ submenu.nama_sub }}
                                </Link>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button type="button" @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 hover:text-red-600 hover:bg-gray-100 dark:text-gray-200 dark:hover:text-red-400 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <span class="sr-only">{{ isMobileMenuOpen ? 'Close menu' : 'Open menu' }}</span>
                    <svg v-if="!isMobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="isMobileMenuOpen"
            class="lg:hidden fixed inset-0 z-50 bg-gray-900/50 dark:bg-gray-900/80"
            @click.self="isMobileMenuOpen = false">
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white dark:bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
                :class="{ 'translate-x-0': isMobileMenuOpen, 'translate-x-full': !isMobileMenuOpen }">
                <div class="flex items-center justify-between mb-6">
                    <a href="/" class="flex items-center space-x-3">
                        <img class="h-8" src="/images/logouui.png" alt="UUI Logo" />
                        <span class="self-center text-sm font-semibold dark:text-white">DAA UUI</span>
                    </a>
                    <button type="button" @click="isMobileMenuOpen = false"
                        class="rounded-md p-2.5 text-gray-700 hover:text-red-600 hover:bg-gray-100 dark:text-gray-200 dark:hover:text-red-400 dark:hover:bg-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="space-y-2">
                        <template v-for="menu in mainmenu" :key="menu.id_main">
                            <!-- Mobile menu without submenu -->
                            <Link v-if="!menu.submenu || menu.submenu.length === 0"
                                :href="menu.link"
                                :class="{'text-red-600 dark:text-red-400': route().current(menu.link)}"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50 hover:text-red-600 dark:text-white dark:hover:bg-gray-700 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                {{ menu.nama_menu }}
                            </Link>
                            <!-- Mobile menu with submenu -->
                            <div v-else class="space-y-1">
                                <button @click="toggleMobileSubmenu(menu.id_main)"
                                    class="flex w-full items-center justify-between rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50 hover:text-red-600 dark:text-white dark:hover:bg-gray-700 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                    {{ menu.nama_menu }}
                                    <svg class="w-2.5 h-2.5 ms-2.5 transition-transform duration-200"
                                        :class="{ 'rotate-180': activeMobileSubmenu === menu.id_main }"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <!-- Mobile submenu -->
                                <div v-show="activeMobileSubmenu === menu.id_main"
                                    class="space-y-1 pl-4">
                                    <template v-for="submenu in menu.submenu" :key="submenu.id_sub">
                                        <!-- External link -->
                                        <a v-if="isExternalLink(submenu.link_sub)"
                                            :href="submenu.link_sub"
                                            target="_blank"
                                            class="block rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                            {{ submenu.nama_sub }}
                                            <i class="pi pi-external-link ml-1"></i>
                                        </a>
                                        <!-- Internal link -->
                                        <Link v-else
                                            :href="submenu.link_sub"
                                            :class="{'text-red-600 dark:text-red-400': route().current(submenu.link_sub)}"
                                            class="block rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                            {{ submenu.nama_sub }}
                                        </Link>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    mainmenu: {
        type: Array,
        required: true
    }
})

const isMobileMenuOpen = ref(false)
const activeMobileSubmenu = ref(null)

const isExternalLink = (url) => {
    if (!url) return false
    return url.startsWith('http://') || url.startsWith('https://') || url.startsWith('//')
}

const toggleMobileSubmenu = (menuId) => {
    activeMobileSubmenu.value = activeMobileSubmenu.value === menuId ? null : menuId
}

const handleEscape = (e) => {
    if (e.key === 'Escape') {
        isMobileMenuOpen.value = false
        activeMobileSubmenu.value = null
    }
}

const handleRouteChange = () => {
    isMobileMenuOpen.value = false
    activeMobileSubmenu.value = null
}

onMounted(() => {
    document.addEventListener('keydown', handleEscape)
    window.addEventListener('popstate', handleRouteChange)
})

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleEscape)
    window.removeEventListener('popstate', handleRouteChange)
})

const mainmenu = usePage().props.mainmenu
</script>

<style scoped>
/* Prevent body scroll when mobile menu is open */
:deep(body.mobile-menu-open) {
    overflow: hidden;
}
</style>
