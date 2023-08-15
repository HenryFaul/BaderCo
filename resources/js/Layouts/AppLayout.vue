<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};


import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    UserIcon,
    Bars3Icon,
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
    { name: 'Team', href: '#', icon: UsersIcon, current: false },
    { name: 'Projects', href: '#', icon: FolderIcon, current: false },
    { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
    { name: 'Documents', href: '#', icon: DocumentDuplicateIcon, current: false },
    { name: 'Reports', href: '#', icon: ChartPieIcon, current: false },
]
const teams = [
    { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]

const sidebarOpen = ref(false)

</script>

<template>
    <div>
        <Head :title="title" />

        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex ml-8">
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">

                        <!-- Data Dropdown -->
                        <div class="ml-3 relative">
                            <div class="">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                            <span  class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                Demo

                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>

                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Client Demo
                                        </div>

                                        <DropdownLink :href="route('demo.client.index')">
                                            Demo
                                        </DropdownLink>


                                        <div class="border-t border-gray-100" />

                                    </template>
                                </Dropdown>
                            </div>
                        </div>


                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">

                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        </div>

                        <div>
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                            Profile
                        </ResponsiveNavLink>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <ResponsiveNavLink as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </form>

                    </div>
                </div>
            </div>
        </nav>

        <Banner />
        <div>
            <TransitionRoot as="template" :show="sidebarOpen">
                <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                    <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-900/80" />
                    </TransitionChild>

                    <div class="fixed inset-0 flex">
                        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                                <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                        <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                            <span class="sr-only">Close sidebar</span>
                                            <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                        </button>
                                    </div>
                                </TransitionChild>
                                <!-- Sidebar component, swap this element with another sidebar if you like -->
                                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                                    <div class="flex h-16 shrink-0 items-center">
                                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                                    </div>
                                    <nav class="flex flex-1 flex-col">
                                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                            <li>
                                                <ul role="list" class="-mx-2 space-y-1">
                                                    <li v-for="item in navigation" :key="item.name">
                                                        <a :href="item.href" :class="[item.current ? 'bg-gray-50 text-amber-400' : 'text-gray-700 hover:text-amber-400 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                            <component :is="item.icon" :class="[item.current ? 'text-amber-400' : 'text-gray-400 group-hover:text-amber-400', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                                            {{ item.name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                                    <li v-for="team in teams" :key="team.name">
                                                        <a :href="team.href" :class="[team.current ? 'bg-gray-50 text-amber-400' : 'text-gray-700 hover:text-amber-400 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                            <span :class="[team.current ? 'text-amber-400 border-amber-400' : 'text-gray-400 border-gray-200 group-hover:border-amber-400 group-hover:text-amber-400', 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white']">{{ team.initial }}</span>
                                                            <span class="truncate">{{ team.name }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>

            <!-- Static sidebar for desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
                    <div class="flex h-16 shrink-0 items-center">

                        <div class="shrink-0 flex items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto" />
                            </Link>
                        </div>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li v-for="item in navigation" :key="item.name">
                                        <a :href="item.href" :class="[item.current ? 'bg-gray-50 text-amber-400' : 'text-gray-700 hover:text-amber-400 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                            <component :is="item.icon" :class="[item.current ? 'text-amber-400' : 'text-gray-400 group-hover:text-amber-400', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                            {{ item.name }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                    <li v-for="team in teams" :key="team.name">
                                        <a :href="team.href" :class="[team.current ? 'bg-gray-50 text-amber-400' : 'text-gray-700 hover:text-amber-400 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                            <span :class="[team.current ? 'text-amber-400 border-amber-400' : 'text-gray-400 border-gray-200 group-hover:border-amber-400 group-hover:text-amber-400', 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white']">{{ team.initial }}</span>
                                            <span class="truncate">{{ team.name }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="-mx-6 mt-auto">
                                <a href="#" class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">

                                    <UserIcon class="h-6 w-6 fill-amber-400" aria-hidden="true" />

                                    <span class="sr-only">Your profile</span>
                                    <span class="text-amber-400" aria-hidden="true">{{$page.props.auth.user.name }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </button>
                <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">Dashboard</div>
                <a href="#">
                    <span class="sr-only">Your profile</span>
                    <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                </a>
            </div>

            <main class="py-10 lg:pl-72">

                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Your content -->
                    <slot />

                </div>
            </main>
        </div>

    </div>
</template>
