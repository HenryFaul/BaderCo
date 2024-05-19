<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import {debounce, throttle} from 'lodash';

const props = defineProps({
    all_users:Object,
    filters: Object,
});
const permissions = computed(() => usePage().props.permissions)


const filterForm = useForm({
    searchName: props.filters.searchName ?? null,
    isActive: props.filters.isActive ?? null,
    field: props.filters.field ?? null,
    direction: props.filters.direction ?? "asc",
    show: props.filters.show ?? 10,

});

//let tableStats = ref("Showing page " + props.all_users.current_page + "  of " + props.all_users.total + " entries.");

let filter = debounce(() => {

    filterForm.get(
        route('user_detail.index'),
        {
            preserveState: true,
            preserveScroll: true,
        },
    )
},150);

let sort = (field) => {
    filterForm.field = field;
    filterForm.direction = filterForm.direction === 'asc' ? 'desc' : 'asc';
    filter();
}

watch(
    () => filterForm.searchName,
    (exampleField, prevExampleField) => {
        filter();
    }
)

watch(
    () => filterForm.show,
    (exampleField, prevExampleField) => {
        filter();
    }
)

const clear = () => {
    filterForm.searchName = null
    filterForm.isActive = null
    filter()
}


const edit = (id) => {
    router.get('all_users/'+id);
}



</script>

<template>
    <AppLayout title="User Detail">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               User Detail
            </h2>
        </template>

        <div class="py-2">

            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">Your User Detail</h2>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="inline-block min-w-full py-2 align-middle">

                        <div class="m-2 p-2">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Staff Data</h2>

                            <div class="mb-4 mt-5">
                                <input type="search" v-model.number="filterForm.searchName" aria-label="Search"
                                       placeholder="Search name or reg..."
                                       class="block w-3/12 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>

                                <div class="mt-2">

                                </div>
                                <secondary-button @click="filter" class="mt-3">Search</secondary-button>
                                <secondary-button @click="clear" class="mt-3 ml-1">Clear</secondary-button>

                            </div>
                            <div>


                                <div class="bg-white rounded-md shadow overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead class="bg-amber-300">
                                        <tr class="text-left font-bold">
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">

                                            <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('first_name')">First

                                            <svg v-if="filterForm.field === 'first_name' && filterForm.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="filterForm.field === 'first_name' && filterForm.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                            </span>

                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">Primary Type</th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">Roles</th>
                                            <th scope="col" class="w-1/12 text-xs font-semibold tracking-wider text-left text-white uppercase">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">



                                        <tr  v-for="(user, index) in all_users.data"
                                             :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100 ">


                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.name }}
                                            </td>

                                            <td class="py-4 px-6 whitespace-nowrap">
                                            {{user.user_detail.user_type.type}}
                                            </td>


                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <ul>
                                                    <li v-if="user.roles.length > 0" v-for="(role, index) in user.roles"
                                                        :key="index">
                                                        <span v-if="role.id ===1" class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{role.name}}</span>
                                                        <span v-if="role.id ===2" class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{role.name}}</span>
                                                        <span v-if="role.id ===3" class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">{{role.name}}</span>
                                                        <span v-if="role.id ===4" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{role.name}}</span>
                                                        <span v-if="role.id ===5" class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{role.name}}</span>
                                                        <span v-if="role.id ===6" class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{role.name}}</span>
                                                        <span v-if="role.id ===7" class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">{{role.name}}</span>
                                                    </li>

                                                    <li v-else>
                                                        <span  class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">None</span>
                                                    </li>

                                                </ul>

                                            </td>

                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <Link class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('user_detail.show',user.id)" >View</Link>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="ml-3 mt-2">

                                </div>
                            </div>
                            <div v-if="all_users.data.length" class="w-full flex justify-center mt-5 mb-4">



                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
