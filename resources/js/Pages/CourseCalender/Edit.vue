<template>
    <Head>
        <title>Edit Jadwal Kuliah</title>
        <meta name="description" content="Edit Jadwal Kuliah" />
    </Head>

    <LoggedInLayout title="Edit Jadwal Kuliah">
        <Toast position="top-right" group="br" class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Edit Jadwal Kuliah</h1>
                </div>
            </div>
            <Card class="border">
                <template #title>Edit Jadwal Kuliah</template>
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
                                <div class="flex flex-col space-y-2">
                                    <div v-if="form.file && typeof form.file === 'string'" class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-600">Berkas saat ini:</span>
                                        <a :href="'/storage/' + form.file" target="_blank"
                                           class="text-blue-600 hover:text-blue-800 underline">
                                            Lihat Berkas
                                        </a>
                                        <Button type="button" icon="pi pi-times"
                                            class="p-button-danger p-button-text p-button-sm"
                                            @click="removeFile" />
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Button type="button" icon="pi pi-upload"
                                            :label="form.file && typeof form.file === 'string' ? 'Ganti Berkas' : 'Pilih Berkas'"
                                            @click="$refs.fileInput.click()" />
                                        <span v-if="form.file && typeof form.file === 'object'" class="text-sm text-gray-600">
                                            {{ form.file.name }}
                                        </span>
                                    </div>
                                </div>
                                <input type="file" ref="fileInput" @input="handleFileUpload"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" />
                                <small class="text-red-500" v-if="errors.file">{{ errors.file }}</small>
                                <small class="text-gray-500">Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX (Maks. 2MB)</small>
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
import { useToast } from 'primevue/usetoast';

const props = defineProps({
    courseCalender: Object,
    errors: Object
});

const toasts = useToast();

const form = useForm({
    id_thn: props.courseCalender.id_thn,
    semester: props.courseCalender.semester,
    nama: props.courseCalender.nama,
    file: props.courseCalender.file
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
    { label: 'Edit' }
]);

const removeFile = () => {
    form.file = null;
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Ukuran file tidak boleh lebih dari 2MB',
                life: 3000
            });
            event.target.value = ''; // Clear the file input
            return;
        }

        // Check file type
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if (!allowedTypes.includes(file.type)) {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX',
                life: 3000
            });
            event.target.value = ''; // Clear the file input
            return;
        }

        form.file = file;
    }
};

const submit = () => {
    form.post(`/admin/course-calendar/${props.courseCalender.id_jkul}?_method=PUT`, {
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Jadwal kuliah berhasil diperbarui',
                life: 3000
            });
            router.visit('/admin/course-calendar');
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat memperbarui jadwal',
                life: 3000
            });
        }
    });
};

const goBack = () => {
    router.visit('/admin/course-calendar');
};
</script>
