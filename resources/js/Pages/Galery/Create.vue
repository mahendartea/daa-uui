<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';

const home = ref({
    icon: 'pi pi-home'
});
const items = ref([
    { label: 'Galery' },
    { label: 'Tambah' },
]);


</script>

<template>
    <LoggedInLayout title="Tambah Galery">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>


        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Galery</h2>



        </section>

    </LoggedInLayout>

</template>