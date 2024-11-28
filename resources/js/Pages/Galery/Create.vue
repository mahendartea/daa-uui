<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { FloatLabel } from 'primevue';
import Select from 'primevue/select';
import Checkbox from 'primevue/checkbox';
import Calendar from 'primevue/calendar';
import FileUpload from 'primevue/fileupload';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { useForm } from '@inertiajs/vue3';

const toast = useToast();
const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Galeri' },
    { label: 'Tambah' },
]);

const props = defineProps(['albums']);

const form = useForm({
    gambar: [],
    album_id: null,
    ket_gambar: '',
    slide_home: false,
    tgl_upload: new Date(),
});

const albums = ref([]);
albums.value = props.albums?.map(album => ({
    label: album.nama_album,
    value: album.id_album
})) || [];

const onSelect = (event) => {
    form.gambar = [...event.files];
    toast.add({ severity: 'info', summary: 'Success', detail: `${event.files.length} Files Selected`, life: 3000 });
};

const onFormSubmit = () => {
    form.post('/admin/galeries/store', {
        onSuccess: () => {
            form.reset();
            toast.add({ severity: 'success', summary: 'Success', detail: 'Gallery Created', life: 3000 });
        },
        onError: (errors) => {
            console.error('Form submission failed', errors);
            toast.add({ severity: 'error', summary: 'Error', detail: 'Form submission failed', life: 3000 });
        },
        forceFormData: true
    });
};
</script>

<template>
    <LoggedInLayout title="Tambah Galeri">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Galeri</h2>
            <form @submit.prevent="onFormSubmit" class="w-full flex flex-wrap justify-end text-center mt-10">

                <div class="card grid grid-cols-2 w-full gap-10">
                    <div class="w-full col-span-2">
                        <FileUpload @select="onSelect" :multiple="true" accept="image/*" :maxFileSize="5000000"
                            class="w-full" :auto="true">
                            <template #empty>
                                <span>Drag and drop images here to upload.</span>
                            </template>
                        </FileUpload>
                        <small v-if="form.errors.gambar" class="p-error">{{ form.errors.gambar }}</small>
                    </div>

                    <FloatLabel class="w-full">
                        <Select v-model="form.album_id" :options="albums" optionLabel="label"
                            placeholder="Select an Album" class="w-full" />
                        <label for="album_id">Album</label>
                        <small v-if="form.errors.album_id" class="p-error">{{ form.errors.album_id }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <InputText id="ket_gambar" v-model="form.ket_gambar" class="w-full" />
                        <label for="ket_gambar">Keterangan Gambar</label>
                        <small v-if="form.errors.ket_gambar" class="p-error">{{ form.errors.ket_gambar }}</small>
                    </FloatLabel>

                    <div class="flex items-center w-full">
                        <Checkbox v-model="form.slide_home" :binary="true" />
                        <label for="slide_home" class="ml-2">Tampilkan di Slide Home</label>
                        <small v-if="form.errors.slide_home" class="p-error">{{ form.errors.slide_home }}</small>
                    </div>

                    <FloatLabel class="w-full">
                        <Calendar v-model="form.tgl_upload" dateFormat="yy-mm-dd" class="w-full" />
                        <label for="tgl_upload">Tanggal Upload</label>
                        <small v-if="form.errors.tgl_upload" class="p-error">{{ form.errors.tgl_upload }}</small>
                    </FloatLabel>
                </div>

                <Button type="submit" severity="primary" label="Submit" icon="pi pi-save" icon-class="p-w-4"
                    class="mt-3 w-32 ml-2" />
            </form>
        </section>
    </LoggedInLayout>
</template>