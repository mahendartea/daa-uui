<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const props = defineProps({
    album: {
        type: Object,
        required: true
    }
});

const items = ref([
    { label: 'Album', to: { name: 'albums.index' } },
    { label: 'Edit' },
]);

const form = useForm({
    nama_album: props.album.nama_album,
});

const onFormSubmit = () => {
    form.put(`/admin/albums/update/${props.album.id_album}`, {
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
    <LoggedInLayout>
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <template #title>Edit Album</template>
                    <template #content>
                        <form @submit.prevent="onFormSubmit" class="flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="nama_album">Nama Album</label>
                                <InputText id="nama_album" v-model="form.nama_album"
                                    :class="{ 'p-invalid': form.errors.nama_album }" />
                                <small class="text-red-500" v-if="form.errors.nama_album">{{ form.errors.nama_album
                                    }}</small>
                            </div>
                            <div class="flex justify-end gap-2">
                                <Button type="button" label="Batal" class="p-button-secondary"
                                    @click="form.get(route('albums.index'))" />
                                <Button type="submit" label="Simpan" class="p-button-primary"
                                    :loading="form.processing" />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </LoggedInLayout>
</template>
