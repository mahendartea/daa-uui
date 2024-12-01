<template>
    <Head>
        <title>Peran</title>
        <meta name="description" content="Role Management" />
    </Head>
    <LoggedInLayout title="Peran">
        <Toast />
        <ConfirmDialog />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Peran</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Peran...</label>
                    </FloatLabel>
                    <Link v-if="can.create_role"
                        class="p-button p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        :href="route('roles.create')">
                        <i class="pi pi-plus mr-2"></i>
                        Tambah Peran
                    </Link>
                </div>
            </div>
            <Card class="border">
                <template #title>Daftar Peran</template>
                <template #content>
                    <DataTable :value="roles.data" responsiveLayout="scroll" stripedRows>
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((roles.current_page - 1) * roles.per_page) }}
                            </template>
                        </Column>
                        <Column field="name" header="Nama" sortable style="width: 20%;" />
                        <Column field="permissions" header="Permissions" style="width: 50%;">
                            <template #body="{ data }">
                                <div class="flex flex-wrap gap-1">
                                    <Chip v-for="permission in data.permissions" :key="permission" :label="permission"
                                        class="bg-primary-100 text-primary-700" />
                                </div>
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <div class="flex gap-1">
                                    <Button v-if="can.edit_role"
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" @click="editRole(data.id)" />
                                    <Button v-if="can.delete_role"
                                        class="p-button-danger p-button-outlined hover:bg-red-500 hover:text-white"
                                        icon="pi pi-trash" @click="confirmDelete(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Peran" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus peran ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteRole"></Button>
                        </div>
                    </Dialog>
                </template>
                <template #footer>
                    <Pagination :links="roles.links" class="mt-6" />
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
import Pagination from '@/Components/Pagination.vue';
import Chip from 'primevue/chip';
import ConfirmDialog from 'primevue/confirmdialog';

const toast = useToast();
const visible = ref(false);
const roleToDelete = ref(null);

const props = defineProps({
    roles: Object,
    can: Object,
    filters: Object
});

const home = ref({
    icon: 'pi pi-home',
    to: route('dashboard')
});

const items = ref([
    { label: 'Peran' },
    { label: 'Data' },
]);

const search = ref(props.filters.search || '');

watch(search, (query) => {
    router.get(route('roles.index'), {
        search: query
    }, {
        preserveState: true
    });
});

const editRole = (id) => {
    router.get(route('roles.edit', id));
};

const confirmDelete = (role) => {
    roleToDelete.value = role;
    visible.value = true;
};

const deleteRole = () => {
    router.delete(route('roles.destroy', roleToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Peran berhasil dihapus',
                life: 3000
            });
            visible.value = false;
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors.error || 'Terjadi kesalahan saat menghapus peran',
                life: 3000
            });
            console.error('Delete failed:', errors);
            visible.value = false;
        }
    });
};
</script>
