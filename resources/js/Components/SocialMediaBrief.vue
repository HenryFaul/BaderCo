<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject, onMounted} from 'vue';
import AreaInput from '@/Components/AreaInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import NProgress from 'nprogress'
import {CheckIcon, CurrencyDollarIcon, ExclamationTriangleIcon, PaperClipIcon} from '@heroicons/vue/24/solid';

let timeout = null

router.on('start', () => {
    timeout = setTimeout(() => NProgress.start(), 250)
})

router.on('progress', (event) => {
    if (NProgress.isStarted() && event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9)
    }
})

router.on('finish', (event) => {
    clearTimeout(timeout)
    if (!NProgress.isStarted()) {
        return
    } else if (event.detail.visit.completed) {
        NProgress.done()
    } else if (event.detail.visit.interrupted) {
        NProgress.set(0)
    } else if (event.detail.visit.cancelled) {
        NProgress.done()
        NProgress.remove()
    }
});

let props = defineProps({
    passed_form: Object,
    sm_platforms:Object,
});


let NiceNumber = (_number) => {
    let val = (_number / 1).toFixed(2).replace(".", ".");
    return "R " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

let stepRef = ref(1);


const FilePreview = ref(null);
const FileName = ref(null);
const FileInput = ref(null);

const UploadFile = () => {

    if (FileInput.value) {
        form.file = FileInput.value.files[0];
    }
    if (form.file != null) {
        form.post(route('import.process'), {
            errorBag: 'UploadFile',
            preserveScroll: true,
            onSuccess: () => clearFileInput(),
        });
    }


};

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

const form = useForm({
    name: null,
    brand: null,
    type:'Social Media',
    sm_goals: null,
    sm_target_audience: null,
    sm_brand_rules: null,
    sm_guidelines: null,
    sm_desired_tone: null,
    sm_brand_personality: null,
    content_included: null,
    sm_post_frequency: null,
    sm_kpi: null,
    sm_reporting_frequency: null,
    sm_words_to_avoid: null,
    sm_words_to_use: null,
    sm_emoji_to_avoid: null,
    sm_emoji_to_use: null,
    sm_responsible: null,
    sm_brand_colors: null

});


const createDesignBrief= () => {

    /*form.post(route('design_brief.store'), {
        preserveScroll: true,
        onSuccess: (data) => {
           console.log(data);
            canPay();
        },
        onError: (e) => {
            console.log(e);
        },
    });*/

    axios.post(route('design_brief.store',{
        name : 'test',
        type : 'social_media'

    }),[

    ]).then((res) => {

        createdBriefId.value = res.data.id;
        console.log(res.data.id);
        sendBrief(res.data.id);
        canPay();
        //tradeSlideProps.value = res.data;
        // form.contract_type_id = res.data["contract_types"][0];

    }).catch(err => {
        console.log(err.response.data)
    });


};

const notificationMethods = [
    {id: 'New', title: 'New account'},
    {id: 'Old', title: 'Take over'},
]

const steps = ref([

    { name: 'Step 1', href: '#', status: 'current',is_current:true },
    { name: 'Step 2', href: '#', status: 'upcoming',is_current:false },
    { name: 'Step 3', href: '#', status: 'upcoming',is_current:false },

]);


const updateSmUsername = (id, user_name) => {
    //console.log(props.sm_platforms[id])
    props.sm_platforms[id].user_name = user_name
};

const updateSmPassword = (id, password) => {
    props.sm_platforms[id].password = password
};

const updateSmType = (id, type) => {
    props.sm_platforms[id].type = type
};

let canNext = ref(true);

let createdBriefId = ref(null);

const emit = defineEmits(['can_pay','can_not_pay','receive_brief']);

const sendBrief = (_id) => {
    emit('receive_brief',_id);
};

const canPay = () => {
    emit('can_pay');
};

const canNotPay = () => {
    emit('can_not_pay');
};

const nextStep = () =>{
   let index = steps.value.findIndex((step) => step.status === 'current');

   if (index < steps.value.length-1){
       steps.value[index].status = 'complete';
       steps.value[index+1].status = 'current';
   } else {
       createDesignBrief();
       canNext.value = false;
   }

}

const prevStep = () =>{
    let index = steps.value.findIndex((step) => step.status === 'current');

    if (index < steps.value.length){
        steps.value[index].status = 'upcoming';
        steps.value[index-1].status = 'current';
        canNext.value = true;
        canNotPay();
    }

}

let subStepRef = ref(1);
let isComplete = ref(false);

const test_styler = computed(() => "z-40 shadow-xl");

</script>

<template>
    <div>
        <form class="m-2 p-2">

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-6 sm:px-6">
                    <h3 class="text-base font-semibold leading-7 text-gray-900">SOCIAL MEDIA BRIEFING</h3>
                    <div>
                        <nav class="flex items-center justify-center" aria-label="Progress">
                            <p class="text-sm font-medium">Step {{ steps.findIndex((step) => step.status === 'current') + 1 }} of {{ steps.length }}</p>
                            <ol role="list" class="ml-8 flex items-center space-x-5">
                                <li v-for="step in steps" :key="step.name">
                                    <a v-if="step.status === 'complete'" :href="step.href" class="block h-2.5 w-2.5 rounded-full bg-indigo-600 hover:bg-indigo-900">
                                        <span class="sr-only">{{ step.name }}</span>
                                    </a>
                                    <a v-else-if="step.status === 'current'" :href="step.href" class="relative flex items-center justify-center" aria-current="step">
                                  <span class="absolute flex h-5 w-5 p-px" aria-hidden="true">
                                    <span class="h-full w-full rounded-full bg-indigo-200" />
                                  </span>
                                        <span class="relative block h-2.5 w-2.5 rounded-full bg-indigo-600" aria-hidden="true" />
                                        <span class="sr-only">{{ step.name }}</span>
                                    </a>
                                    <a v-else :href="step.href" class="block h-2.5 w-2.5 rounded-full bg-gray-200 hover:bg-gray-400">
                                        <span class="sr-only">{{ step.name }}</span>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
                <div class="border-t border-gray-100">
                    <dl :class="['divide-y divide-gray-100']">

                        <div v-if="steps[0].status === 'current' || steps[0].status === 'complete' " >

                            <p class="mx-auto mt-6 mb-6 max-w-xl text-lg leading-8 text-amber-400">Part A: Overview</p>
                            <div :class="['px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6']">
                                <dt class="text-sm font-medium text-gray-900">Name of the client or company</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <input v-model="form.name" type="text"
                                           class="block w-full  rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Brand</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <input v-model="form.brand" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Goals and objectives of being on social
                                    media
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <AreaInput
                                        v-model="form.sm_goals"
                                        id="sm_goals"
                                        :rows=6
                                        placeholder="Optional comments..."
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Target audience or demographics</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <AreaInput
                                        v-model="form.sm_target_audience"
                                        id="sm_target_audience"
                                        :rows=6
                                        placeholder="Optional comments..."
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Important brand rules</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <AreaInput
                                        v-model="form.sm_brand_rules"
                                        id="sm_brand_rules"
                                        :rows=6
                                        placeholder="Optional comments..."
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Guidelines for engagement</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <AreaInput
                                        v-model="form.sm_guidelines"
                                        id="sm_guidelines"
                                        :rows=6
                                        placeholder="Optional comments..."
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Desired tone or voice for social</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_desired_tone" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>

                                    <p>e.g., professional, friendly, casual</p>
                                </dd>
                            </div>
                        </div>

                        <div v-if="steps[1].status === 'current' || steps[1].status === 'complete' ">
                            <p class="mx-auto mt-6 mb-6 max-w-xl text-lg leading-8 text-amber-400">Part B: Details</p>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">5 words that describe the brand personality
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_brand_personality" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Types of content to be included</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.content_included" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>e.g., images, videos, blog posts, user-generated content</p>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Frequency of posting and desired scheduling
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_post_frequency" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Key performance indicators (KPIs) to track
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_kpi" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>e.g., engagement, reach, conversions</p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Reporting frequency and desired format</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <input v-model="form.sm_reporting_frequency" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>e.g., monthly reports</p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Words to avoid (Don'ts)</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_words_to_avoid" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>e.g., Cheap / Whazzup / Mzansi’s</p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Words to use (Do’s)</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_words_to_use" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>e.g., Ciao / Crisp / Celebrate</p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Emojis to avoid (Don’t’s)</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_emoji_to_avoid" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p></p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Emojis to use (Do’s)</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_emoji_to_use" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p></p>

                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Who is the person responsible for sign-off /
                                    approval?
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <input v-model="form.sm_responsible" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p>key decision-makers for the project</p>

                                </dd>
                            </div>
                        </div>

                        <div v-if="steps[2].status === 'current' || steps[2].status === 'complete' ">
                            <p class="mx-auto mt-6 mb-6 max-w-xl text-lg leading-8 text-amber-400">Part C: Brand</p>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Brand colours, fonts and visual style
                                    guidelines
                                </dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <input v-model="form.sm_brand_colors" type="text"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    <p></p>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Logo and brand assets</dt>
                                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <p class="ml-2">Select files</p>
                                    <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">

                                                                    <span class="font-medium ml-2">
                                                                        <div class="col-span-4">
                                                                                <label
                                                                                    class="block text-sm font-medium leading-6 text-gray-900">Select file 1:</label>

                                                                                <input
                                                                                    ref="FileInput"
                                                                                    type="file"
                                                                                    class="hidden"
                                                                                    @change="updateFilePreview"
                                                                                >

                                                                                <progress v-if="form.progress"
                                                                                          :value="form.progress.percentage"
                                                                                          max="100">
                                                                                    {{ form.progress.percentage }}%
                                                                                </progress>

                                                                                <div v-show="FilePreview" class="mt-2">
                                                                                    {{ FileName }}
                                                                                </div>

                                                                                <SecondaryButton class="mt-2 mr-2"
                                                                                                 type="button"
                                                                                                 @click.prevent="selectNewFile">
                                                                                    Select A File
                                                                                </SecondaryButton>

                                                                            </div>
                                                                    </span>
                                                </div>

                                            </div>
                                        </li>
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">

                                                                    <span class="font-medium ml-2">
                                                                        <div class="col-span-4">
                                                                                <label
                                                                                    class="block text-sm font-medium leading-6 text-gray-900">Select file 2:</label>

                                                                                <input
                                                                                    ref="FileInput"
                                                                                    type="file"
                                                                                    class="hidden"
                                                                                    @change="updateFilePreview"
                                                                                >

                                                                                <progress v-if="form.progress"
                                                                                          :value="form.progress.percentage"
                                                                                          max="100">
                                                                                    {{ form.progress.percentage }}%
                                                                                </progress>

                                                                                <div v-show="FilePreview" class="mt-2">
                                                                                    {{ FileName }}
                                                                                </div>

                                                                                <SecondaryButton class="mt-2 mr-2"
                                                                                                 type="button"
                                                                                                 @click.prevent="selectNewFile">
                                                                                    Select A File
                                                                                </SecondaryButton>

                                                                            </div>
                                                                    </span>
                                                </div>

                                            </div>
                                        </li>
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">

                                                                    <span class="font-medium ml-2">
                                                                        <div class="col-span-4">
                                                                                <label
                                                                                    class="block text-sm font-medium leading-6 text-gray-900">Select file 3:</label>

                                                                                <input
                                                                                    ref="FileInput"
                                                                                    type="file"
                                                                                    class="hidden"
                                                                                    @change="updateFilePreview"
                                                                                >

                                                                                <progress v-if="form.progress"
                                                                                          :value="form.progress.percentage"
                                                                                          max="100">
                                                                                    {{ form.progress.percentage }}%
                                                                                </progress>

                                                                                <div v-show="FilePreview" class="mt-2">
                                                                                    {{ FileName }}
                                                                                </div>

                                                                                <SecondaryButton class="mt-2 mr-2"
                                                                                                 type="button"
                                                                                                 @click.prevent="selectNewFile">
                                                                                    Select A File
                                                                                </SecondaryButton>

                                                                            </div>
                                                                    </span>
                                                </div>

                                            </div>
                                        </li>


                                    </ul>
                                    <p class="ml-2">high-resolution files if available</p>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Social Media Platforms</dt>
                                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-4  min-w-0 flex-1 gap-2">

                                                    <div class="flex-row" v-for="n in sm_platforms" :key="n.id">

                                                        <div class="font-bold mt-3 text-lg text-amber-400">{{n.name}}</div>

                                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-3">
                                                            <div class="sm:col-span-2">
                                                                <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                                                                <div class="mt-2">
                                                                    <input @change="updateSmUsername(n.id,$event.target.value)"  type="text" name="title" id="title"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                                </div>
                                                            </div>
                                                            <div class="sm:col-span-2">
                                                                <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                                                <div class="mt-2">
                                                                    <input @change="updateSmPassword(n.id,$event.target.value)"  type="text" name="first_name" id="first_name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                                </div>
                                                            </div>
                                                            <div class="sm:col-span-2">
                                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Account</label>
                                                                <div class="mt-2">
                                                                    <select @change="updateSmType(n.id,$event.target.value)"
                                                                            class="input-filter-l block w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                        <option :value=1>Take Over</option>
                                                                        <option :value=0>New</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </li>

                                    </ul>
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Additional Notes</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">

                                    <AreaInput
                                        id="comments"
                                        :rows=6
                                        placeholder="Optional notes..."
                                        type="text"
                                        class="mt-1 block w-full"
                                    />

                                    <p>Any other relevant information or special instructions (optional) </p>

                                </dd>
                            </div>

                        </div>


                    </dl>
                </div>
            </div>


            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <div class="col-span-4">

                    <SecondaryButton @click="prevStep"  class="m-1">
                       Back
                    </SecondaryButton>

                    <SecondaryButton v-if="canNext"  @click="nextStep" class="m-1">
                        Next
                    </SecondaryButton>

                </div>

            </div>
        </form>
    </div>
</template>
