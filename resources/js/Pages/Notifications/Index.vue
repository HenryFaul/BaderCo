<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import { CheckIcon, HandThumbUpIcon,HandThumbDownIcon,  UserIcon } from '@heroicons/vue/20/solid';


const props = defineProps({
    all_jobs:Object
});

const header_styler = computed(() => "sticky top-0 z-10 hidden border-b border-gray-300 bg-white bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell");
const row_styler = computed(() => "whitespace-nowrap border-b bg-white px-3 py-4 text-sm text-gray-500 lg:table-cell");


</script>

<template>
    <AppLayout title="Notifications">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Notifications
            </h2>
        </template>

        <div class="py-2">

            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">


                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">All your notifications</h2>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="inline-block min-w-full py-2 align-middle">

                        <div v-for="(jobs, eventIdx) in all_jobs" :key="eventIdx" class="m-4 p-4">
                                                       <div class="flow-root">
                                                           <div class="mb-2">
                                                               <Link class="underline text-sm text-indigo-400 underline hover:text-amber-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('design_job.show',jobs.id)" >New Job: {{jobs.id}}</Link>
                                                           </div>
                                <ul role="list" class="-mb-8">
                                    <li v-for="(event, eventIdx) in jobs.design_job_events" :key="event.id">
                                        <div class="relative pb-8">
                                            <span v-if="eventIdx !== jobs.design_job_events.length - 1" class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                                            <div class="relative flex space-x-3">
                                                <div>
                                      <span :class="['bg-blue-500', 'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white']">

                                          <HandThumbUpIcon  class="h-5 w-5 text-white" aria-hidden="true"/>
                                      </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            {{ event.event }} <a :href="event.href" class="font-medium text-gray-900">{{event.message}}</a>
                                                        </p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time :datetime="event.datetime">{{ event.created_at }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
