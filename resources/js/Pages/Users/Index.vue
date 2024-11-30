<template>

    <Head>
        <title>Users</title>
        <meta name="description" content="Users Management" />
    </Head>
    <LoggedInLayout title="Users">
        <Toast />
        <ConfirmDialog />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Pengguna</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Pengguna...</label>
                    </FloatLabel>
                    <Link v-if="can.create_user"
                        class="p-button p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white flex items-center gap-2"
                        :href="route('users.create')">
                    <i class="pi pi-plus"></i>
                    <span>Tambah Pengguna</span>
                    </Link>
                </div>
            </div>
            <Card class="border">
                <template #title>Pengguna</template>
                <template #content>
                    <DataTable :value="users.data" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + ((users.current_page - 1) * users.per_page) }}
                            </template>
                        </Column>
                        <Column field="name" header="Nama" sortable style="width: 25%;" />
                        <Column field="email" header="Email" sortable style="width: 25%;" />
                        <Column header="Peran" style="width: 20%;">
                            <template #body="{ data }">
                                <span v-for="role in data.roles" :key="role"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                    {{ role }}
                                </span>
                            </template>
                        </Column>
                        <Column header="Dibuat" sortable style="width: 15%;">
                            <template #body="{ data }">
                                {{ formatDate(data.created_at) }}
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <div class="flex gap-1">
                                    <Button v-if="can.edit_user"
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" @click="editUser(data.id)" />
                                    <Button v-if="can.delete_user"
                                        class="p-button-danger p-button-outlined hover:bg-red-500 hover:text-white"
                                        icon="pi pi-trash" @click="confirmDelete(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Pengguna" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus pengguna
                            ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deleteUser"></Button>
                        </div>
                    </Dialog>
                </template>
                <template #footer>
                    <Pagination :links="users.links" class="mt-6" />
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

const toast = useToast();
const visible = ref(false);
const userIdToDelete = ref(null);

const props = defineProps({
    users: Object,
    can: Object,
    message: Object
});

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Pengguna' },
    { label: 'Data' },
]);

const search = ref('');

const confirmDelete = (user) => {
    userIdToDelete.value = user.id;
    visible.value = true;
};

const deleteUser = () => {
    router.delete(route('users.destroy', userIdToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'User berhasil dihapus',
                life: 3000
            });
            visible.value = false;
        },
        onError: (errors) => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors.error || 'Terjadi kesalahan saat menghapus user',
                life: 3000
            });
            console.error('Delete failed:', errors);
            visible.value = false;
        }
    });
};

const createUser = () => {
    router.get(route('users.create'));
};

const editUser = (id) => {
    router.get(route('users.edit', id));
};

const formatDate = (dateString) => {
    if (!dateString) return '';

    const [year, month, day] = dateString.split('-');

    const months = {
        '01': 'Januari',
        '02': 'Februari',
        '03': 'Maret',
        '04': 'April',
        '05': 'Mei',
        '06': 'Juni',
        '07': 'Juli',
        '08': 'Agustus',
        '09': 'September',
        '10': 'Oktober',
        '11': 'November',
        '12': 'Desember'
    };

    return `${parseInt(day)} ${months[month]} ${year}`;
};

watch(search, (query) => {
    router.get(route('users.index'), {
        search: query
    }, {
        preserveState: true
    });
});
</script>