<template>
    <Head>
        <title>Tambah Headline</title>
        <meta name="description" content="Tambah Headline" />
    </Head>

    <LoggedInLayout title="Tambah Headline">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Tambah Headline</h1>
                </div>
            </div>

            <Card class="border">
                <template #title>Form Tambah Headline</template>
                <template #content>
                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label for="isi_headline">Isi Headline</label>
                            <Textarea v-model="form.isi_headline" id="isi_headline" rows="5" 
                                :class="{ 'p-invalid': form.errors.isi_headline }" />
                            <small class="text-red-500" v-if="form.errors.isi_headline">{{ form.errors.isi_headline }}</small>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="gambar_headline">Gambar</label>
                            <div class="flex flex-col gap-2">
                                <div v-if="preview" class="mb-2">
                                    <img :src="preview" class="max-w-xs rounded" />
                                </div>
                                <FileUpload mode="basic" name="gambar_headline" accept="image/*" 
                                    :maxFileSize="2000000" @select="onSelect" @uploader="onUpload" 
                                    :class="{ 'p-invalid': form.errors.gambar_headline }" 
                                    chooseLabel="Pilih Gambar" />
                                <small class="text-red-500" v-if="form.errors.gambar_headline">{{ form.errors.gambar_headline }}</small>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <Button type="button" severity="secondary" label="Kembali" @click="back" />
                            <Button type="submit" severity="primary" label="Simpan" :loading="processing" />
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
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import { useForm, Head } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const preview = ref(null);
const processing = ref(false);

const form = useForm({
    isi_headline: '',
    gambar_headline: null
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Headline', to: route('headline.index') },
    { label: 'Tambah' }
]);

const onSelect = (event) => {
    const file = event.files[0];
    if (file) {
        form.gambar_headline = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const onUpload = () => {
    // Prevent default upload behavior as we're handling it manually
    return false;
};

const back = () => {
    window.history.back();
};

const submit = () => {
    processing.value = true;
    form.post(route('headline.store'), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sukses',
                detail: 'Headline berhasil ditambahkan',
                life: 3000
            });
            processing.value = false;
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menyimpan data',
                life: 3000
            });
            processing.value = false;
        },
        preserveScroll: true
    });
};
</script>
