<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';

const props = defineProps({
    category: {
        type: Object,
        required: true
    }
});

const items = ref([
    { label: 'Post', to: { name: 'posts.index' } },
    { label: 'Kategori', to: { name: 'categories.index' } },
    { label: 'Edit' },
]);

const statusOptions = [
    { label: 'Aktif', value: 'Y' },
    { label: 'Tidak Aktif', value: 'N' }
];

const form = useForm({
    category: props.category.category,
    aktif: props.category.aktif
});

const onFormSubmit = () => {
    form.put(`/admin/categories/update/${props.category.id}`, {
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
    <LoggedInLayout title="Edit Kategori">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="{ icon: 'pi pi-home' }" :model="items"
                class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-7xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Kategori</h2>

            <form @submit.prevent="onFormSubmit" class="my-5">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="category" class="text-gray-700 dark:text-gray-200">Nama Kategori</label>
                        <InputText id="category" v-model="form.category"
                            :class="{ 'p-invalid': form.errors.category }" />
                        <small class="text-red-500" v-if="form.errors.category">{{ form.errors.category }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="status" class="text-gray-700 dark:text-gray-200">Status</label>
                        <Dropdown id="status" v-model="form.aktif" :options="statusOptions" optionLabel="label"
                            optionValue="value" :class="{ 'p-invalid': form.errors.aktif }" />
                        <small class="text-red-500" v-if="form.errors.aktif">{{ form.errors.aktif }}</small>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Batal" class="p-button-secondary"
                        @click="form.get(route('categories.index'))" />
                    <Button type="submit" label="Simpan" class="p-button-primary" :loading="form.processing" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>
