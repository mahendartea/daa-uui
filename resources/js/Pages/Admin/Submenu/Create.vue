<template>
    <Head>
        <title>Tambah Submenu</title>
        <meta name="description" content="Tambah Submenu Baru" />
    </Head>
    <LoggedInLayout title="Tambah Submenu">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>

        <Card class="border">
            <template #title>
                <div class="flex justify-between items-center my-5">
                    <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Tambah Submenu</h2>
                </div>
            </template>
            <template #content>
                <form @submit.prevent="submit" class="w-full flex flex-wrap justify-end text-center">
                    <div class="card grid grid-cols-2 w-full gap-10">
                        <FloatLabel class="w-full">
                            <InputText id="nama_sub" v-model="form.nama_sub" class="w-full" maxlength="50" />
                            <label for="nama_sub">Nama Submenu</label>
                            <small v-if="form.errors.nama_sub" class="p-error">{{ form.errors.nama_sub }}</small>
                        </FloatLabel>

                        <FloatLabel class="w-full">
                            <InputText id="link_sub" v-model="form.link_sub" class="w-full" />
                            <label for="link_sub">Link</label>
                            <small v-if="form.errors.link_sub" class="p-error">{{ form.errors.link_sub }}</small>
                        </FloatLabel>

                        <FloatLabel class="w-full">
                            <Dropdown id="id_main" v-model="form.id_main" :options="menus"
                                optionLabel="nama_menu" optionValue="id_main" class="w-full" />
                            <label for="id_main">Menu</label>
                            <small v-if="form.errors.id_main" class="p-error">{{ form.errors.id_main }}</small>
                        </FloatLabel>

                        <FloatLabel class="w-full hidden">
                            <InputNumber id="id_submain" v-model="form.id_submain" class="w-full" :min="1" />
                            <label for="id_submain">ID Submain (Optional)</label>
                            <small v-if="form.errors.id_submain" class="p-error">{{ form.errors.id_submain }}</small>
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
                            @click="router.get(route('submenus.index'))" />
                        <Button type="submit" severity="primary" label="Simpan" icon="pi pi-save"
                            :loading="form.processing" />
                    </div>
                </form>
            </template>
        </Card>
    </LoggedInLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router, useForm, Head } from '@inertiajs/vue3'
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'
import Breadcrumb from 'primevue/breadcrumb'
import FloatLabel from 'primevue/floatlabel'
import { Card } from 'primevue'

const props = defineProps({
    menus: {
        type: Array,
        required: true
    }
})

const home = ref({
    icon: 'pi pi-home'
})

const items = ref([
    { label: 'Submenu' },
    { label: 'Tambah' }
])

const statusOptions = [
    { label: 'Aktif', value: 'Y' },
    { label: 'Tidak Aktif', value: 'N' }
]

const form = useForm({
    nama_sub: '',
    link_sub: '',
    id_main: '',
    id_submain: null,
    urutan: 1,
    aktif: 'Y'
})

const submit = () => {
    form.post(route('submenus.store'), {
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>
