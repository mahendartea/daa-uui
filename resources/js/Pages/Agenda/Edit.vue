<template>

    <Head title="Edit Agenda" />
    <LoggedInLayout>
        <div class="container mx-auto py-6">
            <Card>
                <template #title>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <Breadcrumb :model="items" class="mb-4" home="pi pi-home" />
                            <h2 class="text-2xl font-bold">Edit Agenda</h2>
                        </div>
                    </div>
                </template>
                <template #content>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <FloatLabel class="w-full">
                                <InputText v-model="form.nama_agenda" :class="{ 'p-invalid': form.errors.nama_agenda }"
                                    class="w-full" />
                                <label :class="{ 'p-error': form.errors.nama_agenda }">Nama Agenda</label>
                            </FloatLabel>
                            <small class="p-error" v-if="form.errors.nama_agenda">{{ form.errors.nama_agenda }}</small>
                        </div>

                        <div class="flex flex-col space-y-1">
                            <label class="text-sm font-medium">Isi Agenda</label>
                            <Editor v-model="form.isi_agenda" :class="{ 'p-invalid': form.errors.isi_agenda }"
                                editorStyle="height: 250px" class="w-full" ref="editorRef">
                                <template v-slot:toolbar>
                                    <span class="ql-formats">
                                        <button class="ql-bold" aria-label="Bold"></button>
                                        <button class="ql-italic" aria-label="Italic"></button>
                                        <button class="ql-underline" aria-label="Underline"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered" aria-label="Ordered List"></button>
                                        <button class="ql-list" value="bullet" aria-label="Unordered List"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link" aria-label="Insert Link"></button>
                                        <button class="ql-image" aria-label="Insert Image"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean" aria-label="Clear Formatting"></button>
                                    </span>
                                </template>
                            </Editor>
                            <small class="p-error" v-if="form.errors.isi_agenda">{{ form.errors.isi_agenda }}</small>
                        </div>

                        <div>
                            <FloatLabel class="w-full">
                                <InputText v-model="form.tempat" :class="{ 'p-invalid': form.errors.tempat }"
                                    class="w-full" />
                                <label :class="{ 'p-error': form.errors.tempat }">Tempat</label>
                            </FloatLabel>
                            <small class="p-error" v-if="form.errors.tempat">{{ form.errors.tempat }}</small>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <FloatLabel class="w-full">
                                    <Calendar v-model="form.jdwl_agenda"
                                        :class="{ 'p-invalid': form.errors.jdwl_agenda }" dateFormat="dd/mm/yy"
                                        placeholder="Jadwal" showIcon class="w-full" />
                                    <label :class="{ 'p-error': form.errors.jdwl_agenda }">Jadwal</label>
                                </FloatLabel>
                                <small class="p-error" v-if="form.errors.jdwl_agenda">{{ form.errors.jdwl_agenda
                                    }}</small>
                            </div>
                            <div>
                                <div class="flex flex-col space-y-1">
                                    <Calendar v-model="form.jadwal_awal"
                                        :class="{ 'p-invalid': form.errors.jadwal_awal }" dateFormat="dd/mm/yy"
                                        placeholder="Mulai" showIcon class="w-full" />
                                    <small class="p-error" v-if="form.errors.jadwal_awal">{{ form.errors.jadwal_awal
                                        }}</small>
                                </div>
                            </div>
                            <div>
                                <div class="flex flex-col space-y-1">
                                    <Calendar v-model="form.jadwal_akhir"
                                        :class="{ 'p-invalid': form.errors.jadwal_akhir }" dateFormat="dd/mm/yy"
                                        placeholder="Selesai" showIcon class="w-full" />
                                    <small class="p-error" v-if="form.errors.jadwal_akhir">{{ form.errors.jadwal_akhir
                                        }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <Button label="Batal" severity="secondary" type="button" @click="cancel" />
                            <Button label="Simpan" type="submit" />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </LoggedInLayout>
</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Card } from 'primevue';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Editor from 'primevue/editor';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    agenda: Object,
    errors: Object
});

const items = [
    { label: 'Agenda', url: '/admin/agenda' },
    { label: 'Edit' },
];

const form = useForm({
    nama_agenda: props.agenda.nama_agenda,
    isi_agenda: props.agenda.isi_agenda,
    tempat: props.agenda.tempat,
    jdwl_agenda: new Date(props.agenda.jdwl_agenda),
    jadwal_awal: new Date(props.agenda.jadwal_awal),
    jadwal_akhir: new Date(props.agenda.jadwal_akhir),
});

const editorRef = ref()
watch(editorRef, (editor) => {
    if (!editor) return
    editor.renderValue = function renderValue(value) {
        if (this.quill) {
            if (value) {
                const delta = this.quill.clipboard.convert({ html: value })
                this.quill.setContents(delta, 'silent')
            } else {
                this.quill.setText('')
            }
        }
    }.bind(editor)
})

const submit = () => {
    form.put(route('agenda.update', props.agenda.id), {
        onSuccess: () => {
            // Success handling is done through flash messages
        },
    });
};

const cancel = () => {
    router.get(route('agenda.index'));
};
</script>
