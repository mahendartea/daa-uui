<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref, computed, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Breadcrumb from 'primevue/breadcrumb';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import Card from 'primevue/card';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';

const toast = useToast();
const props = defineProps({
    documents: {
        type: Object,
        required: true
    },
    message: {
        type: Object,
        required: false
    }
});

const items = ref([
    { label: 'Dokumen' },
    { label: 'Data' },
]);

const home = ref({ icon: 'pi pi-home' });
const visible = ref(false);
const documentIdToDelete = ref(null);
const search = ref('');

watch(search, (query) => {
    router.get('/admin/documents', {
        search: query
    }, { preserveState: true });
});

const formatDate = (value) => {
    if (!value) return '';
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(value).toLocaleString('id-ID', options);
};

const confirmDelete = (id) => {
    documentIdToDelete.value = id;
    visible.value = true;
};

const deleteDocument = () => {
    router.delete(route('documents.destroy', documentIdToDelete.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Dokumen berhasil dihapus',
                life: 3000
            });
            visible.value = false;
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Gagal menghapus dokumen',
                life: 3000
            });
        },
    });
};

const createDocument = () => {
    router.get(route('documents.create'));
};

const editDocument = (id) => {
    router.get(route('documents.edit', id));
};

onMounted(() => {
    if (props.message) {
        toast.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: props.message.life
        });
    }
});
</script>

<template>

    <Head>
        <title>Dokumen</title>
        <meta name="description" content="Dokumen" />
    </Head>
    <LoggedInLayout title="Dokumen">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Dokumen</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Dokumen...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Dokumen" type="button"
                        @click="createDocument" />
                </div>
            </div>

            <Card class="border">
                <template #title>Dokumen</template>
                <template #content>
                    <DataTable :value="documents.data" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((documents.current_page - 1) * documents.per_page) }}
                            </template>
                        </Column>
                        <Column field="nama_file" header="Nama File" sortable style="width: 25%;">
                            <template #body="slotProps">
                                <div class="flex items-center gap-2">
                                    <span class="whitespace-pre-wrap break-words">{{ slotProps.data.nama_file }}</span>
                                    <template v-if="slotProps.data.link_external">
                                        <span class="text-xs text-gray-500 bg-gray-200 px-2">Link</span>
                                    </template>
                                </div>
                            </template>
                        </Column>
                        <Column header="File" style="width: 5%;">
                            <template #body="slotProps">
                                <i class="pi pi-file text-xl" />
                            </template>
                        </Column>
                        <Column field="tgl_upload" header="Tanggal Upload"
                            :body="slotProps => formatDate(slotProps.data.tgl_upload)" sortable style="width: 15%;" />
                        <Column field="created" header="Created By" sortable style="width: 10%;" />
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="slotProps">
                                <div class="flex gap-2">
                                    <template v-if="slotProps.data.link_external">
                                        <a :href="slotProps.data.link_external" target="_blank" class="p-button p-button-info p-button-outlined hover:bg-primary-500 hover:text-white">
                                            <i class="pi pi-external-link p-mr-2 p-w-4"></i>
                                            <span>Buka Link</span>
                                        </a>
                                    </template>
                                    <template v-else>
                                        <Button
                                            class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white"
                                            icon="pi pi-eye" icon-class="p-w-4" label="Lihat" size="small" type="button"
                                            @click="router.get(route('documents.show', slotProps.data.id))" />
                                    </template>
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="router.get(route('documents.edit', slotProps.data.id))" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small" type="button"
                                        @click="confirmDelete(slotProps.data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus dokumen" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus dokumen
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteDocument"></Button>
                        </div>
                    </Dialog>
                </template>

                <template #footer>
                    <Pagination :currentPage="documents.current_page" :from="documents.from"
                        :lastPage="documents.last_page" :links="documents.links" :nextPageUrl="documents.next_page_url"
                        :prevPageUrl="documents.prev_page_url" :to="documents.to" :total="documents.total" />
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>
