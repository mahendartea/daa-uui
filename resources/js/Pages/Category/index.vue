<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref, onMounted, computed } from 'vue';
import { DataTable, FloatLabel } from 'primevue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Column from 'primevue/column';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Paginator from 'primevue/paginator';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Post' },
    { label: 'Kategori' },
]);

const visible = ref(false);
const selectedId = ref(null);
const toasts = useToast();

const props = defineProps({
    categories: {
        type: Object,
        default: () => []
    },
    message: Object,
    can: Object
});

const first = ref(0);
const rows = ref(10);

const currentCategories = computed(() => {
    return props.categories ? props.categories.slice(first.value, first.value + rows.value) : [];
});

const onPage = (event) => {
    first.value = event.first;
    rows.value = event.rows;
};

const createCategory = () => {
    router.get(route('categories.create'));
};

const editCategory = (id) => {
    router.get(route('categories.edit', id));
};

const confirmDelete = (id) => {
    selectedId.value = id;
    visible.value = true;
};

const deleteCategory = () => {
    router.delete(`/admin/categories/destroy/${selectedId.value}`, {
        onSuccess: () => {
            visible.value = false;
            toasts.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Kategori berhasil dihapus',
                life: 3000,
            });
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Terjadi kesalahan saat menghapus kategori',
                life: 3000,
            });
        },
    });
};

onMounted(() => {
    if (props.message) {
        console.log(props.message);
        toasts.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000,
        });
    }
});
</script>

<template>
    <LoggedInLayout title="Kategori">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Kategori</h1>
                </div>
                <div class="flex justify-end gap-1" v-if="can.create_category">
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Kategori" type="button"
                        @click="createCategory" />
                </div>
            </div>

            <Card class="border">
                <template #title>Kategori</template>
                <template #content>
                    <DataTable :value="currentCategories" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 + first }}
                            </template>
                        </Column>
                        <Column field="category" header="Kategori" sortable style="width: 40%;" />
                        <Column field="aktif" header="Status" sortable style="width: 15%;">
                            <template #body="{ data }">
                                <span
                                    :class="{ 'text-green-500': data.aktif === 'Y', 'text-red-500': data.aktif === 'N' }">
                                    {{ data.aktif === 'Y' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editCategory(data.id)" v-if="can.edit_category" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id)" v-if="can.delete_category" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Paginator :rows="rows" :first="first" :totalRecords="props.categories.length"
                        :rowsPerPageOptions="[5, 10, 20]" @page="onPage" class="mt-4" />
                </template>
            </Card>

            <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Kategori" modal>
                <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda yakin menghapus kategori
                    ini?</span>
                <div class="flex justify-end gap-2">
                    <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                    <Button label="Hapus" type="button" @click="deleteCategory"></Button>
                </div>
            </Dialog>
        </div>
    </LoggedInLayout>
</template>
