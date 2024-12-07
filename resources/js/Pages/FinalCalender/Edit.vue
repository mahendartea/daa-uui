<template>
    <Head>
        <title>Edit Jadwal Final</title>
        <meta name="description" content="Edit Jadwal Final" />
    </Head>

    <LoggedInLayout title="Edit Jadwal Final">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Edit Jadwal Final</h1>
                </div>
            </div>

            <Card class="border">
                <template #title>Form Edit Jadwal Final</template>
                <template #content>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tahun -->
                            <div class="flex flex-col">
                                <label for="id_thn" class="mb-1">Tahun</label>
                                <InputNumber v-model="form.id_thn" :useGrouping="false"
                                    :class="{ 'p-invalid': errors.id_thn }" />
                                <small class="text-red-500" v-if="errors.id_thn">{{ errors.id_thn }}</small>
                            </div>

                            <!-- Semester -->
                            <div class="flex flex-col">
                                <label for="semester" class="mb-1">Semester</label>
                                <Dropdown v-model="form.semester" :options="semesterOptions" optionLabel="label"
                                    optionValue="value" placeholder="Pilih Semester"
                                    :class="{ 'p-invalid': errors.semester }" />
                                <small class="text-red-500" v-if="errors.semester">{{ errors.semester }}</small>
                            </div>

                            <!-- Nama -->
                            <div class="flex flex-col md:col-span-2">
                                <label for="nama" class="mb-1">Nama</label>
                                <InputText v-model="form.nama" :class="{ 'p-invalid': errors.nama }" />
                                <small class="text-red-500" v-if="errors.nama">{{ errors.nama }}</small>
                            </div>

                            <!-- Current File -->
                            <div v-if="final.file" class="flex flex-col md:col-span-2">
                                <label class="mb-1">File Saat Ini</label>
                                <div class="flex items-center gap-2">
                                    <a :href="'/uploads/final/' + final.file"
                                        class="text-blue-500 hover:text-blue-700"
                                        target="_blank">
                                        {{ final.file }}
                                    </a>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="flex flex-col md:col-span-2">
                                <label for="file" class="mb-1">Upload File Baru (PDF, max 2MB)</label>
                                <div class="flex items-center gap-2">
                                    <Button type="button" @click="$refs.fileInput.click()"
                                        class="p-button-outlined" :class="{ 'p-invalid': errors.file }">
                                        <i class="pi pi-upload mr-2"></i>
                                        Pilih File
                                    </Button>
                                    <span v-if="form.file" class="text-sm">
                                        {{ form.file.name }}
                                    </span>
                                </div>
                                <input type="file" ref="fileInput" @change="handleFileUpload"
                                    accept=".pdf" class="hidden" />
                                <small class="text-red-500" v-if="errors.file">{{ errors.file }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <Button type="button" @click="goBack"
                                class="p-button-secondary p-button-outlined">
                                Batal
                            </Button>
                            <Button type="submit" :loading="processing">
                                Simpan
                            </Button>
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Card } from 'primevue';
import { ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import { useForm, Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

const props = defineProps({
    final: Object,
    errors: Object
});

const toast = useToast();
const fileInput = ref(null);
const processing = ref(false);

const semesterOptions = [
    { label: 'Ganjil', value: 'Ganjil' },
    { label: 'Genap', value: 'Genap' }
];

const form = useForm({
    id_thn: props.final.id_thn,
    semester: props.final.semester,
    nama: props.final.nama,
    file: null,
    _method: 'PUT'
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Jadwal Final', to: route('final-calender.index') },
    { label: 'Edit' }
]);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.type !== 'application/pdf') {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'File harus berformat PDF',
                life: 3000
            });
            event.target.value = '';
            return;
        }
        if (file.size > 2 * 1024 * 1024) { // 2MB in bytes
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Ukuran file maksimal 2MB',
                life: 3000
            });
            event.target.value = '';
            return;
        }
        form.file = file;
    }
};

const submit = () => {
    processing.value = true;
    form.post(route('final-calender.update', props.final.id_jfnl), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sukses',
                detail: 'Jadwal final berhasil diperbarui',
                life: 3000
            });
            processing.value = false;
        },
        onError: () => {
            processing.value = false;
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat memperbarui data',
                life: 3000
            });
        }
    });
};

const goBack = () => {
    window.history.back();
};
</script>
