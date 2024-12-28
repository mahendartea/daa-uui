<script setup>
    import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
</script>

<template>
    <LoggedInLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <section class="bg-white dark:bg-gray-900 shadow-md max-w-7xl mx-auto my-5">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Selamat Datang di Direktorat Administrasi dan Akademik
                </h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">
                    Direktorat Administrasi dan Akademik berkomitmen untuk memberikan pelayanan terbaik dalam pengelolaan
                    administrasi akademik dan mendukung kegiatan pembelajaran di Universitas Ubudiyah Indonesia.
                </p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">

                    <a href="#"
                        class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

    </LoggedInLayout>
</template>
