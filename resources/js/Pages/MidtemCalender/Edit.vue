<template>
    <LoggedInLayout title="Edit Jadwal Midterm">
        <Toast position="bottom-right" group="br" class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Edit Jadwal Midterm</h1>
                </div>
            </div>
            <Card class="border">
                <template #title>Form Edit Jadwal Midterm</template>
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
                                         class="w-full"
                                         :class="{ 'p-invalid': errors.nama }" />
                                <small class="text-red-500" v-if="errors.nama">{{ errors.nama }}</small>
                            </div>

                            <div class="flex flex-col md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-1">File</label>
                                <div v-if="midterm.file" class="mb-2">
                                    <span class="text-sm">File saat ini: </span>
                                    <a :href="'/uploads/midterm/' + midterm.file"
                                       class="text-blue-500 hover:text-blue-700"
                                       target="_blank">
                                        {{ midterm.file }}
                                    </a>
                                </div>
                                <FileUpload mode="basic"
                                          :auto="true"
                                          accept="application/pdf"
                                          :maxFileSize="2000000"
                                          @select="onFileSelect"
                                          @error="onFileError"
                                          :customUpload="true"
                                          chooseLabel="Pilih File Baru"
                                          invalidFileSizeMessage="Ukuran file terlalu besar (maksimal 2MB)"
                                          invalidFileTypeMessage="Tipe file tidak valid (hanya PDF)"
                                          class="w-full" />
                                <small class="text-red-500" v-if="errors.file">{{ errors.file }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <Button type="button"
                                    label="Batal"
                                    class="p-button-secondary"
                                    @click="router.visit(route('midtem-calender.index'))" />
                            <Button type="submit"
                                    label="Simpan"
                                    :loading="form.processing"
                                    class="p-button-primary" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Breadcrumb from 'primevue/breadcrumb';

const toast = useToast();

const props = defineProps({
    midterm: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Jadwal Midterm', to: route('midtem-calender.index') },
    { label: 'Edit' }
]);

const form = useForm({
    id_thn: props.midterm.id_thn,
    semester: props.midterm.semester,
    nama: props.midterm.nama,
    file: null,
    _method: 'PUT'
});

const semesterOptions = [
    { label: 'Ganjil', value: 'Ganjil' },
    { label: 'Genap', value: 'Genap' }
];

const onFileSelect = (event) => {
    if (event.files && event.files[0]) {
        const file = event.files[0];

        // Validate file type
        if (file.type !== 'application/pdf') {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Hanya file PDF yang diperbolehkan',
                life: 3000
            });
            return;
        }

        // Validate file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2000000) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Ukuran file maksimal 2MB',
                life: 3000
            });
            return;
        }

        // Store the file in the form
        form.file = file;
    }
};

const onFileError = (error) => {
    if (error.type === 'max-file-size') {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Ukuran file maksimal 2MB',
            life: 3000
        });
    } else if (error.type === 'file-type') {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Hanya file PDF yang diperbolehkan',
            life: 3000
        });
    }
};

const submit = () => {
    // If there's a file, use FormData to submit
    if (form.file) {
        const formData = new FormData();
        formData.append('id_thn', form.id_thn);
        formData.append('semester', form.semester);
        formData.append('nama', form.nama);
        formData.append('file', form.file);
        formData.append('_method', 'PUT');

        router.post(route('midtem-calender.update', props.midterm.id_jmid), formData, {
            onSuccess: () => {
                toast.add({
                    severity: 'success',
                    summary: 'Sukses',
                    detail: 'Jadwal midterm berhasil diperbarui',
                    life: 3000
                });
            },
            onError: (errors) => {
                Object.keys(errors).forEach(key => {
                    toast.add({
                        severity: 'error',
                        summary: 'Error',
                        detail: errors[key],
                        life: 3000
                    });
                });
            }
        });
    } else {
        // If no file, just update other fields
        form.put(route('midtem-calender.update', props.midterm.id_jmid), {
            onSuccess: () => {
                toast.add({
                    severity: 'success',
                    summary: 'Sukses',
                    detail: 'Jadwal midterm berhasil diperbarui',
                    life: 3000
                });
            }
        });
    }
};
</script>
