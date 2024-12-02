<template>
    <Menubar :model="menuItems">
        <template #start>
            <img alt="logo" src="https://dpmpa.uui.ac.id/wp-content/uploads/2024/07/LOGO-UUI-01-2.png"
                class="w-20 rounded-lg" />
        </template>
        <template #item="{ item, props, hasSubmenu, root }">
            <a v-ripple class="flex items-center" v-bind="props.action">
                <span>{{ item.label }}</span>
                <span v-if="item.shortcut"
                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{
                        item.shortcut }}</span>
                <i v-if="hasSubmenu"
                    :class="['pi pi-angle-down ml-auto', { 'pi-angle-down': root, 'pi-angle-right': !root }]"></i>
            </a>
        </template>
        <template #end>
            <div class="flex items-center gap-2">
                <Avatar :image="$page.props.auth.user.profile_photo_url" shape="circle" @click="toggleMenu"
                    class="cursor-pointer" :style="{ width: '40px', height: '40px' }" />
                <Menu ref="menu" id="overlay_menu" :model="listItems" :popup="true" />
            </div>
        </template>
    </Menubar>
</template>

<script setup>
import { ref } from 'vue';
import { defineEmits } from 'vue';
import { router } from '@inertiajs/vue3'; // Import router from Inertia
import { Menubar, Avatar, Menu } from 'primevue';

const emit = defineEmits(['logout']); // Define an event for logout

const showMenu = ref(false);
const menu = ref(null);

// Define menu items directly in the component
const menuItems = [
    {
        label: 'Dashboard',
        icon: 'pi pi-home',
        route: 'dashboard',
        route2: 'dashboard',
        command: () => {
            router.get(route('dashboard')); // Navigate to the dashboard route using router
        }
    },
    {
        label: 'Post',
        icon: 'pi pi-pencil',
        route: 'posts.index',
        route2: 'posts.create',
        items: [
            {
                label: 'Postingan',
                icon: 'pi pi-pencil',
                command: () => {
                    router.get(route('posts.index')); // Navigate to the posts route using router
                }
            },
            {
                label: 'Kategori',
                icon: 'pi pi-pencil',
                command: () => {
                    router.get(route('categories.index')); // Navigate to the categories route using router
                }
            }
        ],
    },
    {
        label: 'Galeri',
        icon: 'pi pi-image',
        route: 'galeries.index',
        route2: 'albums.index',
        items: [
            {
                label: 'Album',
                icon: 'pi pi-folder',
                command: () => {
                    router.get(route('albums.index'));
                }
            },
            {
                label: 'Gambar',
                icon: 'pi pi-images',
                command: () => {
                    router.get(route('galeries.index'));
                }
            },
        ]
    },
    {
        label: 'Agenda',
        icon: 'pi pi-calendar',
        route: 'agenda.index',
        command: () => {
            router.get('/admin/agenda'); // Navigate to the agenda route
        }
    },
    {
        label: 'Dokumen',
        icon: 'pi pi-file',
        route: 'dokumen',
        route2: 'dokumen.create',
        command: () => {
            router.get(route('documents.index')); // Navigate to the dokumen route
        }
    },
    {
        label: 'Akademik',
        icon: 'pi pi-users',
        route: 'akademik.index',
        items: [
            {
                label: 'Kalender Akademik',
                icon: 'pi pi-search',
                command: () => {
                    router.get(route('kalender.index'));
                }
            },
            {
                label: 'Jadwal',
                icon: 'pi pi-search',
                items: [
                    {
                        label: 'Jadwal UTS',
                        icon: 'pi pi-search',
                        command: () => {
                            router.get(route('uts.index'));
                        }
                    },
                    {
                        label: 'Jadwal UAS',
                        icon: 'pi pi-search',
                        command: () => {
                            router.get(route('uas.index'));
                        }
                    },
                ]
            },
            {
                label: 'SAP',
                icon: 'pi pi-search',
                command: () => {
                    router.get(route('sap.index'));
                }
            },
        ],
    },
    {
        label: 'Pengaturan',
        icon: 'pi pi-search',
        route: 'setting',
        route2: 'setting',
        items: [
            {
                label: 'Otorisasi',
                icon: 'pi pi-lock',
                items: [
                    {
                        label: 'Pengguna',
                        icon: 'pi pi-user',
                        command: () => {
                            router.get(route('users.index')); // Navigate to the config route
                        }
                    },
                    {
                        label: 'Peran',
                        icon: 'pi pi-lock',
                        command: () => {
                            router.get(route('roles.index')); // Navigate to the config route
                        }
                    },
                    {
                        label: 'Izin',
                        icon: 'pi pi-lock',
                        command: () => {
                            router.get(route('permissions.index')); // Navigate to the config route
                        }
                    },
                ],
            },
        ]
    }
];

const listItems = [
    {
        label: 'Options',
        items: [
            {
                label: 'Dark Mode',
                icon: 'pi pi-moon',
                command: () => {
                    document.documentElement.classList.toggle('dark');
                }
            },
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
            },
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
