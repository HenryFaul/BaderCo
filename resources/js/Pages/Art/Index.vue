<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import FileStatusModal from "@/Components/FileStatusModal.vue";
import { CheckIcon, HandThumbUpIcon,HandThumbDownIcon,  UserIcon } from '@heroicons/vue/20/solid';
import SecondaryButton from '@/Components/SecondaryButton.vue';



const props = defineProps({
    all_files: Object,

});

let viewFileStatusModal = ref(false);

const setViewFileStatusModal = () => {
    viewFileStatusModal.value = true;
};

const closeFileStatusModal = () => {
    viewFileStatusModal.value = false;
};

let showBrief = ref(false);

const toggleBrief = () => {
    showBrief.value = !showBrief.value;
};

const header_styler = computed(() => "sticky top-0 z-10 hidden border-b border-gray-300 bg-white bg-opacity-75 px-3 py-3.5 text-left text-sm font-bold text-gray-900 backdrop-blur backdrop-filter sm:table-cell");
const row_styler = computed(() => "whitespace-nowrap border-b bg-white px-3 py-4 text-sm text-gray-500 lg:table-cell");


</script>

<template>
    <AppLayout title="Art Work">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Published Art Work
            </h2>
        </template>

        <div class="py-2">

            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">


                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">Your Published Art Works</h2>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full border-separate border-spacing-0">
                            <thead>

                            <tr>
                                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-white bg-opacity-75 py-3.5 pl-4
                                pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">ID</th>
                                <th scope="col" :class="header_styler">PM</th>
                                <th scope="col" :class="header_styler">Client</th>
                                <th scope="col" :class="header_styler">Type</th>
                                <th scope="col" :class="header_styler" >File</th>
                                <th scope="col" :class="header_styler">Comments Creator</th>
                                <th scope="col" :class="header_styler">Comments PM</th>
                                <th scope="col" :class="header_styler">Comments Client</th>

                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="file in all_files" :key="file.id">

                                <div v-if="viewFileStatusModal">
                                    <file-status-modal
                                        :show="viewFileStatusModal"
                                        @close="closeFileStatusModal"
                                        :file_store_id="file.id"
                                        :file_name="file.file_name"
                                        :is_approved="file.is_approved"
                                        :is_client_approved="file.is_client_approved"
                                        :file_store:="{file}"
                                        perspective="Client"
                                    />
                                </div>


                                <td class="whitespace-nowrap py-4 pl-2 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                    <Link class="underline text-sm text-gray-600 underline hover:text-amber-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('design_job.show',file.design_job_id)" >{{file.id}}</Link>

                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                    <HandThumbUpIcon v-if="file.is_approved"  class="h-5 w-5 text-amber-400" aria-hidden="true"/>
                                    <HandThumbDownIcon v-else class="h-5 w-5 text-amber-400" aria-hidden="true" />
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                    <HandThumbUpIcon v-if="file.is_client_approved"  class="h-5 w-5 text-amber-400" aria-hidden="true"/>
                                    <HandThumbDownIcon v-else class="h-5 w-5 text-amber-400" aria-hidden="true" />
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{file.file_type.type}}</td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{file.file_name}}</td>
                                <td class=" px-3 py-2 text-sm text-gray-500">{{file.comments}}</td>
                                <td class=" px-3 py-2 text-sm text-gray-500">{{file.pm_comments}}</td>
                                <td class=" px-3 py-2 text-sm text-gray-500">{{file.client_comments}}</td>
                                <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">

                                    <div class="m-2 ">
                                        <a href='/storage/MYXgg3GxQoLBGsXlHsjSEwIvOhpcIf5P8WVtVpx3.zip' target="_blank"
                                           class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Download
                                        </a>
                                    </div>

                                </td>
                            </tr>


<!--                            <tr v-for="(job, jobIdx) in all_jobs" :key="all_jobs.id">
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


                            </tr>-->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
