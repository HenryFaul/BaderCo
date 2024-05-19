<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import AreaInput from '@/Components/AreaInput.vue';
import {computed, inject, onBeforeMount, onMounted, onUnmounted, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DialogModal from "@/Components/DialogModal.vue";


const query = ref('')

const emit = defineEmits(['close']);

const props = defineProps({
    perspective:String,
    file_store_id: Number,
    is_approved: Boolean,
    is_client_approved:Boolean,
    file_store:Object,
    file_name:String,
    show: false,
    closeable: true,
});


const close = () => {
    emit('close');
};


onBeforeMount(async () => {

})

onUnmounted(async () => {

})

onMounted(async () => {


})

const form = useForm({
    perspective:props.perspective,
    file_store_id: props.file_store_id,
    is_approved:props.is_approved,
    is_client_approved:props.is_client_approved,
    comments:null,
});


const updateContact = () => {

    form.put(route('file_store.update', props.file_store_id), {
        preserveScroll: true,
        onSuccess: () => {
            close();
        },
        onError: (e) => {
            console.log(e);
        },
    });
};


let emptyErrors = computed(() => Object.keys(form.errors).length === 0 && form.errors.constructor === Object)
let borderClass = computed(() => !emptyErrors ? 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-red-500': form.latitude !== '' && form.latitude != null ? 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-green-300': 'ml-4 mt-4 p-4 rounded-md border-solid border-2 border-gray')


</script>


<template>
    <div>
        <dialog-modal :show="show"
                      :closeable="closeable"
                      @close="close" >

            <template #content>
                <div>

                    <div class="">

                        <form class="w-full m-3 p-3" >

                            <div :class="borderClass">

                                <div class="text-lg mb-2 text-indigo-400">{{props.perspective}}: Update File Status</div>
                                <div class="text-sm mb-2 text-gray-400">{{props.file_name}}</div>

                                <div class="mt-3">

                                    <label class="block text-sm font-medium leading-6 text-gray-900">File Status</label>

                                    <div v-if="props.perspective ==='PM'">
                                        <select v-model="form.is_approved"
                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option  :value="1">
                                                Approve
                                            </option>
                                            <option :value="0">
                                                Decline
                                            </option>
                                        </select>
                                    </div>
                                    <div v-else>
                                        <select v-model="form.is_client_approved"
                                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option  :value="1">
                                                Approve
                                            </option>
                                            <option :value="0">
                                                Decline
                                            </option>
                                        </select>
                                    </div>


                                    <InputError class="mt-2" :message="form.errors.is_approved"/>
                                </div>


                                <div class="col-span-6 mt-3">
                                    <label
                                        class="block text-sm font-medium leading-6 text-gray-900">Comments:</label>
                                    <AreaInput
                                        id="comments"
                                        :rows=6
                                        placeholder="Required comments..."
                                        v-model="form.comments"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError class="mt-2" :message="form.errors.comments"/>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>


            </template>

            <template #footer>

                <div v-if="true">
                    <SecondaryButton class="bg-green-500" @click="updateContact">
                        Update
                    </SecondaryButton>
                </div>

                <SecondaryButton class="ml-1" @click="close()">
                    Close
                </SecondaryButton>
            </template>
        </dialog-modal>
    </div>

</template>
