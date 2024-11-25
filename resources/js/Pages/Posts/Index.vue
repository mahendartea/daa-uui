<template>
    <LoggedInLayout title="Posts">
        <Toast class="z-50"/>
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm"/>
        </div>
        <div>
            <div class="flex justify-end gap-3 mb-2">
                <FloatLabel variant="on">
                    <InputText id="on_label" v-model="search" class="w-72"/>
                    <label for="on_label">Cari Postingan...</label>
                </FloatLabel>
                <Button class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white" icon="pi pi-plus" icon-class="p-w-4" label="Tambah Postingan"
                        type="button"
                        @click="createPost"/>
            </div>
            <Card class="border">
                <template #title>Postingan</template>
                <template #content>
                    <DataTable :value="formattedPosts" responsiveLayout="scroll" size="small"
                               stripedRows tableStyle="min-width: 50rem">
                        <Column field="id" header="ID" sortable style="width: 10%;"/>
                        <Column field="title" header="Judul" sortable style="width: 40%;"/>
                        <Column field="category" header="Kategori" sortable style="width:10%;"/>
                        <Column :body="formatDate" field="updated" header="Diubah" sortable style="width: 15%;"/>
                        <Column field="tag" header="Tag"/>
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white" icon="pi pi-pencil" icon-class="p-w-4" label="Ubah"
                                            size="small"
                                            type="button" @click="editPost(data.id)"/>
                                    <Button class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white" icon="pi pi-trash" icon-class="p-w-4"
                                            label="Hapus"
                                            size="small"
                                            @click="confirmDelete(data.id)"/>
                                    <Button class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white" icon="pi pi-eye" icon-class="p-w-4" label="view"
                                            size="small"
                                            type="button" @click="viewPost(data)"/>
                                    <Button v-if="data.draft == 1" class="p-button-success p-button-outlined hover:bg-primary-500 hover:text-white" icon="pi pi-save" icon-class="p-w-4"
                                            label="Draf" size="small"
                                            type="button"
                                            @click="publishPost(data.id)"/>
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                    <Dialog v-model:visible="visible" :style="{ width: '25rem' }" header="Hapus posting" modal>
                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda
                            yakin menghapus postingan ini?</span>
                        <div class="flex justify-end gap-2">
                            <Button label="Cancel" severity="secondary" type="button" @click="visible = false"></Button>
                            <Button label="Hapus" type="button" @click="deletePost"></Button>
                        </div>
                    </Dialog>

                </template>

                <template #footer>
                    <Pagination :currentPage="posts.current_page" :from="posts.from" :lastPage="posts.last_page"
                                :links="posts.links" :nextPageUrl="posts.next_page_url"
                                :prevPageUrl="posts.prev_page_url"
                                :to="posts.to" :total="posts.total"/>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import {Card, Toast} from 'primevue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Pagination from '@/Components/Pagination.vue';
import {computed, onMounted, ref, watch} from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import {router} from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import {useToast} from 'primevue/usetoast';

const toast = useToast();
const props = defineProps({
    posts: Object,
    message: Object
});

const toasts = useToast();

const visible = ref(false);
const postIdToDelete = ref(null);

// Computed property to format the posts data
const formattedPosts = computed(() => {
    return props.posts.data.map(post => ({
        ...post,
        updated: formatDate(post.updated), // Format the updated date
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
    {label: 'Postingan'},
    {label: 'Data'},
]);

const search = ref('');

watch(search, (mencari) => {
    router.get('/admin/posts', {
            search: mencari
        }, {preserveState: true}
    );
});

const createPost = () => {
    router.get('/admin/posts/create');
};

const confirmDelete = (id) => {
    postIdToDelete.value = id;
    visible.value = true;
};

const deletePost = () => {
    router.delete(`/admin/posts/destroy/${postIdToDelete.value}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Postingan berhasil dihapus',
            });
            visible.value = false;
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal menghapus postingan',
            });
        },
    });
};

const publishPost = (id) => {
    router.put(`/admin/posts/publish/${id}`, {}, {
        onSuccess: () => {
            toasts.add({
                severity: 'success',
                summary: 'Berhasil',
                life: 3000,
                detail: 'Postingan berhasil dipublikasikan',
            });
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Gagal mempublikasikan postingan',
            });
        },
    });
};

const editPost = (id) => {
    router.get(`/admin/posts/edit/${id}`);
};

const viewPost = (post) => {
    router.get(`/admin/posts/show/${post.id}`);
};

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

</script>
