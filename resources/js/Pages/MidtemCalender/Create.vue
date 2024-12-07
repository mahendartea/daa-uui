<template>
    <LoggedInLayout title="Tambah Jadwal Midterm">
        <Toast position="bottom-right" group="br" class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Tambah Jadwal Midterm</h1>
                </div>
            </div>

            <Card class="border">
                <template #title>Form Jadwal Midterm</template>
                <template #content>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="id_thn" class="text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <InputNumber v-model="form.id_thn"
                                           inputId="id_thn"
                                           :useGrouping="false"
                                           class="w-full"
                                           :class="{ 'p-invalid': errors.id_thn }" />
                                <small class="text-red-500" v-if="errors.id_thn">{{ errors.id_thn }}</small>
                            </div>

                            <div class="flex flex-col">
                                <label for="semester" class="text-sm font-medium text-gray-700 mb-1">Semester</label>
                                <Dropdown v-model="form.semester"
                                        :options="semesterOptions"
                                        optionLabel="label"
                                        optionValue="value"
                                        placeholder="Pilih Semester"
                                        class="w-full"
                                        :class="{ 'p-invalid': errors.semester }" />
                                <small class="text-red-500" v-if="errors.semester">{{ errors.semester }}</small>
                            </div>

                            <div class="flex flex-col md:col-span-2">
                                <label for="nama" class="text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <InputText v-model="form.nama"
                                         type="text"
                                         class="w-full"
                                         :class="{ 'p-invalid': errors.nama }" />
                                <small class="text-red-500" v-if="errors.nama">{{ errors.nama }}</small>
                            </div>

                            <div class="flex flex-col md:col-span-2">
                                <label for="file" class="text-sm font-medium text-gray-700 mb-1">File</label>
                                <div class="flex items-center gap-4">
                                    <FileUpload
                                        mode="basic"
                                        :customUpload="true"
                                        @uploader="onFileSelect"
                                        :auto="true"
                                        chooseLabel="Pilih File"
                                        :maxFileSize="2000000"
                                        class="w-full" />
                                </div>
                                <small class="text-gray-500">Max size: 2MB</small>
                                <small class="text-red-500" v-if="errors.file">{{ errors.file }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <Button type="button"
                                   label="Kembali"
                                   class="p-button-secondary p-button-outlined"
                                   @click="router.get(route('midtem-calender.index'))" />
                            <Button type="submit"
                                   label="Simpan"
                                   icon="pi pi-save"
                                   :loading="processing" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const processing = ref(false);

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Akademik' },
    { label: 'Jadwal Midterm' },
    { label: 'Tambah' },
]);

const semesterOptions = [
    { label: 'Ganjil', value: 'Ganjil' },
    { label: 'Genap', value: 'Genap' }
];

defineProps({
    errors: {
        type: Object,
        default: () => ({})
    }
});

const currentYear = new Date().getFullYear();
const form = useForm({
    id_thn: currentYear,
    semester: null,
    nama: '',
    file: null
});

const onFileSelect = (event) => {
    const file = event.files[0];
    if (file) {
        if (file.size > 2000000) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Ukuran file tidak boleh lebih dari 2MB',
                life: 3000,
            });
            return;
        }
        form.file = file;
    }
};

const submit = () => {
    processing.value = true;
    form.post(route('midtem-calender.store'), {
        preserveScroll: true,
        onSuccess: () => {
            processing.value = false;
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Jadwal midterm berhasil ditambahkan',
                life: 3000,
            });
            router.get(route('midtem-calender.index'));
        },
        onError: () => {
            processing.value = false;
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menyimpan data',
                life: 3000,
            });
        }
    });
};
</script>
