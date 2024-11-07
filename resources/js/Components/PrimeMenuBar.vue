<template>
    <Menubar :model="menuItems"
        class="bg-white bg-opacity-20 backdrop-blur-lg border border-gray-300 dark:bg-gray-800 dark:bg-opacity-30 dark:border-gray-600">
        <template #start>
            <img alt="logo" src="https://dpmpa.uui.ac.id/wp-content/uploads/2024/07/LOGO-UUI-01-2.png"
                class="w-20 rounded-lg" />
        </template>
        <template #item="{ item, props, hasSubmenu, root }">
            <a v-ripple class="flex items-center" v-bind="props.action">
                <span class="text-gray-800 dark:text-gray-200">{{ item.label }}</span>
                <span v-if="item.shortcut"
                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{
                        item.shortcut }}</span>
                <i v-if="hasSubmenu"
                    :class="['pi pi-angle-down ml-auto', { 'pi-angle-down': root, 'pi-angle-right': !root }]"></i>
            </a>
        </template>
        <template #end>
            <div class="flex items-center gap-2">
                <InputText placeholder="Search" type="text" class="w-32 sm:w-auto" />
                <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle"
                    @click="toggleMenu" class="cursor-pointer" :style="{ width: '40px', height: '40px' }" />
                <Menu ref="menu" id="overlay_menu" :model="listItems" :popup="true" />
            </div>
        </template>
    </Menubar>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import { router } from '@inertiajs/vue3'; // Import router from Inertia
import { Menubar, Avatar, InputText, Menu } from 'primevue';

const emit = defineEmits(['logout']); // Define an event for logout

const showMenu = ref(false);
const menu = ref(null);

// Define menu items directly in the component
const menuItems = [
    {
        label: 'Dashboard',
        icon: 'pi pi-home',
        command: () => {
            router.get(route('dashboard')); // Navigate to the dashboard route using router
        }
    },
    {
        label: 'Post',
        icon: 'pi pi-pencil',
        command: () => {
            router.get('/post'); // Navigate to the post route
        }
    },
    {
        label: 'Galeri',
        icon: 'pi pi-image',
        command: () => {
            router.get('/galeri'); // Navigate to the galeri route
        }
    },
    {
        label: 'Agenda',
        icon: 'pi pi-calendar',
        command: () => {
            router.get('/agenda'); // Navigate to the agenda route
        }
    },
    {
        label: 'Dokumen',
        icon: 'pi pi-file',
        command: () => {
            router.get('/dokumen'); // Navigate to the dokumen route
        }
    },
    {
        label: 'Pengaturan',
        icon: 'pi pi-search',
        items: [
            {
                label: 'Pengguna',
                icon: 'pi pi-user',
                command: () => {
                    router.get('/users'); // Navigate to the config route
                }
            },
            {
                label: 'Peran',
                icon: 'pi pi-lock',
                command: () => {
                    router.get('/role'); // Navigate to the config route
                }
            },
            {
                label: 'Izin',
                icon: 'pi pi-lock',
                command: () => {
                    router.get('/permision'); // Navigate to the config route
                }
            },
        ]
    }
];

const listItems = [
    {
        label: 'Options',
        items: [
            {
                label: 'Profile',
                icon: 'pi pi-user',
                command: () => {
                    router.get('/user/profile'); // Navigate to the profile page
                }
            },
            {
                label: 'Log Out',
                icon: 'pi pi-sign-out',
                command: () => {
                    emit('logout'); // Emit logout event
                }
            }
        ]
    }
];

const toggleMenu = (event) => {
    showMenu.value = !showMenu.value; // Toggle the menu visibility
    if (menu.value) {
        menu.value.toggle(event); // Ensure the menu is toggled
    }
};
</script>

<style scoped>
/* Add any specific styles for the Menubar here */
</style>
