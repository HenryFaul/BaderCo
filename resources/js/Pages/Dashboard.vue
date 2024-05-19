<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { ArrowDownIcon, ArrowUpIcon ,PlusIcon } from '@heroicons/vue/20/solid'
import { CursorArrowRaysIcon, EnvelopeOpenIcon, UsersIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    pending_jobs: Object,
    completed_jobs: Object,
    files_count: Object,
});

const stats = [
    { id: 1, name: 'Total Finished Projects', stat: '71,897', icon: UsersIcon, change: '122', changeType: 'increase' },
    { id: 2, name: 'Total Pending Projects', stat: '58.16%', icon: EnvelopeOpenIcon, change: '5.4%', changeType: 'decrease' },
    { id: 3, name: 'Total Artifacts', stat: '24.57%', icon: CursorArrowRaysIcon, change: '3.2%', changeType: 'increase' },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                   <div class="m-2 p-2">
                       <h1 class="mt-4 text-2xl font-medium text-gray-900">
                           Welcome Home {{ $page.props.auth.user.name }}
                       </h1>

                       <div class="m-2 p-2">
                           <div class="mt-6">
                               <h3 class="text-base font-semibold leading-6 text-gray-900">Your portal stats</h3>

                               <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                   <div  class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                                       <dt>
                                           <div class="absolute rounded-md bg-amber-500 p-3">

                                               <UsersIcon class="h-6 w-6 text-white"/>

                                               <!--                                               <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />-->
                                           </div>
                                           <p class="ml-16 truncate text-sm font-medium text-gray-500">Completed jobs</p>
                                       </dt>
                                       <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                           <p class="text-2xl font-semibold text-gray-900">{{ props.completed_jobs }}</p>

                                       </dd>
                                   </div>

                                   <div  class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                                       <dt>
                                           <div class="absolute rounded-md bg-amber-500 p-3">
                                               <UsersIcon class="h-6 w-6 text-white"/>

                                               <!--                                               <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />-->
                                           </div>
                                           <p class="ml-16 truncate text-sm font-medium text-gray-500">Pending Jobs</p>
                                       </dt>
                                       <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                           <p class="text-2xl font-semibold text-gray-900">{{ props.pending_jobs }}</p>

                                           <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                               <div class="text-sm">

                                               </div>
                                           </div>
                                       </dd>
                                   </div>

                                   <div  class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                                       <dt>
                                           <div class="absolute rounded-md bg-amber-500 p-3">
                                               <UsersIcon class="h-6 w-6 text-white"/>

                                               <!--                                               <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />-->
                                           </div>
                                           <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Files</p>
                                       </dt>
                                       <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                           <p class="text-2xl font-semibold text-gray-900">{{ props.files_count }}</p>
                                           <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                               <div class="text-sm">
                                               </div>
                                           </div>
                                       </dd>
                                   </div>
                               </dl>
                           </div>
                       </div>

                       <div class="mt-4">
                           <div class="text-center">
                               <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                   <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                               </svg>
                               <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
                               <div class="mt-6">

                                   <a type="button" :href="route('design_job.create')" class="inline-flex items-center rounded-md bg-amber-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">

                                       <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
                                       New Project
                                   </a>

                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
