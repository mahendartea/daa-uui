<template>

    <Head>
        <title>Agenda</title>
        <meta name="description" content="Agenda" />
    </Head>

    <LoggedInLayout title="Agenda">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Agenda</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Agenda...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Agenda" type="button"
                        @click="createAgenda" />
                </div>
            </div>
            <Card class="border">
                <template #title>Agenda</template>
                <template #content>
                    <DataTable :value="agenda" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column field="nama_agenda" header="Nama Agenda" sortable style="width: 20%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words">{{ data.nama_agenda }}</div>
                            </template>
                        </Column>
                        <Column field="isi_agenda" header="Isi Agenda" sortable style="width: 15%;">
                            <template #body="{ data }">
                                <div v-html="data.isi_agenda" class="whitespace-pre-wrap break-words"></div>
                            </template>
                        </Column>
                        <Column field="tempat" header="Tempat" sortable style="width: 10%;" />
                        <Column field="jdwl_agenda" header="Jadwal" sortable style="width: 10%;">
                            <template #body="{ data }">
                                {{ formatDate(data.jadwal_awal) }}
                            </template>
                        </Column>
                        <Column field="jadwal" header="Mulai - Selesai" sortable style="width: 15%; min-height: 10rem;">
                            <template #body="{ data }">
                                <p>{{ formatDate(data.jadwal_awal) }}</p> - {{ formatDate(data.jadwal_akhir) }}
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 10%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editAgenda(data.id)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Agenda" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus agenda
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteAgenda"></Button>
                        </div>
                    </Dialog>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Card, Toast } from 'primevue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { computed, onMounted, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    agenda: Object,
    message: Object
});

const toasts = useToast();

// Show toast message when available
onMounted(() => {
    if (props.message) {
        toasts.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: props.message.life
        });
    }
});

const visible = ref(false);
const agendaIdToDelete = ref(null);

// Function to format the date to Indonesian format
const formatDate = (dateString) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', options);
};

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Agenda' },
    { label: 'Data' },
]);

const search = ref('');

watch(search, (mencari) => {
    router.get('/admin/agenda', {
        search: mencari
    }, { preserveState: true });
});

const createAgenda = () => {
    router.get('/admin/agenda/create');
};

const confirmDelete = (id) => {
    agendaIdToDelete.value = id;
    visible.value = true;
};

const deleteAgenda = () => {
    router.delete(`/admin/agenda/destroy/${agendaIdToDelete.value}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Agenda berhasil dihapus',
            });
            visible.value = false;
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal menghapus agenda',
            });
        },
    });
};

const editAgenda = (id) => {
    router.get(`/admin/agenda/edit/${id}`);
};
</script>