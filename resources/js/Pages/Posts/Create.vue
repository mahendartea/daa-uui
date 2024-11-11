<template>

    <LoggedInLayout title="Tambah Postingan">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Post</h2>
            <form @submit.prevent="onFormSubmit" class="w-full flex flex-wrap justify-end text-center mt-10">

                <div class="card grid grid-cols-2 w-full gap-10">
                    <FloatLabel class="w-full">
                        <InputText id="over_label1" v-model="form.title" class="w-full" />
                        <label for="over_label1">Judul Post</label>
                        <small v-if="form.errors.title" class="p-error">{{ form.errors.title }}</small>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText id="over_label2" v-model="form.seo" class="w-full" disabled="true" />
                        <label for="over_label2">Judul Seo</label>
                        <small v-if="form.errors.seo" class="p-error">{{ form.errors.seo }}</small>
                    </FloatLabel>
                    <FloatLabel class="w-full col-span-2">
                        <Editor v-model="form.content" editorStyle="height: 320px" />
                        <small v-if="form.errors.content" class="p-error" id="content">{{ form.errors.content }}</small>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select v-model="form.selectedCategory" :options="kategori" optionLabel="label"
                            placeholder="Select a Category" class="w-full" />
                        <label for="over_label3">Kategori</label>
                        <small v-if="form.errors.selectedCategory" class="p-error">{{ form.errors.selectedCategory
                            }}</small>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Chips v-model="tagsArray" separator="," class="w-full" />
                        <label for="over_label6">Tags <span class="text-xs text-gray-500">(tulis, dan pisah dengan koma
                                (,))</span></label>
                        <small v-if="form.errors.tag" class="p-error">{{ form.errors.tag }}</small>
                    </FloatLabel>
                </div>
                <Button type="button" severity="secondary" label="Draft" icon="pi pi-bookmark" icon-class="p-w-4"
                    class="mt-3 w-32" @click="onDraftSubmit" />
                <Button type="submit" severity="primary" label="Submit" icon="pi pi-save" icon-class="p-w-4"
                    class="mt-3 w-32 ml-2" />
            </form>
        </section>
    </LoggedInLayout>

</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref, computed } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { FloatLabel } from 'primevue';
import Chips from 'primevue/chips';
import Editor from 'primevue/editor';
import Select from 'primevue/select';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const home = ref({
    icon: 'pi pi-home'
});
const items = ref([
    { label: 'Postingan' },
    { label: 'Tambah' },
]);

const props = defineProps(['categories']);

const form = useForm({
    title: '',
    seo: '',
    content: '',
    selectedCategory: null,
    tag: '',
});

const kategori = ref([]);
kategori.value = props.categories.map(category => ({
    label: category.category,
    value: category.id_category
}));

watch(() => form.title, (newTitle) => {
    form.seo = newTitle.toLowerCase().replace(/ /g, '-');
});

const tagsArray = computed({
    get() {
        return form.tag.split(',').map(tag => tag.trim()).filter(tag => tag);
    },
    set(newTags) {
        form.tag = newTags.map(tag => tag.trim()).filter(tag => tag).join(',');
    }
});

const onFormSubmit = () => {
    form.post('/admin/posts/store', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Form submission failed', errors);
        }
    });
};

</script>
