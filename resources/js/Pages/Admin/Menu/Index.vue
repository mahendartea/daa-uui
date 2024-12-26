<template>
    <Head>
        <title>Menu Management</title>
        <meta name="description" content="Menu Management" />
    </Head>
    <LoggedInLayout title="Menu Management">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Menu Management</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Menu...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Menu" type="button"
                        @click="createMenu" />
                </div>
            </div>
            <Card class="border">
                <template #title>Daftar Menu</template>
                <template #content>
                    <DataTable :value="menus" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 }}
                            </template>
                        </Column>
                        <Column field="nama_menu" header="Nama Menu" sortable style="width: 15%;" />
                        <Column field="link" header="Link" sortable style="width: 15%;" />
                        <Column field="urutan" header="Urutan" sortable style="width: 10%;">
                            <template #body="{ data }">
                                {{ data.urutan }}
                            </template>
                        </Column>
                        <Column field="aktif" header="Status" sortable style="width: 10%;">
                            <template #body="{ data }">
                                <Tag :severity="data.aktif === 'Y' ? 'success' : 'danger'">
                                    {{ data.aktif === 'Y' ? 'Active' : 'Inactive' }}
                                </Tag>
                            </template>
                        </Column>
                        <Column field="actions" header="Aksi" style="width: 10%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button"
                                        @click="editMenu(data.id_main)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                    <!-- Delete Confirmation Dialog -->
                    <Dialog v-model:visible="deleteDialog" :style="{ width: '25rem' }" header="Hapus Menu" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">
                            Apakah anda yakin menghapus menu ini?
                        </span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="deleteDialog = false" />
                            <Button label="Hapus" type="button" @click="deleteMenu" />
                        </div>
                    </Dialog>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router, Head } from '@inertiajs/vue3'
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue'
import { Card, Toast } from 'primevue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import InputNumber from 'primevue/inputnumber'
import Tag from 'primevue/tag'
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'
import Breadcrumb from 'primevue/breadcrumb'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import { useToast } from 'primevue/usetoast'

const props = defineProps({
    menus: {
        type: Array,
        required: true
    }
})

const toasts = useToast()
const deleteDialog = ref(false)
const menuToDelete = ref(null)
const search = ref('')

// Breadcrumb configuration
const home = ref({
    icon: 'pi pi-home'
})
const items = ref([
    { label: 'Menu' },
    { label: 'Data' }
])

const createMenu = () => {
    router.get(route('menus.create'))
}

const editMenu = (id) => {
    router.get(route('menus.edit', id))
}

const confirmDelete = (menu) => {
    menuToDelete.value = menu
    deleteDialog.value = true
}

const deleteMenu = () => {
    router.delete(route('menus.destroy', menuToDelete.value.id_main), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Menu berhasil dihapus'
            })
            deleteDialog.value = false
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal menghapus menu'
            })
        }
    })
}

const updateOrder = (menu) => {
    router.post(route('menus.update-order'), {
        items: [{
            id_main: menu.id_main,
            urutan: menu.urutan
        }]
    }, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Urutan menu berhasil diperbarui'
            })
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal memperbarui urutan menu'
            })
        }
    })
}

onMounted(() => {
    if (props.message) {
        toasts.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: 3000
        })
    }
})
</script>
