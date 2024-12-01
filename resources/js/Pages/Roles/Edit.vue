<template>

    <Head>
        <title>Edit Peran</title>
        <meta name="description" content="Edit Role" />
    </Head>
    <LoggedInLayout title="Edit Peran">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Peran</h2>

            <!-- General Error Message -->
            <div v-if="errors.error" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ errors.error }}
            </div>

            <form @submit.prevent="submit" class="w-full flex flex-wrap justify-end text-center mt-10">
                <div class="card grid grid-cols-1 w-full gap-10">
                    <!-- Name -->
                    <FloatLabel class="w-full">
                        <InputText id="name" v-model="form.name" class="w-full" :class="{ 'p-invalid': errors.name }" />
                        <label for="name">Nama Peran</label>
                        <small v-if="errors.name" class="p-error">{{ errors.name }}</small>
                    </FloatLabel>

                    <!-- Permissions -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="permission in permissions" :key="permission"
                                class="flex items-center bg-gray-100 p-2 rounded">
                                <Checkbox :id="permission" v-model="form.permissions" :value="permission" />
                                <label :for="permission" class="ml-2 text-sm text-gray-700">{{ permission }}</label>
                            </div>
                        </div>
                        <small v-if="errors.permissions" class="p-error">{{ errors.permissions }}</small>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Batal" class="p-button-secondary" @click="cancel" />
                    <Button type="submit" label="Simpan" />
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
import Checkbox from 'primevue/checkbox';

const toast = useToast();
const props = defineProps({
    role: {
        type: Object,
        required: true
    },
    permissions: {
        type: Array,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Peran', to: route('roles.index') },
    { label: 'Edit' },
]);

const submit = () => {
    form.put(route('roles.update', props.role.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Peran berhasil diperbarui',
                life: 3000
            });
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors.error || 'Terjadi kesalahan saat memperbarui peran',
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
