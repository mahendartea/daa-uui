<template>
    <LoggedInLayout title="Edit Galeri">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Galeri</h2>
            <form @submit.prevent="onFormSubmit" class="w-full flex flex-wrap justify-end text-center mt-10">
                <div class="card grid grid-cols-2 w-full gap-10">
                    <div class="w-full col-span-2">
                        <div class="mb-4">
                            <img :src="previewImage" :alt="form.ket_gambar"
                                class="w-64 h-64 object-cover rounded-lg shadow-md mx-auto" />
                        </div>
                        <FileUpload @select="onSelect" :multiple="false" accept="image/*" :maxFileSize="5000000"
                            class="w-full" :auto="true">
                            <template #empty>
                                <span>Drag and drop new image here to replace current image.</span>
                            </template>
                        </FileUpload>
                        <small v-if="form.errors.gambar" class="p-error">{{ form.errors.gambar }}</small>
                    </div>

                    <FloatLabel class="w-full">
                        <Select v-model="form.album_id" :options="albums" optionLabel="label"
                            placeholder="Select an Album" class="w-full"
                            :class="{ 'p-invalid': form.errors.album_id }" />
                        <label for="album_id">Album</label>
                        <small v-if="form.errors.album_id" class="p-error block mt-1">{{ form.errors.album_id }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <InputText id="ket_gambar" v-model="form.ket_gambar" class="w-full"
                            :class="{ 'p-invalid': form.errors.ket_gambar }" />
                        <label for="ket_gambar">Keterangan Gambar</label>
                        <small v-if="form.errors.ket_gambar" class="p-error block mt-1">{{ form.errors.ket_gambar
                            }}</small>
                    </FloatLabel>

                    <div class="flex items-center w-full">
                        <Checkbox v-model="form.slide_home" :binary="true"
                            :class="{ 'p-invalid': form.errors.slide_home }" />
                        <label for="slide_home" class="ml-2">Tampilkan di Slide Home</label>
                        <small v-if="form.errors.slide_home" class="p-error block mt-1">{{ form.errors.slide_home
                            }}</small>
                    </div>

                    <FloatLabel class="w-full">
                        <Calendar v-model="form.tgl_upload" dateFormat="yy-mm-dd" class="w-full"
                            :class="{ 'p-invalid': form.errors.tgl_upload }" />
                        <label for="tgl_upload">Tanggal Upload</label>
                        <small v-if="form.errors.tgl_upload" class="p-error block mt-1">{{ form.errors.tgl_upload
                            }}</small>
                    </FloatLabel>
                </div>

                <Button type="submit" severity="primary" label="Update" icon="pi pi-save" icon-class="p-w-4"
                    class="mt-3 w-32 ml-2" />
            </form>
        </section>

    </LoggedInLayout>
</template>

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

const toasts = useToast();
const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Galeri' },
    { label: 'Edit' },
]);

const props = defineProps({
    galery: Object,
    albums: Array
});

const form = useForm({
    gambar: props.galery.gambar,
    album_id: {
        label: props.albums.find(a => a.id_album === props.galery.album_id)?.nama_album,
        value: props.galery.album_id
    },
    ket_gambar: props.galery.ket_gambar,
    slide_home: props.galery.slide_home,
    tgl_upload: props.galery.tgl_upload ? new Date(props.galery.tgl_upload) : null
});

const originalData = {
    gambar: props.galery.gambar,
    album_id: props.galery.album_id,
    ket_gambar: props.galery.ket_gambar,
    slide_home: props.galery.slide_home,
    tgl_upload: props.galery.tgl_upload
};

const formatDate = (date) => {
    if (!date) return null;
    const d = new Date(date);
    return d.getFullYear() + '-' +
        String(d.getMonth() + 1).padStart(2, '0') + '-' +
        String(d.getDate()).padStart(2, '0');
};

const albums = ref([]);
albums.value = props.albums?.map(album => ({
    label: album.nama_album,
    value: album.id_album
})) || [];

const previewImage = ref('/' + props.galery.gambar);

const onSelect = (event) => {
    if (event.files && event.files[0]) {
        form.gambar = event.files[0];
        previewImage.value = URL.createObjectURL(event.files[0]);
        toasts.add({ severity: 'info', summary: 'Success', detail: 'New image selected', life: 3000 });
    }
};

const onFormSubmit = () => {
    const formData = new FormData();

    // Add file if it exists
    if (form.gambar instanceof File) {
        formData.append('gambar', form.gambar);
    }

    // Add other form fields
    if (form.album_id?.value) {
        formData.append('album_id', form.album_id.value);
    }
    formData.append('ket_gambar', form.ket_gambar);
    formData.append('slide_home', form.slide_home ? '1' : '0');
    if (form.tgl_upload) {
        formData.append('tgl_upload', formatDate(form.tgl_upload));
    }

    form.put(`/admin/galeries/update/${props.galery.id}`, formData, {
        forceFormData: true,
        onSuccess: () => {
            toasts.add({ severity: 'success', summary: 'Success', detail: 'Gallery Updated', life: 3000 });
        },
        onError: () => {
            toasts.add({ severity: 'error', summary: 'Error', detail: 'Please check the form for errors', life: 3000 });
        },
        preserveScroll: true
    });
};
</script>
