<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

import { ArrowDownIcon, ArrowUpIcon ,PlusIcon } from '@heroicons/vue/20/solid'
import { CursorArrowRaysIcon, EnvelopeOpenIcon, UsersIcon } from '@heroicons/vue/24/outline'

const stats = [
    { id: 1, name: 'Total Finished Projects', stat: '71,897', icon: UsersIcon, change: '122', changeType: 'increase' },
    { id: 2, name: 'Total Pending Projects', stat: '58.16%', icon: EnvelopeOpenIcon, change: '5.4%', changeType: 'decrease' },
    { id: 3, name: 'Total Artifacts', stat: '24.57%', icon: CursorArrowRaysIcon, change: '3.2%', changeType: 'increase' },
]
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">


            <h1 class="mt-4 text-2xl font-medium text-gray-900">
                Welcome Home {{ $page.props.auth.user.name }}
            </h1>

            <div>
                <div class="mt-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Stats for last 30 days</h3>

                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div v-for="item in stats" :key="item.id" class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                            <dt>
                                <div class="absolute rounded-md bg-amber-500 p-3">
                                    <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                                </div>
                                <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                            </dt>
                            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                                <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
                                    <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
                                    <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
                                    <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
                                    {{ item.change }}
                                </p>
                                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-amber-400 hover:text-indigo-500"
                                        >View all<span class="sr-only"> {{ item.name }} stats</span></a
                                        >
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
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
                    <div class="mt-6">

                        <a type="button" :href="route('demo.client.index')" class="inline-flex items-center rounded-md bg-amber-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">

                            <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
                            New Project
                        </a>

                    </div>
                </div>
            </div>

        </div>


    </div>
</template>
