<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import SecondaryButton from "../../Components/SecondaryButton.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment Success
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="text-center m-3 p-3">
                        <h2 class="text-3xl font-bold tracking-tight text-indigo-500 sm:text-4xl">Payment Successful</h2>
                        <p class="mt-4 text-lg leading-8 text-gray-600"> Please access your project dashboard to view all your projects.</p>
                        <secondary-button class="mt-3">Dashboard</secondary-button>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
