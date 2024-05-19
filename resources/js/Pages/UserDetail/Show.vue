<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage,Link} from "@inertiajs/vue3";
import {debounce, throttle} from 'lodash';
import SectionBorder from '@/Components/SectionBorder.vue';
import InputError from '@/Components/InputError.vue';
import AreaInput from '@/Components/AreaInput.vue';
import { EnvelopeIcon, PhoneIcon,PaperClipIcon } from '@heroicons/vue/20/solid';




const props = defineProps({
    user_detail:Object,
    all_roles: Object,
    permissions:Object,
    all_user_types:Object
});

/*
'user_id','title','user_type_id','cv_link','is_approved','last_legal_name','first_name','about_you','is_available','is_active','about'
*/

let Form = useForm({
    user_id:props.user_detail.user_detail.user_id,
    user_detail_id: props.user_detail.user_detail.id,
    user_type_id:props.user_detail.user_detail.user_type_id,
    is_approved: props.user_detail.user_detail.is_approved,
    first_name:  props.user_detail.user_detail.first_name,
    last_legal_name:  props.user_detail.user_detail.last_legal_name,
    about_you:  props.user_detail.user_detail.about_you,
    cv_link:  props.user_detail.user_detail.cv_link,
    email: props.user_detail.email,
    password:null,
    title: props.user_detail.user_detail.title,
    is_active: props.user_detail.user_detail.is_active,
    is_available: props.user_detail.user_detail.is_available,
    file_1:null

});

const editDisabled = ref(true);
const toggleEdit = () => {
    editDisabled.value = !editDisabled.value;
};

let roles_permissions = computed(() => usePage().props.roles_permissions);
const can_manage_users = computed(() => usePage().props.roles_permissions.permissions.includes("admin"));
const emptyErrors = computed(() => Object.keys(Form.errors).length === 0 && Form.errors.constructor === Object)

let roleForm = useForm({
    role_name: "ViewOnlyRole",
    user_id: props.user_detail.id ?? 1
});

const addRole = () => roleForm.post(route('roles.modify.store'), {
    preserveScroll: true,
    onSuccess: () => {

        swal('Staff member linked.');

    },
})
const deleteRole = (id, name) => {

    if (confirm("Sure you want to delete " + name + "?")) {

        roleForm.role_name = name;

        roleForm.put(route('roles.modify.destroy', {staff: id}),
            {
                preserveScroll: true,
                onSuccess: () => {
                    swal('Staff member unlinked.');
                }
            }
        );

    } else {

    }
}

const FilePreview = ref(null);
const FileName = ref(null);
const FileInput = ref(null);


const updateFilePreview = () => {
    const file = FileInput.value.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        FilePreview.value = e.target.result;
        FileName.value = file.name;
    };

    reader.readAsDataURL(file);
};

const selectNewFile = () => {
    FileInput.value.click();
};

const clearFileInput = () => {
    if (FileInput.value?.value) {
        FileInput.value.value = null;
        FileName.value.value = null;
    }
};

const UpdateUserDetail = () => {

    alert('uploading file clicked')

    if (FileInput.value) {
        Form.file_1 = FileInput.value.files[0];

        if(Form.file_1 != null){
            Form.post(route('user_detail.update.cv'), {
                errorBag: 'UploadFile',
                preserveScroll: true,
                onSuccess: () => {
                    alert('updated')
                    clearFileInput();
                },
                onError: (e) => {

                    alert('error')
                    console.log(e);
                },
            });
        }

    }
    if (true) {
        Form.post(route('user_detail.update.cv'), {
            errorBag: 'UploadFile',
            preserveScroll: true,
            onSuccess: () => {
                alert('updated')
                clearFileInput();
            },
            onError: (e) => {

                alert('error')
                console.log(e);
            },
        });
    } else {

        alert('File is empty. Select a file to upload.')
    }
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

                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">Detail / {{user_detail.name}}</h2>

                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                       <div
                                :class="!emptyErrors ?'m-2 p-2 rounded-md rounded-md shadow-sm border border-red-500':  editDisabled ? 'm-2 p-2':'m-2 p-2 rounded-md rounded-md shadow-sm border border-indigo-500' ">
                                <div class="">
                                    <form>
                                        <div class="text-lg mb-4 text-indigo-400">User details</div>
                                        <div class="space-y-12">
                                            <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                                <div>
                                                    <h2 class="text-base font-semibold leading-7 text-gray-900">Static Information</h2>
                                                    <p class="mt-1 text-sm leading-6 text-gray-600">User detail information.</p>
                                                </div>

                                                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                                    <div class="sm:col-span-3">
                                                        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                                                        <div class="mt-2">
                                                            <input v-model="Form.title" :disabled="editDisabled" type="text" name="title" id="title"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.title"/>
                                                    </div>

                                                    <div class="sm:col-span-3">
                                                        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                                                        <div class="mt-2">
                                                            <input v-model="Form.first_name" :disabled="editDisabled" type="text" name="first_name" id="first_name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.first_name"/>
                                                    </div>

                                                    <div class="sm:col-span-3">
                                                        <label for="last_legal_name" class="block text-sm font-medium leading-6 text-gray-900">Last / Legal name</label>
                                                        <div class="mt-2">
                                                            <input v-model="Form.last_legal_name" :disabled="editDisabled" type="text" name="last_legal_name" id="last_legal_name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.last_legal_name"/>
                                                    </div>


                                                    <div class="sm:col-span-3">
                                                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                                        <div class="mt-2">
                                                            <input v-model="Form.email" type="email" :disabled="editDisabled" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.email"/>
                                                    </div>


                                                    <div class="sm:col-span-3">
                                                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                                        <div class="mt-2">
                                                            <input v-model="Form.password" type="password" :disabled="editDisabled" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.password"/>
                                                    </div>

                                                    <div class="sm:col-span-3">
                                                        <label for="primary_user" class="block text-sm font-medium leading-6 text-gray-900">Primary User Type</label>
                                                        <div class="mt-2">
                                                            <select :disabled="editDisabled" id="primary_user" v-model="Form.user_type_id"
                                                                    class="input-filter-l block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                <option v-for="n in all_user_types" :key="n.id" :value="n.id">{{
                                                                        n.type
                                                                    }}
                                                                </option>
                                                            </select>

                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.user_type_id"/>
                                                    </div>


                                                    <div class="sm:col-span-2">
                                                        <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                                        <div class="mt-2">
                                                            <select :disabled="editDisabled" id="status" v-model="Form.is_active"
                                                                    class="input-filter-l block w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                <option :value=1>Active</option>
                                                                <option :value=0>Inactive</option>
                                                            </select>

                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.is_active"/>
                                                    </div>

                                                    <div class="sm:col-span-2">
                                                        <label for="availability" class="block text-sm font-medium leading-6 text-gray-900">Available</label>
                                                        <div class="mt-2">
                                                            <select :disabled="editDisabled" id="availability" v-model="Form.is_available"
                                                                    class="input-filter-l block w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                <option :value=1>Available</option>
                                                                <option :value=0>Unavailable</option>
                                                            </select>

                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.is_active"/>
                                                    </div>

                                                    <div class="sm:col-span-2">
                                                        <label for="approved" class="block text-sm font-medium leading-6 text-gray-900">Approved</label>
                                                        <div class="mt-2">
                                                            <select :disabled="editDisabled" id="approved" v-model="Form.is_approved"
                                                                    class="input-filter-l block w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                <option :value=1>Approved</option>
                                                                <option :value=0>Unapproved</option>
                                                            </select>

                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.is_approved"/>
                                                    </div>


                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium leading-6 text-gray-900">CV File</label>
                                                        <div class="mt-2">

                                                            <dl class="divide-y divide-gray-100">

                                                                <div>
                                                                    <div class="col-span-4">

                                                                        <li class="flex items-center justify-between py-2 pl-4 pr-5 text-sm leading-6">
                                                                            <div class="flex w-0 flex-1 items-center">
                                                                                <div class="ml-2 flex min-w-0 flex-1 gap-2">

                                                                    <span class="font-medium">
                                                                        <div class="col-span-4">
                                                                                <label
                                                                                    class="block text-sm font-medium leading-6 text-gray-900">Select file:</label>
                                                                                <input
                                                                                    ref="FileInput"
                                                                                    type="file"
                                                                                    class="hidden"
                                                                                    @change="updateFilePreview"
                                                                                >
                                                                                <progress v-if="Form.progress"
                                                                                          :value="Form.progress.percentage"
                                                                                          max="100">
                                                                                    {{ Form.progress.percentage }}%
                                                                                </progress>

                                                                                <div v-show="FilePreview" class="mt-2">
                                                                                    {{ FileName }}
                                                                                </div>

                                                                                <SecondaryButton :disabled="editDisabled" class="mt-2 mr-2"
                                                                                                 type="button"
                                                                                                 @click.prevent="selectNewFile">
                                                                                    Select A File
                                                                                </SecondaryButton>

                                                                            </div>
                                                                    </span>
                                                                                </div>

                                                                            </div>
                                                                        </li>


                                                                    </div>
                                                                </div>

                                                                <div v-if="Form.cv_link" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
                                                                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                                                                <div class="flex w-0 flex-1 items-center">
                                                                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                                                        <span class="truncate font-medium">CV PDF</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ml-4 flex-shrink-0">
                                                                                    <a :href='user_detail.user_detail.cv_link' target="_blank"
                                                                                       class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                                                        Download
                                                                                    </a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </dd>
                                                                </div>
                                                            </dl>


                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.about_you"/>
                                                    </div>

                                                    <div class="sm:col-span-6">
                                                        <label class="block text-sm font-medium leading-6 text-gray-900">CV Summary</label>
                                                        <div class="mt-2">

                                                            <AreaInput
                                                                :disabled="editDisabled"
                                                                id="product_notes"
                                                                v-model="Form.about_you"
                                                                :rows=4
                                                                placeholder="CV Summary..."
                                                                type="text"
                                                                class="mt-1 block w-1/3"
                                                            />

                                                        </div>
                                                        <InputError class="mt-2" :message="Form.errors.about_you"/>
                                                    </div>

                                                </div>
                                            </div>



                                        </div>

                                        <div class="mt-6 flex items-center justify-end gap-x-6">

                                            <SecondaryButton v-if="can_manage_users" class="m-1" @click="toggleEdit">
                                                Edit
                                            </SecondaryButton>

                                            <SecondaryButton v-if="!editDisabled && can_manage_users" @click="UpdateUserDetail" class="m-1">
                                                Save
                                            </SecondaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <SectionBorder/>
                        <div v-if="can_manage_users" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                            <div class="m-2 p-2">
                                <div  class="">
                                    <div class="text-lg mb-2 text-indigo-400">Roles allocated</div>

                                    <div v-if="can_manage_users">
                                        <div class="col-span-4">
                                            <label class="block text-sm font-medium leading-6 text-gray-900">Available
                                                roles:</label>
                                            <div class="">
                                                <select v-model="roleForm.role_name"
                                                        class="mt-2 block w-1/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option v-for="n in all_roles" :key="n.id" :value="n.name">{{
                                                            n.name
                                                        }}
                                                    </option>
                                                </select>


                                                <SecondaryButton v-if="can_manage_users" @click="addRole()" class="mt-2">
                                                    Link (+)
                                                </SecondaryButton>

                                            </div>

                                            <InputError class="mt-2" :message="roleForm.errors.role_name"/>
                                            <InputError class="mt-2" :message="roleForm.errors.user_id"/>

                                        </div>
                                    </div>

                                    <form class="mt-5">
                                        <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">Roles linked:</label>
                                        <div>


                                            <div class="flex">

                                                <ul class="w-2/3">

                                                    <li v-for="n in user_detail.roles" :key="n.id" :value="n.id"
                                                        class="w-full border-b-2 border-neutral-100 border-opacity-100 py-4 dark:border-opacity-50">

                                                        <div class="flex mt-1">
                                                            <div class="flex-none w-1/3">
                                                                <icon name="tick-circle" class="mr-2 w-6 h-6 fill-green-200"/>
                                                            </div>
                                                            <div class="flex-auto font-bold w-2/3">

                                                                <span v-if="n.id ===1" class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ n.name }}</span>
                                                                <span v-if="n.id ===2" class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{n.name}}</span>
                                                                <span v-if="n.id ===3" class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">{{n.name}}</span>
                                                                <span v-if="n.id ===4" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{n.name}}</span>
                                                                <span v-if="n.id ===5" class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{n.name}}</span>
                                                                <span v-if="n.id ===6" class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{n.name}}</span>
                                                                <span v-if="n.id ===7" class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">{{n.name}}</span>
                                                                <span v-if="n.id > 7" class="inline-flex items-center rounded-md bg-orange-100 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">{{n.name}}</span>
                                                            </div>
                                                            <div class="flex-auto w-1/3">
                                                                <SecondaryButton v-if="can_manage_users" @click="deleteRole(n.id, n.name)" >
                                                                    UNLINK (-)
                                                                </SecondaryButton>
                                                            </div>
                                                        </div>

                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                    </form>

                                    <form class="mt-5">
                                        <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">Permissions via Roles:</label>
                                        <div class="m-2 p-2 shadow-lg rounded-md">


                                            <span  v-for="(p,index) in permissions" :key="index" class="inline-flex ml-1 mt-1 items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">{{ p }}</span>

                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
