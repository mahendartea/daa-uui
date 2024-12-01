<template>

    <Head>
        <title>Izin</title>
        <meta name="description" content="Permission Management" />
    </Head>
    <LoggedInLayout title="Izin">
        <Toast />
        <ConfirmDialog />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Izin</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="filters.search" class="w-72" />
                        <label for="on_label">Cari Izin...</label>
                    </FloatLabel>
                    <Link v-if="can.create_permission"
                        class="p-button p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        :href="route('permissions.create')">
                    <i class="pi pi-plus mr-2"></i>
                    Tambah Izin
                    </Link>
                </div>
            </div>
            <Card class="border">
                <template #title>Daftar Izin</template>
                <template #content>
                    <DataTable :value="permissions.data" 
                        :paginator="true" 
                        :rows="10"
                        :totalRecords="permissions.total"
                        :loading="loading"
                        :lazy="true"
                        @page="onPage($event)"
                        paginator-template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rows-per-page-options="[10, 20, 50]"
                        current-page-report-template="Showing {first} to {last} of {totalRecords}"
                        responsiveLayout="scroll" 
                        stripedRows>
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((permissions.current_page - 1) * permissions.per_page) }}
                            </template>
                        </Column>
                        <Column field="name" header="Nama" sortable style="width: 30%;" />
                        <Column field="guard_name" header="Guard" sortable style="width: 20%;" />
                        <Column field="created_at" header="Dibuat" sortable style="width: 30%;">
                            <template #body="slotProps">
                                {{ new Date(slotProps.data.created_at).toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }) }}
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <div class="flex gap-1">
                                    <Button v-if="can.edit_permission"
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" @click="edit(data)" />
                                    <Button v-if="can.delete_permission"
                                        class="p-button-danger p-button-outlined hover:bg-red-500 hover:text-white"
                                        icon="pi pi-trash" @click="confirmDelete(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="deleteDialog" :style="{ width: '25rem' }" header="Hapus Izin" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus izin
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button"
                                @click="deleteDialog = false"></Button>
                            <Button label="Hapus" type="button" @click="deletePermission"></Button>
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
import { ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ConfirmDialog from 'primevue/confirmdialog';

const toast = useToast();
const props = defineProps({
    permissions: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    can: {
        type: Object,
        required: true
    }
});

const loading = ref(false);
const deleteDialog = ref(false);
const permissionToDelete = ref(null);

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Izin' },
    { label: 'Data' }
]);

const confirmDelete = (permission) => {
    permissionToDelete.value = permission;
    deleteDialog.value = true;
};

const deletePermission = () => {
    if (permissionToDelete.value) {
        loading.value = true;
        router.delete(route('permissions.destroy', permissionToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                deleteDialog.value = false;
                loading.value = false;
                toast.add({
                    severity: 'success',
                    summary: 'Berhasil',
                    detail: 'Izin berhasil dihapus',
                    life: 3000
                });
            },
            onError: (errors) => {
                loading.value = false;
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: errors.error || 'Terjadi kesalahan saat menghapus izin',
                    life: 3000
                });
            }
        });
    }
};

const edit = (permission) => {
    router.get(route('permissions.edit', permission.id));
};

const filters = ref({ ...props.filters });

const onPage = (event) => {
    router.get(
        route('permissions.index'),
        {
            page: event.page + 1,
            perPage: event.rows,
            search: filters.value.search
        },
        {
            preserveState: true,
            preserveScroll: true
        }
    );
};

watch(
    () => filters.value.search,
    (value) => {
        router.get(
            route('permissions.index'),
            { search: value },
            {
                preserveState: true,
                preserveScroll: true
            }
        );
    }
);
</script>
