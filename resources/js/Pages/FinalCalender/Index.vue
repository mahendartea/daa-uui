<template>
    <Head>
        <title>Jadwal Final</title>
        <meta name="description" content="Jadwal Final" />
    </Head>

    <LoggedInLayout title="Jadwal Final">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Jadwal Final</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Jadwal Final...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Jadwal" type="button"
                        @click="createFinal" />
                </div>
            </div>

            <Card class="border">
                <template #title>Jadwal Final</template>
                <template #content>
                    <DataTable :value="finals.data" :paginator="true" :rows="perPage"
                        :total-records="finals.total" :lazy="true" :rows-per-page-options="[5,10,20,50]"
                        @page="onPage($event)" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem" :loading="loading">
                        <Column header="No" style="width: 5%;">
                            <template #body="slotProps">
                                {{ slotProps.index + 1 + ((finals.current_page - 1) * perPage) }}
                            </template>
                        </Column>
                        <Column field="id_thn" header="Tahun" sortable style="width: 10%;" />
                        <Column field="semester" header="Semester" sortable style="width: 15%;" />
                        <Column field="nama" header="Nama" sortable style="width: 30%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words">{{ data.nama }}</div>
                            </template>
                        </Column>
                        <Column field="file" header="File" style="width: 10%;">
                            <template #body="{ data }">
                                <a :href="'/uploads/final/' + data.file"
                                   class="text-blue-500 hover:text-blue-700"
                                   target="_blank">
                                    Download
                                </a>
                            </template>
                        </Column>
                        <Column field="tgl_upload" header="Tanggal Upload" sortable style="width: 15%;">
                            <template #body="{ data }">
                                {{ formatDate(data.tgl_upload) }}
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editFinal(data.id_jfnl)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id_jfnl)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Jadwal" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">
                            Apakah anda yakin menghapus jadwal final ini?
                        </span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="visible = false" />
                            <Button label="Hapus" severity="danger" type="button" @click="deleteFinal" />
                        </div>
                    </Dialog>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Card } from 'primevue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { onMounted, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    finals: Object,
    message: Object,
    filters: Object
});

const toast = useToast();
const visible = ref(false);
const finalIdToDelete = ref(null);
const search = ref(props.filters?.search || '');
const loading = ref(false);
const perPage = ref(10);

// Show toast message when available
onMounted(() => {
    if (props.message) {
        toast.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000
        });
    }
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Jadwal Final' }
]);

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

watch(search, debounce((value) => {
    router.get('/admin/final-calender', { search: value, per_page: perPage.value }, {
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

    router.get('/admin/final-calender', {
        page: page,
        per_page: perPageValue,
        search: search.value
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};

const createFinal = () => {
    router.get(route('final-calender.create'));
};

const editFinal = (id) => {
    router.get(route('final-calender.edit', id));
};

const confirmDelete = (id) => {
    finalIdToDelete.value = id;
    visible.value = true;
};

const deleteFinal = () => {
    if (finalIdToDelete.value) {
        loading.value = true;
        router.delete(route('final-calender.destroy', finalIdToDelete.value), {
            onSuccess: () => {
                toast.add({
                    severity: 'success',
                    summary: 'Sukses',
                    detail: 'Jadwal final berhasil dihapus',
                    life: 3000
                });
                visible.value = false;
                loading.value = false;
            },
            onError: () => {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: 'Terjadi kesalahan saat menghapus data',
                    life: 3000
                });
                loading.value = false;
            },
            preserveScroll: true
        });
    }
};
</script>
