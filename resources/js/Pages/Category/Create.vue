<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Breadcrumb } from 'primevue';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Dropdown from 'primevue/dropdown';

const home = {
    icon: 'pi pi-home'
};
const items = [
    { label: 'Post' },
    { label: 'Kategori' },
    { label: 'Tambah' },
];

const statusOptions = [
    { label: 'Aktif', value: 'Y' },
    { label: 'Tidak Aktif', value: 'N' }
];

const form = useForm({
    category: '',
    aktif: 'Y'
});

const onFormSubmit = () => {
    form.post('/admin/categories/store', {
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
    <LoggedInLayout title="Tambah Kategori">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Kategori</h2>
            <form @submit.prevent="onFormSubmit" class="my-5">
                <div class="grid grid-cols-2 gap-4">
                    <FloatLabel>
                        <InputText id="category" v-model="form.category" class="w-full" />
                        <label for="category">Nama Kategori</label>
                        <small v-if="form.errors.category" class="p-error">{{ form.errors.category }}</small>
                    </FloatLabel>

                    <FloatLabel>
                        <Dropdown id="status" v-model="form.aktif" :options="statusOptions" optionLabel="label"
                            optionValue="value" class="w-full" />
                        <label for="status">Status</label>
                        <small v-if="form.errors.aktif" class="p-error">{{ form.errors.aktif }}</small>
                    </FloatLabel>
                </div>

                <div class="flex justify-end mt-4">
                    <Button class="p-button-primary hover:bg-primary-500 hover:text-white w-52" icon="pi pi-save"
                        icon-class="p-w-4" label="Tambah Kategori" type="submit" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>