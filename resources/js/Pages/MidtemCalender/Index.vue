<template>
    <LoggedInLayout title="Jadwal Midterm">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Jadwal Midterm</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Jadwal" type="button"
                        @click="createMidterm" />
                </div>
            </div>

            <Card class="border">
                <template #title>Jadwal Midterm</template>
                <template #content>
                    <DataTable :value="currentMidterms" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + first }}
                            </template>
                        </Column>
                        <Column field="id_thn" header="Tahun" sortable style="width: 10%;" />
                        <Column field="semester" header="Semester" sortable style="width: 15%;" />
                        <Column field="nama" header="Nama" sortable style="width: 30%;" />
                        <Column field="file" header="File" style="width: 10%;">
                            <template #body="{ data }">
                                <a :href="'/uploads/midterm/' + data.file"
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
                                        @click="editMidterm(data.id_jmid)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id_jmid)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Paginator :rows="rows" :first="first" :totalRecords="props.midterms.length"
                        :rowsPerPageOptions="[5, 10, 20]" @page="onPage" class="mt-4" />
                </template>
            </Card>

            <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Jadwal" modal>
                <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus jadwal
                    ini?</span>
                <div class="flex justify-end gap-2">
                    <Button label="Batal" severity="secondary" type="button" @click="visible = false"></Button>
                    <Button label="Hapus" type="button" @click="deleteMidterm"></Button>
                </div>
            </Dialog>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref, onMounted, computed } from 'vue';
import { DataTable } from 'primevue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Paginator from 'primevue/paginator';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Akademik' },
    { label: 'Jadwal Midterm' },
]);

const visible = ref(false);
const selectedId = ref(null);

const props = defineProps({
    midterms: {
        type: Object,
        default: () => []
    },
    message: Object
});

const first = ref(0);
const rows = ref(10);

const currentMidterms = computed(() => {
    return props.midterms ? props.midterms.slice(first.value, first.value + rows.value) : [];
});

const onPage = (event) => {
    first.value = event.first;
    rows.value = event.rows;
};

const createMidterm = () => {
    router.get(route('midtem-calender.create'));
};

const editMidterm = (id) => {
    router.get(route('midtem-calender.edit', id));
};

const confirmDelete = (id) => {
    selectedId.value = id;
    visible.value = true;
};

const deleteMidterm = () => {
    router.delete(`/admin/midtem-calender/${selectedId.value}`, {
        onSuccess: () => {
            visible.value = false;
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Jadwal berhasil dihapus',
                life: 3000,
            });
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menghapus jadwal',
                life: 3000,
            });
        },
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

onMounted(() => {
    if (props.message && props.message.detail) {
        toast.add({
            severity: props.message.severity || 'success',
            summary: props.message.summary || 'Message',
            detail: props.message.detail,
            life: 3000,
        });
    }
});
</script>
