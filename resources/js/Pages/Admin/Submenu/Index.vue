<template>
    <Head>
        <title>Submenu Management</title>
        <meta name="description" content="Submenu Management" />
    </Head>
    <LoggedInLayout title="Submenu Management">
        <Toast class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Submenu Management</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <div class="w-72">
                        <FloatLabel variant="on">
                            <InputText id="on_label" v-model="search" class="w-full" />
                            <label for="on_label">Cari Submenu...</label>
                        </FloatLabel>
                    </div>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Submenu" type="button"
                        @click="createSubmenu" />
                </div>
            </div>
            <Card class="border">
                <template #title>Daftar Submenu</template>
                <template #content>
                    <DataTable :value="submenus" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem">
                        <Column header="No" style="width: 5%;">
                            <template #body="{ index }">
                                {{ index + 1 }}
                            </template>
                        </Column>
                        <Column field="nama_sub" header="Nama Submenu" sortable style="width: 15%;" />
                        <Column field="menu.nama_menu" header="Menu" sortable style="width: 15%;" />
                        <Column header="Link" style="width: 5%;">
                            <template #body="{ data }">
                                <a :href="data.link_sub" target="_blank"><i class="pi pi-external-link text-primary text-xl"></i></a>
                            </template>
                        </Column>
                        <Column field="urutan" header="Urutan" sortable style="width: 15%;">
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
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Link :href="route('submenus.edit', data.id_sub)" class="no-underline">
                                        <Button
                                            class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                            icon="pi pi-pencil" icon-class="p-w-4" label="Ubah" size="small" type="button" />
                                    </Link>
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                    <!-- Delete Confirmation Dialog -->
                    <Dialog v-model:visible="deleteDialog" :style="{ width: '25rem' }" header="Hapus Submenu" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">
                            Apakah anda yakin menghapus submenu ini?
                        </span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button" @click="deleteDialog = false" />
                            <Button label="Hapus" type="button" @click="deleteSubmenu" />
                        </div>
                    </Dialog>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { Link, router, Head } from '@inertiajs/vue3'
import { useToast } from "primevue/usetoast"
import { debounce } from 'lodash'
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue'
import { Card } from 'primevue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import Tag from 'primevue/tag'
import Toast from 'primevue/toast'
import Breadcrumb from 'primevue/breadcrumb'
import InputNumber from 'primevue/inputnumber'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'

const toast = useToast()
const props = defineProps({
    submenus: {
        type: Array,
        required: true
    },
    flash: {
        type: Object,
        default: () => ({})
    }
})

const home = ref({
    icon: 'pi pi-home'
})

const items = ref([
    { label: 'Submenu' }
])

const loading = ref(false)
const deleteDialog = ref(false)
const submenuToDelete = ref(null)
const search = ref('')

watch(search, (newSearch) => {
    // Implement search functionality here
})

const createSubmenu = () => {
    router.get(route('submenus.create'))
}

const editSubmenu = (id) => {
    router.get(route('submenus.edit', id))
}

const confirmDelete = (submenu) => {
    submenuToDelete.value = submenu
    deleteDialog.value = true
}

const deleteSubmenu = () => {
    router.delete(route('submenus.destroy', submenuToDelete.value.id_sub), {
        onSuccess: () => {
            deleteDialog.value = false
            submenuToDelete.value = null
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Submenu berhasil dihapus',
                life: 3000
            })
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Gagal menghapus submenu',
                life: 3000
            })
        }
    })
}

const updateOrder = debounce((submenu) => {
    router.put(route('submenus.update-order'), {
        items: [{ id_sub: submenu.id_sub, urutan: submenu.urutan }]
    }, {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Urutan berhasil diperbarui',
                life: 3000
            })
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Gagal memperbarui urutan',
                life: 3000
            })
        }
    })
}, 500)

onMounted(() => {
    if (props.flash?.message) {
        toast.add({ severity: 'success', summary: 'Success', detail: props.flash.message, life: 3000 })
    }
})
</script>
