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
                    <DataTable :value="agenda.data" :paginator="true" :rows="perPage"
                        :total-records="agenda.total" :lazy="true" :rows-per-page-options="[5,10,20,50]"
                        @page="onPage($event)" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem" :loading="loading">
                        <Column header="No" style="width: 5%;">
                            <template #body="slotProps">
                                {{ slotProps.index + 1 + ((agenda.current_page - 1) * perPage) }}
                            </template>
                        </Column>


                        <Column field="nama_agenda" header="Nama Agenda" sortable style="width: 20%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words">{{ data.nama_agenda }}</div>
                            </template>
                        </Column>
                        <Column field="isi_agenda" header="Isi Agenda" sortable style="width: 15%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words" v-html="data.isi_agenda.length > 50 ? data.isi_agenda.slice(0, 50) + '...' : data.isi_agenda"></div>
                            </template>
                        </Column>
                        <Column field="tempat" header="Tempat" sortable style="width: 10%;" />
                        <Column field="jdwl_agenda" header="Jadwal" sortable style="width: 10%;">
                            <template #body="{ data }">
                                {{ formatDate(data.jadwal_awal) }}
                            </template>
                        </Column>
                        <Column field="jadwal" header="Mulai - Selesai" sortable style="width: 15%;">
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

const loading = ref(false);
const perPage = ref(10);
const search = ref('');

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

watch(search, debounce((value) => {
    router.get('/admin/agenda', { search: value, per_page: perPage.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
}, 300));

function debounce(fn, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
}

const onPage = (event) => {
    const page = event.page + 1;
    const perPageValue = event.rows;

    if (perPage.value !== perPageValue) {
        perPage.value = perPageValue;
    }

    router.get('/admin/agenda', {
        page: page,
        per_page: perPageValue,
        search: search.value
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};

const createAgenda = () => {
    router.get('/admin/agenda/create');
};

const confirmDelete = (id) => {
    agendaIdToDelete.value = id;
    visible.value = true;
};

const deleteAgenda = () => {
    if (agendaIdToDelete.value) {
        router.delete(`/admin/agenda/destroy/${agendaIdToDelete.value}`, {
            onSuccess: () => {
                toasts.add({
                    severity: 'success',
                    summary: 'Agenda berhasil dihapus',
                    detail: 'Agenda berhasil dihapus',
                    life: 3000
                });
                visible.value = false;
                agendaIdToDelete.value = null;
            },
        });
    }
};

const editAgenda = (id) => {
    router.get(`/admin/agenda/edit/${id}`);
};
</script>
