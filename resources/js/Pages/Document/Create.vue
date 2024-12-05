<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Breadcrumb from 'primevue/breadcrumb';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import InputText from 'primevue/inputtext';
import FileUpload from 'primevue/fileupload';
import Card from 'primevue/card';

const toast = useToast();
const items = ref([
    { label: 'Dokumen', to: { name: 'documents.index' } },
    { label: 'Tambah' },
]);

const home = ref({ icon: 'pi pi-home' });
const fileUploadRef = ref();
const selectedFile = ref(null);

const form = useForm({
    nama_file: '',
    file: null,
    link_external: '',
});

const allowedTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const onFileSelect = (event) => {
    const file = event.files[0];

    if (!allowedTypes.includes(file.type)) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Hanya file dokumen (PDF, DOC, DOCX) yang diperbolehkan',
            life: 3000
        });
        fileUploadRef.value.clear();
        selectedFile.value = null;
        return;
    }

    // Set the file in the form
    form.file = file;
    selectedFile.value = {
        name: file.name,
        size: formatFileSize(file.size),
        type: file.type.split('/').pop().toUpperCase(),
        lastModified: new Date(file.lastModified).toLocaleString()
    };
};

const onSubmit = () => {
    if (!form.nama_file) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Silakan masukkan nama file',
            life: 3000
        });
        return;
    }

    if (!form.file && !form.link_external) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Silakan pilih file atau masukkan link external',
            life: 3000
        });
        return;
    }

    // Create FormData object
    const formData = new FormData();
    formData.append('nama_file', form.nama_file);
    if (form.file) {
        formData.append('file', form.file);
    }
    if (form.link_external) {
        formData.append('link_external', form.link_external);
    }

    router.post(route('documents.store'), formData, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            fileUploadRef.value.clear();
            selectedFile.value = null;
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Dokumen berhasil ditambahkan',
                life: 3000
            });
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: Object.values(errors)[0],
                life: 3000
            });
        }
    });
};
</script>

<template>
    <LoggedInLayout title="Tambah Dokumen">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-7xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Upload Dokumen</h2>

            <form @submit.prevent="onSubmit" class="my-5">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="nama_file" class="text-gray-700 dark:text-gray-200">Nama File*</label>
                        <InputText id="nama_file" v-model="form.nama_file" placeholder="Masukkan nama file"
                            :class="{ 'p-invalid': form.errors.nama_file }" />
                        <small class="text-red-500" v-if="form.errors.nama_file">{{ form.errors.nama_file }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="link_external" class="text-gray-700 dark:text-gray-200">Link External</label>
                        <InputText id="link_external" v-model="form.link_external"
                            placeholder="https://example.com/document"
                            :class="{ 'p-invalid': form.errors.link_external }" />
                        <small class="text-red-500" v-if="form.errors.link_external">{{ form.errors.link_external
                            }}</small>
                        <small class="text-gray-500">Masukkan URL lengkap jika dokumen berasal dari sumber
                            external</small>
                    </div>

                    <div class="flex flex-col gap-2" v-if="!form.link_external">
                        <label class="text-gray-700 dark:text-gray-200">File</label>
                        <FileUpload ref="fileUploadRef" mode="basic" :auto="true" accept=".pdf,.doc,.docx"
                            :maxFileSize="10000000" @select="onFileSelect" :class="{ 'p-invalid': form.errors.file }"
                            chooseLabel="Pilih File" />
                        <small class="text-red-500" v-if="form.errors.file">{{ form.errors.file }}</small>
                        <small class="text-gray-500">Tipe file yang diperbolehkan: PDF, DOC, DOCX</small>
                    </div>

                    <!-- Selected File Preview -->
                    <div v-if="selectedFile && !form.link_external" class="mt-4">
                        <Card>
                            <template #title>
                                <div class="flex items-center gap-2">
                                    <i class="pi pi-file text-xl"></i>
                                    <span>File Terpilih</span>
                                </div>
                            </template>
                            <template #content>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Nama File Asli:</p>
                                        <p class="font-medium">{{ selectedFile.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Ukuran:</p>
                                        <p class="font-medium">{{ selectedFile.size }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Tipe:</p>
                                        <p class="font-medium">{{ selectedFile.type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Terakhir Diubah:</p>
                                        <p class="font-medium">{{ selectedFile.lastModified }}</p>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Batal" class="p-button-secondary"
                        @click="router.get(route('documents.index'))" />
                    <Button type="submit" label="Simpan" class="p-button-primary" :loading="form.processing" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>
