<template>
    <LoggedInLayout title="Posts">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" />
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
                        <Column field="actions" header="Aksi" style="width: 15%;">
                            <template #body="{ data }">
                                <Button icon="pi pi-pencil" type="button" icon-class="p-w-4" size="small"
                                    class="p-button-secondary p-button-outlined hover:bg-primary-500 hover:text-white mr-2"
                                    @click="editPost(data)" />
                                <Button icon="pi pi-trash" type="button" icon-class="p-w-4" size="small"
                                    class="p-button-danger p-button-outlined hover:bg-primary-500 hover:text-white"
                                    @click="deletePost(data)" />
                                <Button icon="pi pi-eye" type="button" icon-class="p-w-4" size="small"
                                    class="p-button-info p-button-outlined hover:bg-primary-500 hover:text-white ml-2"
                                    @click="viewPost(data)" />
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
import { Card } from 'primevue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Pagination from '@/Components/Pagination.vue';
import { computed, ref, watch } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    posts: Object, // Ensure this is an object to match the structure of the posts data
});

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
</script>
