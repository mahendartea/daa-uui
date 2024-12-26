<template>

    <Head>
        <title>Halaman Statis</title>
        <meta name="description" content="Halaman Statis" />
    </Head>
    <LoggedInLayout title="Halaman Statis">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Halaman Statis</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Halaman...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Halaman" type="button" @click="createPage" />
                </div>
            </div>
            <Card class="border">
                <template #title>Halaman Statis</template>
                <template #content>
                    <DataTable :value="formattedPages" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((props.pages.current_page - 1) * props.pages.per_page) }}
                            </template>
                        </Column>
                        <Column field="title" header="Judul" sortable style="width: 30%;" />
                        <Column header="URL" style="width: 20%;">
                            <template #body="{ data }">
                                <span  class="text-gray-500 hover:text-primary-600 underline">
                                    /pages/{{ data.judul_seo }}
                                </span>
                            </template>
                        </Column>
                        <Column :body="formatDate" field="updated_at" header="Diubah" sortable style="width: 15%;" />
                        <Column field="tag" header="Tag" style="width: 10%;" />
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editPage(data.id)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id)" />
                                    <Button
                                        class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-eye" icon-class="p-w-4" label="view" size="small" type="button"
                                        @click="viewPage(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Halaman" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus halaman
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deletePage"></Button>
                        </div>
                    </Dialog>
                </template>

                <template #footer>
                    <Pagination :currentPage="pages.current_page" :from="pages.from" :lastPage="pages.last_page"
                        :links="pages.links" :nextPageUrl="pages.next_page_url" :prevPageUrl="pages.prev_page_url"
                        :to="pages.to" :total="pages.total" />
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
import Pagination from '@/Components/Pagination.vue';
import { computed, onMounted, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { Head } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
    pages: Object,
    message: Object,
    filters: Object
});

const toasts = useToast();
const visible = ref(false);
const pageIdToDelete = ref(null);

// Initialize search with the filter value from props
const search = ref(props.filters?.search || '');

// Computed property to format the pages data
const formattedPages = computed(() => {
    return props.pages.data.map(page => ({
        ...page,
        updated_at: formatDate(page.updated_at),
    }));
});

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
    { label: 'Halaman Statis' },
    { label: 'Data' },
]);

// Debounced search function
const debouncedSearch = debounce((value) => {
    router.get('/admin/statis', {
        search: value
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['pages']
    });
}, 300);

// Watch for search changes
watch(search, (value) => {
    debouncedSearch(value);
});

const createPage = () => {
    router.get('/admin/statis/create');
};

const editPage = (id) => {
    router.get(`/admin/statis/${id}/edit`);
};

const viewPage = (page) => {
    window.open(`/pages/${page.judul_seo}`, '_blank');
};

const confirmDelete = (id) => {
    pageIdToDelete.value = id;
    visible.value = true;
};

const deletePage = () => {
    router.delete(`/admin/statis/${pageIdToDelete.value}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Halaman berhasil dihapus',
            });
            visible.value = false;
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal menghapus halaman',
            });
        },
    });
};

onMounted(() => {
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
