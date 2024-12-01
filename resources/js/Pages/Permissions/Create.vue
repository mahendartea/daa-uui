<template>
    <Head>
        <title>Tambah Izin</title>
        <meta name="description" content="Create Permission" />
    </Head>
    <LoggedInLayout title="Tambah Izin">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Izin</h2>

            <!-- General Error Message -->
            <div v-if="errors.error" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ errors.error }}
            </div>

            <form @submit.prevent="submit" class="w-full flex flex-wrap justify-end text-center mt-10">
                <div class="card grid grid-cols-1 w-full gap-10">
                    <!-- Name -->
                    <FloatLabel class="w-full">
                        <InputText id="name" v-model="form.name" class="w-full" :class="{ 'p-invalid': errors.name }" />
                        <label for="name">Nama Izin</label>
                        <small v-if="errors.name" class="p-error">{{ errors.name }}</small>
                    </FloatLabel>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Batal" class="p-button-secondary" @click="cancel" />
                    <Button type="submit" label="Simpan" :loading="form.processing" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { FloatLabel } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

const toast = useToast();
const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: '',
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Izin', to: route('permissions.index') },
    { label: 'Tambah' },
]);

const submit = () => {
    form.post(route('permissions.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Izin berhasil dibuat',
                life: 3000
            });
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors.error || 'Terjadi kesalahan saat membuat izin',
                life: 3000
            });
        }
    });
};

const cancel = () => {
    window.history.back();
};
</script>
