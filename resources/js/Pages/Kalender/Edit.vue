<template>
    <Head>
        <title>Edit Kalender Akademik</title>
        <meta name="description" content="Edit Kalender Akademik" />
    </Head>

    <LoggedInLayout title="Edit Kalender Akademik">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Edit Kalender Akademik</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Silakan edit data kalender akademik.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submit">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <FloatLabel>
                                        <InputText
                                            id="thnajr"
                                            v-model="form.thnajr"
                                            :class="{ 'p-invalid': form.errors.thnajr }"
                                            class="w-full"
                                        />
                                        <label for="thnajr">Tahun Ajaran</label>
                                    </FloatLabel>
                                    <small class="p-error" v-if="form.errors.thnajr">{{ form.errors.thnajr }}</small>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <FloatLabel>
                                        <InputText
                                            id="nama"
                                            v-model="form.nama"
                                            :class="{ 'p-invalid': form.errors.nama }"
                                            class="w-full"
                                        />
                                        <label for="nama">Nama</label>
                                    </FloatLabel>
                                    <small class="p-error" v-if="form.errors.nama">{{ form.errors.nama }}</small>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <FloatLabel>
                                        <Dropdown
                                            v-model="form.upload_id"
                                            :options="documents"
                                            optionLabel="label"
                                            optionValue="value"
                                            :filter="true"
                                            :class="{ 'p-invalid': form.errors.upload_id }"
                                            class="w-full"
                                            placeholder="Pilih Dokumen"
                                        />
                                        <label for="upload_id">Dokumen</label>
                                    </FloatLabel>
                                    <small class="p-error" v-if="form.errors.upload_id">{{ form.errors.upload_id }}</small>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
                        >
                            <Button
                                type="button"
                                label="Batal"
                                class="p-button-secondary mr-2"
                                @click="router.get(route('kalender.index'))"
                            />
                            <Button
                                type="submit"
                                label="Simpan"
                                :loading="form.processing"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import Dropdown from 'primevue/dropdown';
import Breadcrumb from 'primevue/breadcrumb';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';

const props = defineProps({
    kalender: {
        type: Object,
        required: true
    },
    documents: {
        type: Array,
        required: true
    },
    message: Object
});

const toast = useToast();

onMounted(() => {
    if (props.message) {
        toast.add({
            severity: props.message.type,
            summary: 'Notifikasi',
            detail: props.message.text,
            life: 3000
        });
    }
});

const form = useForm({
    thnajr: props.kalender.thnajr,
    nama: props.kalender.nama,
    upload_id: props.kalender.upload_id,
});

const home = ref({
    icon: 'pi pi-home',
    to: '/'
});

const items = ref([
    { label: 'Akademik' },
    { label: 'Kalender', to: route('kalender.index') },
    { label: 'Edit' }
]);

const submit = () => {
    form.put(route('kalender.update', props.kalender.id), {
        preserveScroll: true
    });
};
</script>
