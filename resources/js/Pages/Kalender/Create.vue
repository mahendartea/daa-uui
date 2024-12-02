<template>
    <Head>
        <title>Tambah Kalender Akademik</title>
        <meta name="description" content="Tambah Kalender Akademik" />
    </Head>

    <LoggedInLayout title="Tambah Kalender Akademik">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Tambah Kalender Akademik</h1>
                </div>
            </div>
            <Card class="border">
                <template #title>Form Tambah Kalender</template>
                <template #content>
                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="thnajr">Tahun Ajaran</label>
                            <InputText
                                id="thnajr"
                                v-model="form.thnajr"
                                :class="{ 'p-invalid': form.errors.thnajr }"
                                placeholder="Contoh: 2023/2024"
                            />
                            <small class="text-red-500" v-if="form.errors.thnajr">{{ form.errors.thnajr }}</small>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="nama">Nama Kalender</label>
                            <InputText
                                id="nama"
                                v-model="form.nama"
                                :class="{ 'p-invalid': form.errors.nama }"
                                placeholder="Masukkan nama kalender"
                            />
                            <small class="text-red-500" v-if="form.errors.nama">{{ form.errors.nama }}</small>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="upload_id">File Kalender</label>
                            <Dropdown
                                v-model="form.upload_id"
                                :options="documents"
                                optionLabel="label"
                                optionValue="value"
                                :filter="true"
                                :class="{ 'p-invalid': form.errors.upload_id }"
                                placeholder="Pilih file kalender"
                                class="w-full"
                            />
                            <small class="text-red-500" v-if="form.errors.upload_id">{{ form.errors.upload_id }}</small>
                        </div>
                        <div class="flex justify-end gap-2">
                            <Button
                                type="button"
                                label="Kembali"
                                class="p-button-secondary"
                                @click="router.get('/admin/akademik')"
                            />
                            <Button
                                type="submit"
                                label="Simpan"
                                :loading="form.processing"
                            />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Card, Toast } from 'primevue';
import { onMounted, ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import { useForm, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
    documents: {
        type: Array,
        required: true
    }
});

const toast = useToast();

const form = useForm({
    thnajr: '',
    nama: '',
    upload_id: null,
});

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Akademik' },
    { label: 'Kalender' },
    { label: 'Tambah' },
]);

const submit = () => {
    form.post('/admin/akademik/store', {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Kalender berhasil ditambahkan',
                life: 3000
            });
            router.get('/admin/akademik');
        },
    });
};
</script>
