<template>
    <LoggedInLayout title="Edit Menu">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <section class="max-w-8xl p-6 mx-auto bg-gray-50 rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Menu</h2>
            <form @submit.prevent="submit" class="w-full flex flex-wrap justify-end text-center mt-10">
                <div class="card grid grid-cols-2 w-full gap-10">
                    <FloatLabel class="w-full">
                        <InputText id="nama_menu" v-model="form.nama_menu" class="w-full" />
                        <label for="nama_menu">Nama Menu</label>
                        <small v-if="form.errors.nama_menu" class="p-error">{{ form.errors.nama_menu }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <InputText id="link" v-model="form.link" class="w-full" />
                        <label for="link">Link</label>
                        <small v-if="form.errors.link" class="p-error">{{ form.errors.link }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <InputNumber id="urutan" v-model="form.urutan" class="w-full" :min="1" />
                        <label for="urutan">Urutan</label>
                        <small v-if="form.errors.urutan" class="p-error">{{ form.errors.urutan }}</small>
                    </FloatLabel>

                    <FloatLabel class="w-full">
                        <Dropdown id="aktif" v-model="form.aktif" :options="statusOptions"
                            optionLabel="label" optionValue="value" class="w-full" />
                        <label for="aktif">Status</label>
                        <small v-if="form.errors.aktif" class="p-error">{{ form.errors.aktif }}</small>
                    </FloatLabel>
                </div>

                <div class="flex gap-2 mt-6">
                    <Button type="button" severity="secondary" label="Batal" icon="pi pi-times"
                        @click="router.get(route('menus.index'))" />
                    <Button type="submit" severity="primary" label="Simpan" icon="pi pi-save"
                        :loading="form.processing" />
                </div>
            </form>
        </section>
    </LoggedInLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'
import Breadcrumb from 'primevue/breadcrumb'
import { FloatLabel } from 'primevue'

const props = defineProps({
    menu: {
        type: Object,
        required: true
    }
})

const home = ref({
    icon: 'pi pi-home'
})

const items = ref([
    { label: 'Menu' },
    { label: 'Edit' }
])

const statusOptions = [
    { label: 'Aktif', value: 'Y' },
    { label: 'Tidak Aktif', value: 'N' }
]

const form = useForm({
    nama_menu: props.menu.nama_menu,
    link: props.menu.link,
    urutan: props.menu.urutan,
    aktif: props.menu.aktif
})

const submit = () => {
    form.put(route('menus.update', props.menu.id_main), {
        onSuccess: () => {
            router.get(route('menus.index'))
        }
    })
}
</script>
