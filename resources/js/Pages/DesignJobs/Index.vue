<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";


const props = defineProps({
    all_jobs: Object,

});

const header_styler = computed(() => "sticky top-0 z-10 hidden border-b border-gray-300 bg-white bg-opacity-75 px-3 py-3.5 text-left text-sm font-bold text-gray-900 backdrop-blur backdrop-filter sm:table-cell");
const row_styler = computed(() => "whitespace-nowrap border-b bg-white px-3 py-4 text-sm text-gray-500 lg:table-cell");


</script>

<template>
    <AppLayout title="Design Jobs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Design Jobs
            </h2>
        </template>

        <div class="py-2">

            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">


                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">Your Design Jobs</h2>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full border-separate border-spacing-0">
                            <thead>
                            <tr>
                                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-white bg-opacity-75 py-3.5 pl-4
                                pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">ID</th>
                                <th scope="col" :class="header_styler">Status</th>
                                <th scope="col" :class="header_styler">PM Status</th>
                                <th scope="col" :class="header_styler">Designer Status</th>
                                <th scope="col" :class="header_styler" >Payment Type</th>
                                <th scope="col" :class="header_styler">Payment Status</th>
                                <th scope="col" :class="header_styler">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(job, jobIdx) in all_jobs" :key="all_jobs.id">
                                <td :class="['whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8whitespace-nowrap ' +
                                 'border-b bg-white px-3 py-4 text-sm text-gray-500 lg:table-cell']">{{job.id}}</td>

                                <td :class="row_styler">
                                    {{job.job_status.name}}
                                </td>

                                <td :class="row_styler">
                                    <div v-if="job.pm_id === 1"  >
                                        Unallocated
                                    </div>
                                    <div class="text-indigo-400" v-else>
                                        Allocated
                                    </div>
                                </td>

                                <td :class="row_styler">
                                    <div v-if="job.creator_id === 1"  >
                                        Unallocated
                                    </div>
                                    <div class="text-indigo-400" v-else>
                                        Allocated
                                    </div>
                                </td>

                                <td :class="row_styler">
                                    {{job.payment_type.name}}
                                </td>

                                <td :class="row_styler">
                                    {{job.payment_status.name}}
                                </td>

                                <td :class="row_styler">
                                    <Link class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('design_job.show',job.id)" >View</Link>

                                </td>


                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
