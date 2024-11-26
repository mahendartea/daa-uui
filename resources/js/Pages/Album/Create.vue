<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Breadcrumb } from 'primevue';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
const home = {
    icon: 'pi pi-home'
};
const items = [
    { label: 'Album' },
    { label: 'Tambah' },
];

const form = useForm({
    nama_album: '',
});

const onFormSubmit = () => {
    form.post('/admin/albums/store', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Form submission failed', errors);
        }
    });
};


</script>

<template>

    <LoggedInLayout title="Tambah Album">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Album</h2>
            <form @submit.prevent="onFormSubmit" class="my-5">
                <div class="flex justify-start items-center">
                    <FloatLabel class="w-1/2">
                        <InputText id="over_label1" v-model="form.nama_album" class="w-full" />
                        <label for="over_label1">Judul Album</label>
                        <small v-if="form.errors.nama_album" class="p-error">{{ form.errors.nama_album }}</small>
                    </FloatLabel>
                    <Button class="p-button-primary hover:bg-primary-500 hover:text-white ml-2 w-52" icon="pi pi-save"
                        icon-class="p-w-4" label="Tambah Album" type="submit" />
                </div>
            </form>
        </section>

    </LoggedInLayout>

</template>