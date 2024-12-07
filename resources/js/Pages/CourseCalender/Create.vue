<template>
    <Head>
        <title>Tambah Jadwal Kuliah</title>
        <meta name="description" content="Tambah Jadwal Kuliah" />
    </Head>

    <LoggedInLayout title="Tambah Jadwal Kuliah">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Tambah Jadwal Kuliah</h1>
                </div>
            </div>
            <Card class="border">
                <template #title>Tambah Jadwal Kuliah Baru</template>
                <template #content>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="id_thn" class="block text-sm font-medium text-gray-700">Tahun</label>
                                <InputNumber v-model="form.id_thn" inputId="id_thn" :useGrouping="false"
                                    class="w-full" :class="{ 'p-invalid': errors.id_thn }" />
                                <small class="text-red-500" v-if="errors.id_thn">{{ errors.id_thn }}</small>
                            </div>

                            <div class="space-y-2">
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                                <Dropdown v-model="form.semester" :options="semesterOptions" optionLabel="label"
                                    optionValue="value" placeholder="Pilih Semester" class="w-full"
                                    :class="{ 'p-invalid': errors.semester }" />
                                <small class="text-red-500" v-if="errors.semester">{{ errors.semester }}</small>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <InputText v-model="form.nama" type="text" class="w-full"
                                    :class="{ 'p-invalid': errors.nama }" />
                                <small class="text-red-500" v-if="errors.nama">{{ errors.nama }}</small>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label for="file" class="block text-sm font-medium text-gray-700">Berkas</label>
                                <div class="flex items-center space-x-2">
                                    <Button type="button" icon="pi pi-upload" label="Pilih Berkas"
                                        @click="$refs.fileInput.click()" />
                                    <span v-if="form.file" class="text-sm text-gray-600">
                                        {{ form.file.name }}
                                    </span>
                                </div>
                                <input type="file" ref="fileInput" @input="handleFileUpload" class="hidden" />
                                <small class="text-red-500" v-if="errors.file">{{ errors.file }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 pt-4">
                            <Button type="button" label="Batal" class="p-button-secondary" @click="goBack" />
                            <Button type="submit" label="Simpan" :loading="form.processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Card, Toast } from 'primevue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    errors: Object
});

const form = useForm({
    id_thn: new Date().getFullYear(),
    semester: '',
    nama: '',
    file: null
});

const semesterOptions = [
    { label: 'Ganjil', value: 'Ganjil' },
    { label: 'Genap', value: 'Genap' }
];

const home = ref({
    icon: 'pi pi-home',
    to: '/'
});

const items = ref([
    { label: 'Jadwal Kuliah', to: '/admin/course-calendar' },
    { label: 'Tambah' }
]);

const handleFileUpload = (event) => {
    form.file = event.target.files[0];
};

const submit = () => {
    form.post('/admin/course-calendar', {
        onSuccess: () => {
            router.visit('/admin/course-calendar');
        }
    });
};

const goBack = () => {
    router.visit('/admin/course-calendar');
};
</script>
