<template>
    <LoggedInLayout title="Posts">
        <Toast />
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <div>
            <div class="flex justify-end gap-3 mb-2">
                <FloatLabel variant="on">
                    <InputText id="on_label" v-model="search" class="w-72" />
                    <label for="on_label">Cari Postingan...</label>
                </FloatLabel>
                <Button label="Tambah Postingan" icon="pi pi-plus" type="button" icon-class="p-w-4"
                    class="p-button-primary p-button-outlined hover:bg-primary-500 hover:text-white"
                    @click="createPost" />
            </div>
            <Card class="border">
                <template #title>Postingan</template>
                <template #content>
                    <DataTable :value="formattedPosts" responsiveLayout="scroll" tableStyle="min-width: 50rem"
                        size="small" stripedRows>
                        <Column field="id" header="ID" sortable style="width: 10%;" />
                        <Column field="title" header="Judul" sortable style="width: 40%;" />
                        <Column field="category" header="Kategori" sortable style="width:10%;" />
                        <Column field="updated" header="Diubah" sortable :body="formatDate" style="width: 15%;" />
                        <Column field="tag" header="Tag" />
                        <Column field="actions" header="Aksi" style="width: 13%;">
                            <template #body="{ data }">
                                <div class="grid grid-cols-2 gap-1 gap-y-2">
                                    <Button icon="pi pi-pencil" type="button" icon-class="p-w-4" size="small"
                                        class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white"
                                        @click="editPost(data)" label="Ubah" />
                                    <Button icon="pi pi-trash" icon-class="p-w-4" size="small"
                                        @click="confirmDelete(data.id)"
                                        class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                        label="hapus" />
                                    <Dialog v-model:visible="visible" header="Hapus posting"
                                        :style="{ width: '25rem' }">
                                        <span class="text-red-500 dark:text-red-400 block mb-8">Apakah anda
                                            yakin menghapus postingan ini?</span>
                                        <div class="flex justify-end gap-2">
                                            <Button type="button" label="Cancel" severity="secondary"
                                                @click="visible = false"></Button>
                                            <Button type="button" label="Hapus" @click="deletePost"></Button>
                                        </div>
                                    </Dialog>
                                    <Button icon="pi pi-eye" type="button" icon-class="p-w-4" size="small"
                                        class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white"
                                        @click="viewPost(data)" label="view" />
                                    <Button icon="pi pi-save" type="button" icon-class="p-w-4" size="small"
                                        v-if="data.draft == 1" label="Draf"
                                        class="p-button-success p-button-outlined hover:bg-primary-500 hover:text-white"
                                        @click="publishPost(data.id)" />
                                </div>
                            </template>
                        </Column>
                    </DataTable>

                </template>

                <template #footer>
                    <Pagination :currentPage="posts.current_page" :from="posts.from" :lastPage="posts.last_page"
                        :links="posts.links" :nextPageUrl="posts.next_page_url" :prevPageUrl="posts.prev_page_url"
                        :to="posts.to" :total="posts.total" />
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
import { computed, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';

const toasts = useToast();

const props = defineProps({
    posts: Object, // Ensure this is an object to match the structure of the posts data
});

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
    { label: 'Postingan' },
    { label: 'Data' },
]);

const search = ref('');

watch(search, (mencari) => {
    router.get('/admin/posts', {
        search: mencari
    }, { preserveState: true }
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
                summary: 'Success',
                life: 3000,
                detail: 'Post deleted successfully',
            });
            visible.value = false;
        },
        onError: () => {
            toasts.add({
                severity: 'error',
                summary: 'Error',
                life: 3000,
                detail: 'Failed to delete post',
            });
        },
    });
};
</script>
