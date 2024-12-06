<template>

    <Head>
        <title>Kalender Akademik</title>
        <meta name="description" content="Kalender Akademik" />
    </Head>

    <LoggedInLayout title="Kalender Akademik">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Kalender Akademik</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Kalender...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Kalender" type="button"
                        @click="createKalender" />
                </div>
            </div>
            <Card class="border">
                <template #title>Kalender Akademik</template>
                <template #content>
                    <DataTable :value="kalender.data" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((kalender.current_page - 1) * kalender.per_page) }}
                            </template>
                        </Column>
                        <Column field="thnajr" header="Tahun Ajaran" sortable style="width: 10%;" />
                        <Column field="nama" header="Nama" sortable style="width: 15%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words">{{ data.nama }}</div>
                            </template>
                        </Column>
                        <Column field="tgl_upload" header="Tanggal Upload" sortable style="width: 15%;">
                            <template #body="{ data }">
                                {{ formatDate(data.tgl_upload) }}
                            </template>
                        </Column>
                        <Column field="file" header="File" style="width: 10%;">
                            <template #body="{ data }">
                                <div v-if="data.document" class="flex items-center gap-2">
                                    <Button
                                        class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-download" @click="() => handleDownload(data.id)" />
                                    <span class="text-sm whitespace-pre-wrap break-words">{{ data.document.nama_file
                                        }}</span>
                                </div>
                                <span v-else class="text-gray-500 text-sm">Tidak ada file</span>
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editKalender(data.id)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Kalender" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus kalender
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteKalender"></Button>
                        </div>
                    </Dialog>
                </template>
                <template #footer>
                    <Pagination :currentPage="kalender.current_page" :from="kalender.from"
                        :lastPage="kalender.last_page" :links="kalender.links" :nextPageUrl="kalender.next_page_url"
                        :prevPageUrl="kalender.prev_page_url" :to="kalender.to" :total="kalender.total" />
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
import Pagination from '@/Components/Pagination.vue';
import { onMounted, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { Head } from '@inertiajs/vue3';
import Toast from 'primevue/toast';

const props = defineProps({
    kalender: Object,
    message: Object,
    filters: Object
});

const toast = useToast();
const visible = ref(false);
const kalenderIdToDelete = ref(null);
const search = ref(props.filters?.search || '');

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

const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

const home = ref({
    icon: 'pi pi-home',
    to: '/'
});

const items = ref([
    { label: 'Akademik' },
    { label: 'Kalender' },
]);

watch(search, (query) => {
    router.get('/admin/akademik', {
        search: query
    }, {
        preserveState: true,
        preserveScroll: true
    });
});

const createKalender = () => {
    router.get('/admin/akademik/create');
};

const confirmDelete = (id) => {
    kalenderIdToDelete.value = id;
    visible.value = true;
};

const deleteKalender = () => {
    router.delete(`/admin/akademik/destroy/${kalenderIdToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            visible.value = false;
        },
    });
};

const editKalender = (id) => {
    router.get(`/admin/akademik/edit/${id}`);
};

const handleDownload = (id) => {
    window.location.href = route('kalender.download', id);
};
</script>
