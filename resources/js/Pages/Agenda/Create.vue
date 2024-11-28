<template>

    <Head>
        <title>Tambah Agenda</title>
        <meta name="description" content="Tambah Agenda Baru" />
    </Head>

    <LoggedInLayout title="Tambah Agenda">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Agenda</h2>

            <form @submit.prevent="submit" class="space-y-6 mt-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col space-y-1">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.nama_agenda" :class="{ 'p-invalid': form.errors.nama_agenda }"
                                class="w-full" />
                            <label :class="{ 'p-error': form.errors.nama_agenda }">Nama Agenda</label>
                        </FloatLabel>
                        <small class="p-error" v-if="form.errors.nama_agenda">{{ form.errors.nama_agenda
                            }}</small>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.tempat" :class="{ 'p-invalid': form.errors.tempat }"
                                class="w-full" />
                            <label :class="{ 'p-error': form.errors.tempat }">Tempat</label>
                        </FloatLabel>
                        <small class="p-error" v-if="form.errors.tempat">{{ form.errors.tempat }}</small>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Jadwal</label>
                        <Calendar v-model="form.jdwl_agenda" :class="{ 'p-invalid': form.errors.jdwl_agenda }"
                            dateFormat="dd/mm/yy" placeholder="Pilih Tanggal" showIcon class="w-full" />
                        <small class="p-error" v-if="form.errors.jdwl_agenda">{{ form.errors.jdwl_agenda }}</small>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <label class="text-sm font-medium">Periode</label>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col space-y-1">
                                <Calendar v-model="form.jadwal_awal" :class="{ 'p-invalid': form.errors.jadwal_awal }"
                                    dateFormat="dd/mm/yy" placeholder="Mulai" showIcon class="w-full" />
                                <small class="p-error" v-if="form.errors.jadwal_awal">{{ form.errors.jadwal_awal
                                    }}</small>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <Calendar v-model="form.jadwal_akhir" :class="{ 'p-invalid': form.errors.jadwal_akhir }"
                                    dateFormat="dd/mm/yy" placeholder="Selesai" showIcon class="w-full" />
                                <small class="p-error" v-if="form.errors.jadwal_akhir">{{
                                    form.errors.jadwal_akhir
                                    }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-1">
                    <label class="text-sm font-medium">Isi Agenda</label>
                    <Editor v-model="form.isi_agenda" :class="{ 'p-invalid': form.errors.isi_agenda }"
                        editorStyle="height: 250px" class="w-full">
                        <template v-slot:toolbar>
                            <span class="ql-formats">
                                <button class="ql-bold" aria-label="Bold"></button>
                                <button class="ql-italic" aria-label="Italic"></button>
                                <button class="ql-underline" aria-label="Underline"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered" aria-label="Ordered List"></button>
                                <button class="ql-list" value="bullet" aria-label="Unordered List"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link" aria-label="Insert Link"></button>
                                <button class="ql-image" aria-label="Insert Image"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean" aria-label="Clear Formatting"></button>
                            </span>
                        </template>
                    </Editor>
                    <small class="p-error" v-if="form.errors.isi_agenda">{{ form.errors.isi_agenda }}</small>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <Button label="Batal" severity="secondary" type="button" @click="cancel" />
                    <Button label="Simpan" type="submit" :loading="form.processing" />
                </div>
            </form>


        </section>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Card, Toast } from 'primevue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Editor from 'primevue/editor';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import { ref } from 'vue';

defineProps({
    errors: Object
});

const form = useForm({
    nama_agenda: '',
    isi_agenda: '',
    jdwl_agenda: null,
    jadwal_awal: null,
    jadwal_akhir: null,
    tempat: '',
});

const home = ref({
    icon: 'pi pi-home',
    to: '/admin'
});

const items = ref([
    { label: 'Agenda', to: '/admin/agenda' },
    { label: 'Tambah' },
]);

const submit = () => {
    form.post('/admin/agenda', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const cancel = () => {
    window.history.back();
};
</script>
