<template>

    <LoggedInLayout title="Tambah Postingan">
        <div class="card flex justify-between my-5">
            <Breadcrumb :home="home" :model="items" class="bg-gray-50 dark:bg-gray-800 w-full rounded-sm" />
        </div>


        <section class="max-w-8xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Account settings</h2>

            <Form v-slot="$form" :initialValues :resolver @submit.prevent="onFormSubmit"
                class="flex flex-col gap-4 w-full text-center">

                <div class="w-full grid grid-cols-2 gap-4 mt-5 ">
                    <InputGroup>
                        <InputGroupAddon>
                            <i class="pi pi-user"></i>
                        </InputGroupAddon>
                        <InputText v-model="text1" placeholder="Username" />
                    </InputGroup>

                    <InputGroup>
                        <InputGroupAddon>$</InputGroupAddon>
                        <InputNumber v-model="number" placeholder="Price" />
                        <InputGroupAddon>.00</InputGroupAddon>
                    </InputGroup>

                    <InputGroup>
                        <InputGroupAddon>www</InputGroupAddon>
                        <InputText v-model="text2" placeholder="Website" />
                    </InputGroup>

                    <InputGroup>
                        <InputGroupAddon>
                            <i class="pi pi-map"></i>
                        </InputGroupAddon>
                        <Select v-model="selectedCity" :options="cities" optionLabel="name" placeholder="City" />
                    </InputGroup>
                </div>
                <Button type="submit" severity="secondary" label="Submit" icon="pi pi-save" icon-class="p-w-4" />
            </Form>
        </section>


    </LoggedInLayout>

</template>

<script setup>
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';
import { ref } from 'vue';
import Breadcrumb from 'primevue/breadcrumb';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { Form } from '@primevue/forms';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import { Select } from 'primevue';
import InputNumber from 'primevue/inputnumber';

const home = ref({
    icon: 'pi pi-home'
});
const items = ref([
    { label: 'Postingan' },
    { label: 'Tambah' },
]);

const onFormSubmit = () => {
    console.log();
};

const text1 = ref(null);
const text2 = ref(null);
const number = ref(null);
const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
</script>