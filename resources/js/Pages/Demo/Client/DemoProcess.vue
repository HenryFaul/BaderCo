<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject, onMounted} from 'vue';
import AreaInput from '@/Components/AreaInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import SocialMediaBrief from '@/Components/SocialMediaBrief.vue'

import NProgress from 'nprogress'

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
})


import {CheckIcon, CurrencyDollarIcon, ExclamationTriangleIcon, PaperClipIcon} from '@heroicons/vue/24/solid';

let NiceNumber = (_number) => {
    let val = (_number / 1).toFixed(2).replace(".", ".");
    return "R " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

let stepRef = ref(1);

//complete, current, upcoming
const steps = [
    {id: 0, name: 'Choose deliverable', status: 'current'},
    {id: 1, name: 'Choose subcategory', status: 'upcoming'},
    {id: 2, name: 'Preferred style', status: 'upcoming'},
    {id: 3, name: 'Submit brief', status: 'upcoming'},
    {id: 4, name: 'Make payment', status: 'upcoming'},
];

let deliverRef = ref(1);

const deliver = [
    {id: 0, name: 'SOCIAL MEDIA', status: 0},
    {id: 1, name: 'WEBSITE DEVELOPMENT', status: 0},
    {id: 2, name: 'APP DEVELOPMENT', status: 0},
    {id: 3, name: 'COPY WRITING, DESIGN & CREATIVE CONCEPTS', status: 0},
    {id: 4, name: 'MARKETING STRATEGY & PLANNING', status: 0},
    {id: 5, name: 'CLIENT SPECIFIC JOB – TELL US WHAT YOU NEED', status: 0},
];

let deliverSubRef = ref(1);

const deliverSub = [

    {id: 0, poa:0, deliver_id:0, name: 'Community management guide', status: 0, cost:1950, description: '1 - 2 pages\nBrand language (do\'s & don’t\'s)\nBasic engagement style (emojis, filters, stickers, IG fonts do\'s & don’t\'s)\nImage & story style (image style - do\'s & don’t\'s)'},
    {id: 1,  poa:0, deliver_id:0, name: 'Community management tier 1', status: 0,cost:3120, description: 'Engagement with followers - 2 hours per week'},
    {id: 2,  poa:0, deliver_id:0, name: 'Community management tier 2', status: 0, cost:6240, description: 'Engagement with followers - 4 hours per week'},
    {id: 3, poa:0, deliver_id:0, name: 'Community management tier 3', status: 0, cost:9360, description: 'Engagement with followers - 6 hours per week'},
    {id: 4,  poa:0, deliver_id:0, name: 'Community management tier 4', status: 0, cost:12480, description: 'Engagement with followers - 8 hours per week'},
    {id: 5,  poa:0, deliver_id:0, name: 'Community management tier 5', status: 0, cost:24960, description: 'Engagement with followers - 16 hours per week'},
    {id: 5,  poa:0, deliver_id:0, name: 'Community management add on', status: 0, cost:2600, description: 'Community manager physically present at event'},
    {id: 6,  poa:0, deliver_id:1, name: 'Starter', status: 0, cost:10571, description: '3 pages, a blog, and a content management system'},
    {id: 7,  poa:0, deliver_id:1, name: 'Professional', status: 0, cost:19840,description: '5 pages, a blog, a content management system, and e-commerce capabilities'},
    {id: 8,  poa:0, deliver_id:1, name: 'Enterprise', status: 0, cost:59520, description: 'Unlimited pages, a blog, a content management system, e-commerce capabilities, and custom design'},
    {id: 9,  poa:1, deliver_id:2, name: 'Custom App Development', status:0, cost:0, description: 'Custom App development based on your requirements.'},
    {id: 10,  poa:0, deliver_id:3, name: 'Logos', status: 0, cost:3640 , description: '3 x Versions \n' + '2 x Reverts'},
    {id: 11,  poa:0, deliver_id:3, name: 'Corporate ID - basic', status: 0, cost:7280  , description: '1 x Email signature 1 x Invoice template 1 x Letterhead 1 x Business cards'},
    {id: 12,  poa:0, deliver_id:3, name: 'Corporate ID - advanced', status: 0, cost:12740  , description: '1 x Email signature \n' + '1 x Invoice template\n' + '1 x Letterhead \n' + '1 x Business cards \n' + '1 x PPT template\n' + '1 x Newsletter template'},
    {id: 13,  poa:0, deliver_id:3, name: 'Brand guideline', status: 0, cost:45500, description: 'Logo usage & treatment \n' + 'Tagline usage & treatment\n' + 'Branding holding devices \n' + 'Colours & usage\n' + 'Fonts\n' + 'Image styles\n' + 'Product shot rules\n' + 'Point of sale branding application:\n' + '- poster\n' + '- category banner\n' + '- billboard\n' + '- gazebo\n' + '- pull-up banner\n' + '- FSU\n' + '- OR 5 additional POS elements'},
    {id: 14,  poa:0, deliver_id:3, name: 'Campaign Artwork 1', status: 0, cost:1820, description: 'Social Media content: 1 x story'},
    {id: 15,  poa:0, deliver_id:3, name: 'Campaign Artwork 2', status: 0, cost:1820, description: 'Social Media content: 1 x still post'},
    {id: 16,  poa:0, deliver_id:3, name: 'Campaign Artwork 3', status: 0, cost:2730, description: 'Social Media content: 1 x carousel'},
    {id: 17,  poa:0, deliver_id:3, name: 'Powerpoint presentation 1', status: 0, cost:9100 , description: '2 concepts\n' + '20 slides (max)\n' + '2 reverts'},
    {id: 18,  poa:0, deliver_id:3, name: 'Powerpoint presentation 2', status: 0, cost:9100 , description: '2 concepts\n' + '21 - 30 slides \n' + '2 reverts'},
    {id: 19,  poa:0, deliver_id:3, name: 'Powerpoint presentation 3', status: 0, cost:18200 , description: '2 concepts\n' + '31 - 40 slides \n' + '2 reverts'},
    {id: 20,  poa:0, deliver_id:3, name: 'Booklet (design only) 1', status: 0, cost:9100 , description: '2 concepts\n' + '10 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 21,  poa:0, deliver_id:3, name: 'Booklet (design only) 2', status: 0, cost:13650 , description: '2 concepts\n' + '20 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 22,  poa:0, deliver_id:3, name: 'Booklet (design only) 3', status: 0, cost:18200 , description: '2 concepts\n' + '40 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 23,  poa:0, deliver_id:3, name: 'Menu insert (1 page)', status: 0, cost:1820 , description: '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 24,  poa:0, deliver_id:3, name: 'Flyer design (1 page)', status: 0, cost:3640 , description: '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 25,  poa:0, deliver_id:3, name: 'A1 Poster design (1 page)', status: 0, cost:2730 , description: '2 concepts\n' + '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'},
    {id: 26,  poa:0, deliver_id:3, name: 'Ad-hoc design requests', status: 0, cost:910 , description: '2 concepts\n' + ''},


];

let prefStyleRef = ref(1);

const prefStyle = [
    {id: 0, deliver_id:0, name: '1 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 1, deliver_id:0, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 2, deliver_id:1, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 3, deliver_id:1, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 4, deliver_id:2, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 5, deliver_id:2, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 6, deliver_id:3, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 7, deliver_id:3, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 8, deliver_id:4, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 9, deliver_id:4, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 10, deliver_id:5, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 11, deliver_id:5, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 12, deliver_id:6, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 13, deliver_id:6, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 14, deliver_id:7, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 15, deliver_id:7, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 16, deliver_id:8, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 17, deliver_id:8, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 18, deliver_id:9, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 19, deliver_id:9, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 20, deliver_id:10, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 21, deliver_id:10, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 22, deliver_id:11, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 23, deliver_id:11, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 24, deliver_id:12, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 25, deliver_id:12, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 26, deliver_id:13, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 27, deliver_id:13, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 28, deliver_id:14, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 29, deliver_id:14, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 30, deliver_id:15, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 7, deliver_id:15, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 31, deliver_id:16, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 32, deliver_id:16, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 33, deliver_id:17, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 34, deliver_id:17, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 35, deliver_id:18, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 36, deliver_id:18, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 37, deliver_id:19, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 38, deliver_id:19, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 39, deliver_id:20, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 40, deliver_id:20, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 41, deliver_id:21, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 42, deliver_id:21, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 43, deliver_id:22, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 44, deliver_id:22, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 45, deliver_id:23, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 46, deliver_id:23, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 47, deliver_id:24, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 48, deliver_id:24, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 49, deliver_id:25, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 50, deliver_id:25, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},

    {id: 51, deliver_id:26, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},
    {id: 52, deliver_id:26, name: '2 Portfolio A', description:'Standard Portfolio',  url:'https://digidorx.co.za/portfolio/', status: 0},



];

const filterDeliverSub= computed(() =>
    deliverSub.filter((item) => {
            return (item.deliver_id === deliverRef.value);
        }
    ));

const filterStyle= computed(() =>
    prefStyle.filter((item) => {
            return ( item.deliver_id === deliverSubRef.value);
        }
    ));

let stepOne = () => {
    stepRef.value = 1;
    steps[0].status = 'current';
    steps[1].status = 'upcoming';
    steps[2].status = 'upcoming';
    steps[3].status = 'upcoming';
    steps[4].status = 'upcoming';
    steps[5].status = 'upcoming';
}


let stepTwo = (_delId) => {
    //select deliverable
    deliverRef.value = _delId
    stepRef.value = 2;
    steps[0].status = 'complete';
    steps[1].status = 'current';
    steps[2].status = 'upcoming';
}

let stepThree = (_subId) => {
    //select sub deliverable
    stepRef.value = 3;
    deliverSubRef.value = _subId
    steps[0].status = 'complete';
    steps[1].status = 'complete';
    steps[2].status = 'current';

}

let stepFour = (_style) => {
    stepRef.value = 4;
    prefStyleRef.value = _style;
    steps[0].status = 'complete';
    steps[1].status = 'complete';
    steps[2].status = 'complete';
    steps[3].status = 'current';

}

let stepFive = async () => {

    await getPaymentForm();
    stepRef.value = 5;

}

const FilePreview = ref(null);
const FileName = ref(null);
const FileInput = ref(null);

const UploadFile = () => {

    if (FileInput.value) {
        form.file = FileInput.value.files[0];
    }
    if (form.file != null){
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
    file: null,
    test_a:"test a2"
});

const paymentCheckout = () => {
    form.post(route('payfast.checkout'),
        {
            preserveScroll: true,
            onSuccess: (data) => {
                console.log(data);
                //swal(usePage().props.jetstream.flash?.banner || '');
            },
            onError: (error) => {
                alert('Something went wrong')
                console.log(error)
            }
        }
    );
}

const notificationMethods = [
    { id: 'New', title: 'New account' },
    { id: 'Old', title: 'Take over' },
]

let sm_platforms = ref([
    { id:0, name: 'Facebook', user_name:null, password:null, type:'new' },
    { id:1, name: 'Instagram', user_name:null, password:null, type:'new' },
    { id:2, name: 'LinkedIn', user_name:null, password:null, type:'new' },
    { id:3, name: 'Steve', user_name:null, password:null, type:'new' },
    { id:3, name: 'X', user_name:null, password:null, type:'new' },
]);

let canPay = ref(false);

const showCanPay = () => {
    canPay.value = true;
};


const hideCanPay = () => {
    canPay.value = false;
};


const receiveBriefId = (_briefId) => {

    formDesignJob.design_brief_id = _briefId

    createDesignJob();
};

let formData = ref(null);

const formPayment = useForm({
    merchant_id: 1234,
    merchant_key:null,
    amount:100,
    item_name:null,
    item_description:null

});

const formDesignJob = useForm({
    design_brief_id: null,

});

const createDesignJob = () => {

    if (formDesignJob.design_brief_id != null){
        formDesignJob.post(route('design_job.store'),
            {
                preserveScroll: true,
                onSuccess: (data) => {
                    console.log(data);
                    //swal(usePage().props.jetstream.flash?.banner || '');
                },
                onError: (error) => {
                    alert('Something went wrong')
                    console.log(error)
                }
            }
        );
    }else {
        alert("Something wrong with the brief id.")
    }


}

const getPaymentForm = () => {
   let amount = deliverSub[deliverSubRef.value].cost;
    let item_name = deliverSub[deliverSubRef.value].name;
    let item_description = deliverSub[deliverSubRef.value].description;
   console.log(item_name);

    axios.post(route('payfast.form',{
        item_name: item_name,
        item_description: item_description,
        amount: amount,

    }),[

    ]).then((res) => {

        formData.value = res.data;
        formPayment.merchant_id = formData.value["MERCHANT_ID"];
        formPayment.merchant_key = formData.value["MERCHANT_KEY"];
        formPayment.amount = formData.value["AMOUNT"];
        formPayment.item_name = formData.value["ITEM_NAME"];
        formPayment.item_description = formData.value["ITEM_DESCRIPTION"];
        console.log(res.data);
        //tradeSlideProps.value = res.data;
       // form.contract_type_id = res.data["contract_types"][0];

    });

};




</script>

<template>
    <AppLayout title="Demo Client">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Demo Client Process
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div v-if="stepRef ===1">
                        <div  class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-amber-400 sm:text-4xl">Support your marketing
                                team with top freelancers.</h2>
                            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Choose a specific deliverable
                                or explain what you need and connect with a badger freelancer and project manager. </p>
                        </div>

                        <div>

                            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                                <div
                                    class="-mx-6 mt-6 mb-6 grid grid-cols-2 gap-0.5 overflow-hidden sm:mx-0 sm:rounded-2xl md:grid-cols-3">

                                    <button @click="stepTwo(del.id)" v-for="(del, index) in deliver"
                                         :key="del.id" class="bg-gray-400/5 hover:bg-amber-300 p-8 sm:p-10 text-2xl uppercase" type="button">
                                        {{del.name}}
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div v-if="stepRef ===2">

                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-amber-400 sm:text-4xl">Services</h2>
                            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Choose a specific sub category. </p>
                        </div>
                        <div>

                            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                                <div
                                    class="-mx-6 mt-6 mb-6 grid grid-cols-2 gap-0.5 overflow-hidden sm:mx-0 sm:rounded-2xl md:grid-cols-3">

                                    <button @click="stepThree(delSub.id)" v-for="(delSub, index) in filterDeliverSub"
                                            :key="delSub.id" class="bg-gray-400/5 hover:bg-amber-300 p-8 sm:p-10 text-2xl uppercase" type="button">
                                        <div class="text-2xl uppercase">{{delSub.name}}</div>
                                        <div v-if="delSub.poa ===1"  class="mt-2 text-sm">Custom Price</div>
                                        <div v-else class="mt-2 text-sm font-bold">{{NiceNumber(delSub.cost)}}</div>
                                        <div  class="mt-2 text-sm">{{delSub.description}}</div>
                                    </button>


                                </div>
                            </div>

                        </div>
                    </div>

                    <div v-if="stepRef ===3">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-amber-400 sm:text-4xl">Style.</h2>
                            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Choose preferred style.</p>
                        </div>
                        <div>

                            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                                <div
                                    class="-mx-6 mt-6 mb-6 grid grid-cols-2 gap-0.5 overflow-hidden sm:mx-0 sm:rounded-2xl md:grid-cols-3">

                                    <div  v-for="(port, index) in filterStyle"
                                            :key="port.id" class="bg-gray-400/5 hover:bg-amber-300 p-8 sm:p-10 text-2xl uppercase" type="button">
                                        <div class="text-2xl uppercase">{{port.name}}</div>
                                        <div  class="mt-2 text-sm">{{port.description}}</div>
                                        <div class="mt-10 flex items-center justify-center gap-x-6 underline">
                                            <a :href="port.url"  target="_blank" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-500">View demo <span aria-hidden="true">→</span></a>
                                        </div>

                                        <div class="mt-2 flex items-center justify-center gap-x-6">

                                            <button @click="stepFour(port.id)" class="rounded-md bg-amber-400 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400" type="button">
                                                Select Style
                                            </button>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div v-if="stepRef ===4">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-amber-400 sm:text-4xl">Requirements needed.</h2>
                            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Complete brief</p>
                        </div>

                        <div>
                            <SocialMediaBrief :passed_form="form" :sm_platforms="sm_platforms"  @can_pay="showCanPay" @can_not_pay="hideCanPay" @receive_brief="receiveBriefId" />
                        </div>



                        <div class="m-4 p-4">
                            <button v-if="canPay" @click="stepFive()" class="rounded-md bg-amber-400 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400" type="button">
                                Proceed to payment
                            </button>
                        </div>



                    </div>

                    <div v-if="stepRef ===5">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-amber-400 sm:text-4xl">Please finalise your payment.</h2>
                            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Project is awaiting payment</p>

                            <div class="flex justify-center items-center">
                                <CurrencyDollarIcon class="w-20 h-20 fill-amber-400 animate-pulse"/>
                            </div>

                            <div>



                                <form action="https://sandbox.payfast.co.za/eng/process" method="post">
                                    <input type="hidden" name="merchant_id" v-model="formPayment.merchant_id" >
                                    <input type="hidden" name="merchant_key" v-model="formPayment.merchant_key">
                                    <input type="hidden" name="amount" v-model="formPayment.amount">
                                    <input type="hidden" name="item_name" v-model="formPayment.item_name">
                                    <input type="hidden" name="item_description" v-model="formPayment.item_description">
                                    <input type="hidden" name="return_url" value="http://127.0.0.1:8000/payfast/success">
                                    <input type="hidden" name="cancel_url" value="http://127.0.0.1:8000/payfast/success">
                                    <input type="hidden" name="notify_url" value="http://127.0.0.1:8000/payfast/success">
                                    <secondary-button type="submit">Pay now (Via Payfast)</secondary-button>
                                </form>
                            </div>


                        </div>

                        <div class="m-3 p-3">
                            <div class="rounded-md bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
                                    </div>




                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Account payments</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Only user that are approved for account may use this service.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>


                </div>

                <div class="mt-4">

                    <nav aria-label="Progress">
                        <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                            <li v-for="(step, stepIdx) in steps" :key="step.name" class="relative md:flex md:flex-1">
                                <a v-if="step.status === 'complete'" :href="step.href" class="group flex w-full items-center">
                                      <span class="flex items-center px-6 py-4 text-sm font-medium">
                                        <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-amber-400 group-hover:bg-amber-400">
                                          <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                        </span>
                                        <span class="ml-4 text-sm font-medium text-gray-900">{{ step.name }}</span>
                                      </span>
                                                            </a>
                                                            <a v-else-if="step.status === 'current'" :href="step.href" class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                                                              <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-amber-400">
                                                                <span class="text-amber-400">{{ step.id }}</span>
                                                              </span>
                                                                <span class="ml-4 text-sm font-medium text-amber-400">{{ step.name }}</span>
                                                            </a>
                                                            <a v-else :href="step.href" class="group flex items-center">
                                      <span class="flex items-center px-6 py-4 text-sm font-medium">
                                        <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300 group-hover:border-gray-400">
                                          <span class="text-gray-500 group-hover:text-gray-900">{{ step.id }}</span>
                                        </span>
                                        <span class="ml-4 text-sm font-medium text-gray-500 group-hover:text-gray-900">{{ step.name }}</span>
                                      </span>
                                </a>
                                <template v-if="stepIdx !== steps.length - 1">
                                    <!-- Arrow separator for lg screens and up -->
                                    <div class="absolute right-0 top-0 hidden h-full w-5 md:block" aria-hidden="true">
                                        <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </template>
                            </li>
                        </ol>
                    </nav>

                    <SecondaryButton class="mt-2 mr-2" @click.prevent="stepOne" type="button">
                       RESTART PROCESS
                    </SecondaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
