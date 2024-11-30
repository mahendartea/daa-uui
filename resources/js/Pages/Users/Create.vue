<template>
    <LoggedInLayout title="Tambah Pengguna">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Pengguna</h2>

            <!-- General Error Message -->
            <div v-if="errors.error" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ errors.error }}
            </div>

            <form @submit.prevent="submit" class="w-full flex flex-wrap justify-end text-center mt-10">
                <div class="card grid grid-cols-2 w-full gap-10">
                    <!-- Basic Information -->
                    <FloatLabel class="w-full">
                        <InputText id="name" v-model="form.name" class="w-full" :class="{ 'p-invalid': errors.name }" />
                        <label for="name">Nama</label>
                        <small v-if="errors.name" class="p-error">{{ errors.name }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <InputText id="email" type="email" v-model="form.email" class="w-full"
                            :class="{ 'p-invalid': errors.email }" />
                        <label for="email">Email</label>
                        <small v-if="errors.email" class="p-error">{{ errors.email }}</small>
                    </FloatLabel>

                    <!-- Password Fields -->
                    <FloatLabel class="w-full">
                        <Password id="password" v-model="form.password" :style="{ width: '100%' }"
                            :inputStyle="{ width: '100%' }" :class="{ 'p-invalid': errors.password }"
                            promptLabel="Pilih password" weakLabel="Terlalu sederhana"
                            mediumLabel="Kompleksitas rata-rata" strongLabel="Password kuat" :feedback="true" />
                        <label for="password">Password</label>
                        <small v-if="errors.password" class="p-error">{{ errors.password }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <div class="card flex justify-center">
                            <Password id="password_confirmation" v-model="form.password_confirmation"
                                :style="{ width: '100%' }" :inputStyle="{ width: '100%' }"
                                :class="{ 'p-invalid': errors.password_confirmation }" promptLabel="Konfirmasi password"
                                :feedback="true" />
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <small v-if="errors.password_confirmation" class="p-error">{{ errors.password_confirmation
                                }}</small>
                        </div>
                    </FloatLabel>

                    <!-- Role Selection -->
                    <FloatLabel class="w-full col-span-2">
                        <Dropdown id="role" v-model="form.role" :options="roles" class="w-full"
                            :class="{ 'p-invalid': errors.role }" />
                        <label for="role">Peran</label>
                        <small v-if="errors.role" class="p-error">{{ errors.role }}</small>
                    </FloatLabel>
                </div>

                <div class="flex gap-2 mt-3">
                    <Button type="button" severity="secondary" label="Batal" icon="pi pi-times" @click="cancel" />
                    <Button type="submit" severity="primary" label="Simpan" icon="pi pi-save"
                        :loading="form.processing" />
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
import Password from 'primevue/password';
import Dropdown from 'primevue/dropdown';
import { FloatLabel } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const props = defineProps({
    roles: {
        type: Array,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: null
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Pengguna', to: route('users.index') },
    { label: 'Tambah' },
]);

const submit = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'User berhasil dibuat',
                life: 3000
            });
            form.reset();
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors.error || 'Terjadi kesalahan saat membuat user',
                life: 3000
            });
            console.error('Form submission failed:', errors);
        }
    });
};

const cancel = () => {
    window.history.back();
};
</script>
