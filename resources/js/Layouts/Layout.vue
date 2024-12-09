<template>
    <div>
        <Head>
            <link rel="icon" type="image/png" href="/images/logouuinontext.png" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
            <meta name="description" content="UUI - Universitas Ubudiyah Indonesia" />
            <meta name="author" content="UUI - Universitas Ubudiyah Indonesia (by: Mahendar Dwi Payana)" />
            <meta name="keywords" content="UUI, Universitas Ubudiyah Indonesia, Universitas, Ubudiyah, Indonesia" />
            <meta name="robots" content="index, follow" />
            <meta name="googlebot" content="index, follow" />
            <meta name="googlebot-news" content="index, follow" />
        </Head>

        <Navbar />

        <main>
            <slot />
        </main>

        <footer class="bg-white dark:bg-gray-900 mt-10">
            <div class="mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">UUI</a>. All Rights Reserved.
                </span>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>

        </footer>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Pages/Public/Components/Navbar.vue';
</script>
