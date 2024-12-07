<template>
    <Head>
        <title>Jadwal Kuliah</title>
        <meta name="description" content="Jadwal Kuliah" />
    </Head>

    <LoggedInLayout title="Jadwal Kuliah">
        <Toast position="top-right" group="br" class="z-50" />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>
        <div>
            <div class="flex justify-between gap-3 mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Jadwal Kuliah</h1>
                </div>
                <div class="flex justify-end gap-1">
                    <FloatLabel variant="on">
                        <InputText id="on_label" v-model="search" class="w-72" />
                        <label for="on_label">Cari Jadwal...</label>
                    </FloatLabel>
                    <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                        icon="pi pi-plus" icon-class="p-w-4" label="Tambah Jadwal" type="button"
                        @click="createCalendar" />
                </div>
            </div>
            <Card class="border">
                <template #title>Data Jadwal Kuliah</template>
                <template #content>
                    <DataTable :value="courseCalenders.data" :paginator="true" :rows="perPage"
                        :total-records="courseCalenders.total" :lazy="true" :rows-per-page-options="[5,10,20,50]"
                        @page="onPage($event)" responsiveLayout="scroll" size="small" stripedRows
                        tableStyle="min-width: 50rem" :loading="loading">
                        <Column header="No" style="width: 5%;">
                            <template #body="slotProps">
                                {{ slotProps.index + 1 + ((courseCalenders.current_page - 1) * perPage) }}
                            </template>
                        </Column>

                        <Column field="id_thn" header="Tahun" sortable style="width: 10%;" />
                        <Column field="semester" header="Semester" sortable style="width: 15%;" />
                        <Column field="nama" header="Nama" sortable style="width: 25%;">
                            <template #body="{ data }">
                                <div class="whitespace-pre-wrap break-words">{{ data.nama }}</div>
                            </template>
                        </Column>
                        <Column field="file" header="Berkas" style="width: 15%;">
                            <template #body="{ data }">
                                <a :href="'/storage/' + data.file" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 underline">
                                    Unduh
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
                                        @click="editCalendar(data.id_jkul)" />
                                    <Button
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        icon="pi pi-trash" icon-class="p-w-4" label="Hapus" size="small"
                                        @click="confirmDelete(data.id_jkul)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus Jadwal" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">
                            Apakah anda yakin ingin menghapus jadwal ini? Berkas yang terkait juga akan dihapus.
                        </span>
                        <div class="flex justify-end gap-2">
                            <Button label="Batal" severity="secondary" type="button"
                                @click="visible = false" :disabled="loading" />
                            <Button label="Hapus" severity="danger" type="button"
                                @click="deleteCalendar" :loading="loading" />
                        </div>
                    </Dialog>
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
import { computed, onMounted, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    courseCalenders: Object,
    message: Object
});

const toasts = useToast();

onMounted(() => {
    if (props.message) {
        toasts.add({
            severity: props.message.severity,
            summary: props.message.summary,
            detail: props.message.detail,
            life: props.message.life
        });
    }
});

const loading = ref(false);
const perPage = ref(10);
const search = ref('');

const visible = ref(false);
const calendarIdToDelete = ref(null);

const formatDate = (dateString) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', options);
};

const home = ref({
    icon: 'pi pi-home'
});

const items = ref([
    { label: 'Jadwal Kuliah' },
    { label: 'Data' },
]);

watch(search, debounce((value) => {
    router.get('/admin/course-calendar', { search: value, per_page: perPage.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
}, 300));

function debounce(fn, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
}

const onPage = (event) => {
    const page = event.page + 1;
    const perPageValue = event.rows;

    if (perPage.value !== perPageValue) {
        perPage.value = perPageValue;
    }

    router.get('/admin/course-calendar', {
        page: page,
        per_page: perPageValue,
        search: search.value
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};

const createCalendar = () => {
    router.get('/admin/course-calendar/create');
};

const editCalendar = (id) => {
    router.visit(`/admin/course-calendar/${id}/edit`);
};

const confirmDelete = (id) => {
    calendarIdToDelete.value = id;
    visible.value = true;
    toasts.removeAllGroups();
};

const deleteCalendar = () => {
    if (calendarIdToDelete.value) {
        loading.value = true;
        router.delete(`/admin/course-calendar/${calendarIdToDelete.value}`, {
            onSuccess: (page) => {
                visible.value = false;
                calendarIdToDelete.value = null;
                loading.value = false;

                toasts.add({
                    severity: 'success',
                    summary: 'Berhasil',
                    detail: 'Jadwal kuliah berhasil dihapus',
                    life: 3000
                });
            },
            onError: (errors) => {
                loading.value = false;
                toasts.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: 'Terjadi kesalahan saat menghapus jadwal',
                    life: 3000
                });
            }
        });
    }
};
</script>
