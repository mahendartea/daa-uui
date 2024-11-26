<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref, onMounted, computed } from 'vue';
import { DataTable, FloatLabel, Toast, useToast } from 'primevue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Paginator from 'primevue/paginator';

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Galery' },
    { label: 'Data' },
]);

const search = ref('');
const visible = ref(false);
const selectedId = ref(null);
const toasts = useToast();

const props = defineProps({
    galeries: Object,
    message: Object
});

const first = ref(0);
const rows = ref(10);

const currentGaleries = computed(() => {
    return props.galeries.slice(first.value, first.value + rows.value);
});

const onPage = (event) => {
    first.value = event.first;
    rows.value = event.rows;
};

const createGalery = () => {
    router.get(route('galeries.create'));
};

const editGalery = (id) => {
    router.get(route('galery.edit', id));
};

const viewGalery = (galery) => {
    router.get(route('galery.show', galery.id));
};

const confirmDelete = (id) => {
    selectedId.value = id;
    visible.value = true;
};

const deleteGalery = () => {
    router.delete(route('galeries.destroy', selectedId.value), {
        onSuccess: () => {
            visible.value = false;
            toasts.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Galeri berhasil dihapus',
                life: 3000,
            });
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menghapus galeri',
                life: 3000,
            });
        },
    });
};

onMounted(() => {
    if (props.message) {
        toasts.value.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000,
        });
    }
});

</script>

<template>
    <LoggedInLayout title="Galery">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Galery</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Galeri...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Galeri" type="button"
                        @click="createGalery" />
                </div>
            </div>

            <Card class="border">
                <template #title>Galery</template>
                <template #content>
                    <DataTable :value="currentGaleries" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column field="id" header="ID" sortable style="width: 10%;" />
                        <Column field="gambar" header="Gambar" sortable style="width: 40%;" />
                        <Column field="album.nama_album" header="Kategori Album" sortable style="width: 10%;" />
                        <Column field="ket_gambar" header="Keterangan Gambar" sortable style="width: 15%;" />
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editGalery(data.id)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id)" />
                                    <Button
                                        class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-eye" icon-class="p-w-4" label="View" size="small" type="button"
                                        @click="viewGalery(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Paginator :rows="rows" :first="first" :totalRecords="props.galeries.length"
                        :rowsPerPageOptions="[10, 20, 30]" @page="onPage" class="mt-4" />
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus galeri" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus galeri
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteGalery"></Button>
                        </div>
                    </Dialog>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>