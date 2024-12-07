<script setup>
import Welcome from '@/Components/Welcome.vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import LoggedInLayout from '@/Layouts/LoggedInLayout.vue';

</script>

<template>
    <LoggedInLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg flex gap-2 justify-between px-2 py-5">
                    <Card style="width: 25rem; overflow: hidden">
                        <template #header>
                            <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
                        </template>
                        <template #title>Advanced Card</template>
                        <template #subtitle>Card subtitle</template>
                        <template #content>
                            <p class="m-0">

                            </p>
                        </template>
                        <template #footer>
                            <div class="flex gap-4 mt-1">
                                <Button label="Cancel" severity="secondary" outlined class="w-full" />
                                <Button label="Save" class="w-full" />
                            </div>
                        </template>
                    </Card>
                    <Card style="width: 25rem; overflow: hidden">
                        <template #header>
                            <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
                        </template>
                        <template #title>Advanced Card</template>
                        <template #subtitle>Card subtitle</template>
                        <template #content>
                            <p class="m-0">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur
                                error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis,
                                culpa ratione quam perferendis esse, cupiditate neque
                                quas!
                            </p>
                        </template>
                        <template #footer>
                            <div class="flex gap-4 mt-1">
                                <Button label="Cancel" severity="secondary" outlined class="w-full" />
                                <Button label="Save" class="w-full" />
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </LoggedInLayout>
</template>
