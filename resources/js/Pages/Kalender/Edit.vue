<template>
    <LoggedInLayout title="Edit Kalender Akademik">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-7xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Kalender Akademik</h2>

            <form @submit.prevent="onSubmit" class="my-5">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="thnajr" class="text-gray-700 dark:text-gray-200">Tahun Ajaran*</label>
                        <InputText id="thnajr" v-model="form.thnajr" placeholder="Masukkan tahun ajaran"
                            :class="{ 'p-invalid': form.errors.thnajr }" />
                        <small class="text-red-500" v-if="form.errors.thnajr">{{ form.errors.thnajr }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="nama" class="text-gray-700 dark:text-gray-200">Nama*</label>
                        <InputText id="nama" v-model="form.nama" placeholder="Masukkan nama kalender"
                            :class="{ 'p-invalid': form.errors.nama }" />
                        <small class="text-red-500" v-if="form.errors.nama">{{ form.errors.nama }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="upload_id" class="text-gray-700 dark:text-gray-200">Dokumen*</label>
                        <Dropdown id="upload_id" v-model="form.upload_id" :options="documents" optionLabel="label"
                            optionValue="value" :filter="true" :class="{ 'p-invalid': form.errors.upload_id }"
                            placeholder="Pilih dokumen" />
                        <small class="text-red-500" v-if="form.errors.upload_id">{{ form.errors.upload_id }}</small>
                    </div>

                    <!-- Current Document Info -->
                    <div v-if="kalender.document" class="mt-4">
                        <Card>
                            <template #title>
                                <div class="flex items-center gap-2">
                                    <i class="pi pi-file text-xl"></i>
                                    <span>Dokumen Saat Ini</span>
                                </div>
                            </template>
                            <template #content>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Nama File:</p>
                                        <p class="font-medium">{{ kalender.document.nama_file }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-300">Tanggal Upload:</p>
                                        <p class="font-medium">{{ formatDate(kalender.document.tgl_upload) }}</p>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Batal" class="p-button-secondary"
                        @click="router.get(route('kalender.index'))" />
                    <Button type="submit" label="Simpan" class="p-button-primary" :loading="form.processing" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Breadcrumb from 'primevue/breadcrumb';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Card from 'primevue/card';

const props = defineProps({
    kalender: {
        type: Object,
        required: true
    },
    documents: {
        type: Array,
        required: true
    }
});

const toast = useToast();
const items = ref([
    { label: 'Akademik' },
    { label: 'Kalender', to: route('kalender.index') },
    { label: 'Edit' }
]);

const home = ref({ icon: 'pi pi-home', to: '/' });

const form = useForm({
    thnajr: props.kalender.thnajr,
    nama: props.kalender.nama,
    upload_id: props.kalender.upload_id,
    _method: 'PUT'
});

const formatDate = (date) => {
    return new Date(date).toLocaleString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const onSubmit = () => {
    if (!form.thnajr || !form.nama || !form.upload_id) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Silakan lengkapi semua field yang wajib diisi',
            life: 3000
        });
        return;
    }

    form.post(route('kalender.update', props.kalender.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Kalender berhasil diperbarui',
                life: 3000
            });
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Gagal memperbarui kalender',
                life: 3000
            });
        }
    });
};
</script>
