<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref, onMounted, computed } from 'vue';
import { DataTable, FloatLabel } from 'primevue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Paginator from 'primevue/paginator';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Album' },
    { label: 'Data' },
]);

const visible = ref(false);
const selectedId = ref(null);
const toasts = useToast();

const props = defineProps({
    albums: {
        type: Object,
        default: () => []
    },
    message: Object
});

const first = ref(0);
const rows = ref(10);

const currentAlbums = computed(() => {
    return props.albums ? props.albums.slice(first.value, first.value + rows.value) : [];
});

const onPage = (event) => {
    first.value = event.first;
    rows.value = event.rows;
};

const createAlbum = () => {
    router.get(route('albums.create'));
};

const editAlbum = (id) => {
    router.get(route('albums.edit', id));
};

const confirmDelete = (id) => {
    selectedId.value = id;
    visible.value = true;
};

const deleteAlbum = () => {
    router.delete(`/admin/albums/destroy/${selectedId.value}`, {
        onSuccess: () => {
            visible.value = false;
            toasts.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Album berhasil dihapus',
                life: 3000,
            });
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menghapus album',
                life: 3000,
            });
        },
    });
};

onMounted(() => {
    console.log(props.message);
    if (props.message) {
        toasts.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000,
        });
    }
});
</script>

<template>
    <LoggedInLayout title="Album">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Album</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Album" type="button" @click="createAlbum" />
                </div>
            </div>

            <Card class="border">
                <template #title>Album</template>
                <template #content>
                    <DataTable :value="currentAlbums" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + first }}
                            </template>
                        </Column>
                        <Column field="nama_album" header="Nama Album" sortable style="width: 40%;" />
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editAlbum(data.id_album)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id_album)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Paginator :rows="rows" :first="first" :totalRecords="props.albums.length"
                        :rowsPerPageOptions="[5, 10, 20]" @page="onPage" class="mt-4" />
                </template>
            </Card>

            <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Album" modal>
                <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus album
                    ini?</span>
                <div class="flex justify-end gap-2">
                    <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                    <Button label="Hapus" type="button" @click="deleteAlbum"></Button>
                </div>
            </Dialog>
        </div>
    </LoggedInLayout>
</template>
