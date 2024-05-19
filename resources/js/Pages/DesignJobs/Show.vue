<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch} from 'vue';
import { CheckIcon, HandThumbUpIcon,HandThumbDownIcon,  UserIcon } from '@heroicons/vue/20/solid';

import InputError from '@/Components/InputError.vue';
import AreaInput from '@/Components/AreaInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, usePage} from '@inertiajs/vue3';
import SocialMediaBrief from '@/Components/SocialMediaBrief.vue';
import FileStatusModal from "@/Components/FileStatusModal.vue";



import { EnvelopeIcon, PhoneIcon,PaperClipIcon } from '@heroicons/vue/20/solid';
import {useForm} from "@inertiajs/vue3";


let icon = ref(HandThumbUpIcon);

let deliver = [
    {id: 0, name: 'SOCIAL MEDIA', status: 0},
    {id: 1, name: 'WEBSITE DEVELOPMENT', status: 0},
    {id: 2, name: 'APP DEVELOPMENT', status: 0},
    {id: 3, name: 'COPY WRITING, DESIGN & CREATIVE CONCEPTS', status: 0},
    {id: 4, name: 'MARKETING STRATEGY & PLANNING', status: 0},
    {id: 5, name: 'CLIENT SPECIFIC JOB – TELL US WHAT YOU NEED', status: 0},
];
let deliverSub = [

    {
        id: 0,
        poa: 0,
        deliver_id: 0,
        name: 'Community management guide',
        status: 0,
        cost: 1950,
        description: '1 - 2 pages\nBrand language (do\'s & don’t\'s)\nBasic engagement style (emojis, filters, stickers, IG fonts do\'s & don’t\'s)\nImage & story style (image style - do\'s & don’t\'s)'
    },
    {
        id: 1,
        poa: 0,
        deliver_id: 0,
        name: 'Community management tier 1',
        status: 0,
        cost: 3120,
        description: 'Engagement with followers - 2 hours per week'
    },
    {
        id: 2,
        poa: 0,
        deliver_id: 0,
        name: 'Community management tier 2',
        status: 0,
        cost: 6240,
        description: 'Engagement with followers - 4 hours per week'
    },
    {
        id: 3,
        poa: 0,
        deliver_id: 0,
        name: 'Community management tier 3',
        status: 0,
        cost: 9360,
        description: 'Engagement with followers - 6 hours per week'
    },
    {
        id: 4,
        poa: 0,
        deliver_id: 0,
        name: 'Community management tier 4',
        status: 0,
        cost: 12480,
        description: 'Engagement with followers - 8 hours per week'
    },
    {
        id: 5,
        poa: 0,
        deliver_id: 0,
        name: 'Community management tier 5',
        status: 0,
        cost: 24960,
        description: 'Engagement with followers - 16 hours per week'
    },
    {
        id: 5,
        poa: 0,
        deliver_id: 0,
        name: 'Community management add on',
        status: 0,
        cost: 2600,
        description: 'Community manager physically present at event'
    },
    {
        id: 6,
        poa: 0,
        deliver_id: 1,
        name: 'Starter',
        status: 0,
        cost: 10571,
        description: '3 pages, a blog, and a content management system'
    },
    {
        id: 7,
        poa: 0,
        deliver_id: 1,
        name: 'Professional',
        status: 0,
        cost: 19840,
        description: '5 pages, a blog, a content management system, and e-commerce capabilities'
    },
    {
        id: 8,
        poa: 0,
        deliver_id: 1,
        name: 'Enterprise',
        status: 0,
        cost: 59520,
        description: 'Unlimited pages, a blog, a content management system, e-commerce capabilities, and custom design'
    },
    {
        id: 9,
        poa: 1,
        deliver_id: 2,
        name: 'Custom App Development',
        status: 0,
        cost: 10000,
        description: 'Custom App development based on your requirements.'
    },
    {
        id: 10,
        poa: 0,
        deliver_id: 3,
        name: 'Logos',
        status: 0,
        cost: 3640,
        description: '3 x Versions \n' + '2 x Reverts'
    },
    {
        id: 11,
        poa: 0,
        deliver_id: 3,
        name: 'Corporate ID - basic',
        status: 0,
        cost: 7280,
        description: '1 x Email signature 1 x Invoice template 1 x Letterhead 1 x Business cards'
    },
    {
        id: 12,
        poa: 0,
        deliver_id: 3,
        name: 'Corporate ID - advanced',
        status: 0,
        cost: 12740,
        description: '1 x Email signature \n' + '1 x Invoice template\n' + '1 x Letterhead \n' + '1 x Business cards \n' + '1 x PPT template\n' + '1 x Newsletter template'
    },
    {
        id: 13,
        poa: 0,
        deliver_id: 3,
        name: 'Brand guideline',
        status: 0,
        cost: 45500,
        description: 'Logo usage & treatment \n' + 'Tagline usage & treatment\n' + 'Branding holding devices \n' + 'Colours & usage\n' + 'Fonts\n' + 'Image styles\n' + 'Product shot rules\n' + 'Point of sale branding application:\n' + '- poster\n' + '- category banner\n' + '- billboard\n' + '- gazebo\n' + '- pull-up banner\n' + '- FSU\n' + '- OR 5 additional POS elements'
    },
    {
        id: 14,
        poa: 0,
        deliver_id: 3,
        name: 'Campaign Artwork 1',
        status: 0,
        cost: 1820,
        description: 'Social Media content: 1 x story'
    },
    {
        id: 15,
        poa: 0,
        deliver_id: 3,
        name: 'Campaign Artwork 2',
        status: 0,
        cost: 1820,
        description: 'Social Media content: 1 x still post'
    },
    {
        id: 16,
        poa: 0,
        deliver_id: 3,
        name: 'Campaign Artwork 3',
        status: 0,
        cost: 2730,
        description: 'Social Media content: 1 x carousel'
    },
    {
        id: 17,
        poa: 0,
        deliver_id: 3,
        name: 'Powerpoint presentation 1',
        status: 0,
        cost: 9100,
        description: '2 concepts\n' + '20 slides (max)\n' + '2 reverts'
    },
    {
        id: 18,
        poa: 0,
        deliver_id: 3,
        name: 'Powerpoint presentation 2',
        status: 0,
        cost: 9100,
        description: '2 concepts\n' + '21 - 30 slides \n' + '2 reverts'
    },
    {
        id: 19,
        poa: 0,
        deliver_id: 3,
        name: 'Powerpoint presentation 3',
        status: 0,
        cost: 18200,
        description: '2 concepts\n' + '31 - 40 slides \n' + '2 reverts'
    },
    {
        id: 20,
        poa: 0,
        deliver_id: 3,
        name: 'Booklet (design only) 1',
        status: 0,
        cost: 9100,
        description: '2 concepts\n' + '10 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 21,
        poa: 0,
        deliver_id: 3,
        name: 'Booklet (design only) 2',
        status: 0,
        cost: 13650,
        description: '2 concepts\n' + '20 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 22,
        poa: 0,
        deliver_id: 3,
        name: 'Booklet (design only) 3',
        status: 0,
        cost: 18200,
        description: '2 concepts\n' + '40 page (max)\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 23,
        poa: 0,
        deliver_id: 3,
        name: 'Menu insert (1 page)',
        status: 0,
        cost: 1820,
        description: '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 24,
        poa: 0,
        deliver_id: 3,
        name: 'Flyer design (1 page)',
        status: 0,
        cost: 3640,
        description: '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 25,
        poa: 0,
        deliver_id: 3,
        name: 'A1 Poster design (1 page)',
        status: 0,
        cost: 2730,
        description: '2 concepts\n' + '2 concepts\n' + '1 page\n' + '2 design reverts\n' + '2 editorial reverts'
    },
    {
        id: 26,
        poa: 0,
        deliver_id: 3,
        name: 'Ad-hoc design requests',
        status: 0,
        cost: 910,
        description: '2 concepts\n' + ''
    },


];
let prefStyle = [
    {
        id: 0,
        deliver_id: 0,
        name: '1 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 1,
        deliver_id: 0,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 2,
        deliver_id: 1,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 3,
        deliver_id: 1,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 4,
        deliver_id: 2,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 5,
        deliver_id: 2,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 6,
        deliver_id: 3,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 7,
        deliver_id: 3,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 8,
        deliver_id: 4,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 9,
        deliver_id: 4,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 10,
        deliver_id: 5,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 11,
        deliver_id: 5,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 12,
        deliver_id: 6,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 13,
        deliver_id: 6,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 14,
        deliver_id: 7,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 15,
        deliver_id: 7,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 16,
        deliver_id: 8,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 17,
        deliver_id: 8,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 18,
        deliver_id: 9,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 19,
        deliver_id: 9,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 20,
        deliver_id: 10,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 21,
        deliver_id: 10,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 22,
        deliver_id: 11,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 23,
        deliver_id: 11,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 24,
        deliver_id: 12,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 25,
        deliver_id: 12,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 26,
        deliver_id: 13,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 27,
        deliver_id: 13,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 28,
        deliver_id: 14,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 29,
        deliver_id: 14,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 30,
        deliver_id: 15,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 7,
        deliver_id: 15,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 31,
        deliver_id: 16,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 32,
        deliver_id: 16,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 33,
        deliver_id: 17,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 34,
        deliver_id: 17,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 35,
        deliver_id: 18,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 36,
        deliver_id: 18,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 37,
        deliver_id: 19,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 38,
        deliver_id: 19,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 39,
        deliver_id: 20,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 40,
        deliver_id: 20,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 41,
        deliver_id: 21,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 42,
        deliver_id: 21,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 43,
        deliver_id: 22,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 44,
        deliver_id: 22,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 45,
        deliver_id: 23,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 46,
        deliver_id: 23,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 47,
        deliver_id: 24,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 48,
        deliver_id: 24,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 49,
        deliver_id: 25,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 50,
        deliver_id: 25,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },

    {
        id: 51,
        deliver_id: 26,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },
    {
        id: 52,
        deliver_id: 26,
        name: '2 Portfolio A',
        description: 'Standard Portfolio',
        url: 'https://digidorx.co.za/portfolio/',
        status: 0
    },


];

const props = defineProps({
    designJob: Object,
    all_design_job_statuses:Object,
    all_users:Object,
    all_events:Object,
    status_array:Object,
    all_file_types:Object,
    all_files:Object,
    all_payment_statuses:Object

});

let filterDeliver = computed(() =>
    deliver.filter((item) => {
            return (item.id === props.designJob.del_id)
        }
    ));


let filterSubDeliver = computed(() =>
    deliverSub.filter((item) => {
            return (item.id === props.designJob.del_sub_id)
        }
    ));

const approved_all_files = computed(() =>
    props.all_files.filter((file) => {
            return (file.is_approved === 1);
        }
    ));

const pm_all_design_job_statuses = computed(() =>
    props.all_design_job_statuses.filter((status) => {
            return (status.id === 6 || status.id ===7 || status.id ===8);
        }
    ));

const client_all_design_job_statuses = computed(() =>
    props.all_design_job_statuses.filter((status) => {
            return (status.id === 9 || status.id ===10 || status.id ===11);
        }
    ));

const statusForm = useForm({
    design_job_status_id: props.designJob.design_job_status_id,
    design_job_id:props.designJob.id,
    comments:null
});

const paymentForm = useForm({
    payment_status_id: props.designJob.payment_status_id,
    design_job_id:props.designJob.id,
    comments:null
});


const pmForm = useForm({
    pm_user_id: props.designJob.pm_id
});

const creatorForm = useForm({
    creator_user_id:  props.designJob.creator_id
});


const updateCreator = () => {
    creatorForm.put(route('user_assign.creator', props.designJob.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                alert('updated');
            },
        }
    );
}

const updatePm = () => {
    pmForm.put(route('user_assign.pm', props.designJob.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                alert('updated');
            },
        }
    );
}

const uploadForm = useForm({
    design_job_id:props.designJob.id,
    file_1: null,
    file_type_id:1,
    comments:null
});


const download_url = ref("storage/V2rY1iVkNkRTkHIOkijtvOBEz6UzsJWIcxzl6Uve.png");

const downLoadForm = useForm({
    file_name: "V2rY1iVkNkRTkHIOkijtvOBEz6UzsJWIcxzl6Uve.png",
});

const downloadFile= () => {
    downLoadForm.get(route('file_store.download',1),
        {
            preserveScroll: true,
            onSuccess: () => {
                alert('updated');
            },
        }
    );
}

async function download() {
    try {
        const response = await router.get(route('file_store.download2', 'YwlJhCbyewo09V5kslIjuWHcsxFGFopoowIsTV5D.png'));

        console.log(response);


        // If you want to handle file download, you can use libraries like FileSaver.js
        // For example:
        // import { saveAs } from 'file-saver';
        // saveAs(new Blob([response.data]), 'your-filename.ext');
    } catch (error) {
        console.error('Error downloading file:', error);
    }
}


const header_styler = computed(() => "sticky top-0 z-10 hidden border-b border-gray-300 bg-white bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell");
const row_styler = computed(() => "whitespace-nowrap border-b bg-white px-3 py-4 text-sm text-gray-500 lg:table-cell");

let statusCalc = (id,status_id) => {

    return id < status_id ? 'complete' : id === status_id ? 'current' : 'upcoming';

};

let steps = ref([
    { id: '01', name: 'Created', href: '#', status: statusCalc(1,props.designJob.design_job_status_id) },
    { id: '02', name: 'Cancelled', href: '#', status: statusCalc(2,props.designJob.design_job_status_id)  },
    { id: '03', name: 'Allocated', href: '#', status: statusCalc(3,props.designJob.design_job_status_id) },
    { id: '04', name: 'Pending', href: '#', status: statusCalc(4,props.designJob.design_job_status_id)  },
    { id: '05', name: 'Final', href: '#', status: statusCalc(5,props.designJob.design_job_status_id)  },
    { id: '06', name: 'Closed', href: '#', status: statusCalc(6,props.designJob.design_job_status_id)  },
]);


/*
   •	Created
   •	Cancelled
   •	Allocated
   •	Design-pending
   •	Creator-submit-design
   •	PM-review-design
   •	PM-request-design-change
   •	PM-accept-design
   •	Client-review-design
   •	Client-request-design-change
   •	Client-accept-design
   •	Release-final-design-client
   •	Closed
   */



const updateStatus = () => {
    if (confirm("Sure you want to update?")) {
        statusForm.put(route('design_job_status.update', props.designJob.id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    alert('updated')
                    statusForm.comments=null;
                },
                onError: (e) => {
                    console.log(e);
                },
            }
        );
        close();
    }
};

const updatePayment = () => {
    if (confirm("Sure you want to update?")) {
        paymentForm.put(route('design_job_payment.update', props.designJob.id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    alert('updated')
                },
                onError: (e) => {
                    console.log(e);
                },
            }
        );
        close();
    }
};


const people = [
    { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
    // More people...
]

const FilePreview = ref(null);
const FileName = ref(null);
const FileInput = ref(null);

const UploadFile = () => {

    alert('uploading file clicked')

    if (FileInput.value) {
        uploadForm.file_1 = FileInput.value.files[0];
    }
    if (uploadForm.file_1 != null) {
        uploadForm.post(route('file_store.store'), {
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
    test_a: "test a2"
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

let roles_permissions = computed(() => usePage().props.roles_permissions);

let is_admin = computed(() => usePage().props.roles_permissions.permissions.includes("admin"));
let is_creator = computed(() => usePage().props.roles_permissions.permissions.includes("creator"));
let is_client = computed(() => usePage().props.roles_permissions.permissions.includes("client"));
let is_pm = computed(() => usePage().props.roles_permissions.permissions.includes("project_manager"));




</script>

<template>
    <AppLayout title="Design Jobs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Design Jobs
            </h2>
        </template>

        <div class="py-2">

            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h2 class="text-2xl mb-2 font-bold leading-7 text-amber-400 sm:truncate sm:text-3xl sm:tracking-tight">Design Job / {{designJob.id}}</h2>

                <nav aria-label="Progress">
                    <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                        <li v-for="(step, stepIdx) in status_array" :key="step.name" class="relative md:flex md:flex-1">
                            <a v-if="step.status === 'complete'" :href="step.href" class="group flex w-full items-center">
                              <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800">
                                  <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">{{ step.name }}</span>
                              </span>
                                                </a>
                                                <a v-else-if="step.status === 'current'" :href="step.href" class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                              <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                <span class="text-indigo-600">{{ step.id }}</span>
                              </span>
                                                    <span class="ml-4 text-sm font-medium text-indigo-600">{{ step.name }}</span>
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

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="space-y-12 m-2 p-2">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Design Brief</h2>
                                <div class="mt-2">
                                    <secondary-button @click="toggleBrief">Show/Hide</secondary-button>
                                </div>

                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">

                                <div v class="sm:col-span-6">

                                    <div>
                                        <div class="px-4 sm:px-0">
                                            <h3 class="text-base font-semibold leading-7 text-gray-900">Original Design Brief</h3>
                                            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Details of the Design Brief.</p>
                                        </div>
                                        <div v-if="showBrief" class="mt-6 border-t border-gray-100">

                                            <dl class="divide-y divide-gray-100">


                                                <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Delivery</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{filterDeliver[0].name}}</dd>
                                                </div>

                                                <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Delivery sub</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{filterSubDeliver[0].name}}</dd>
                                                </div>

                                                <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.client_name}}</dd>
                                                </div>
                                                <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Type</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.type}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.brand" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Brand</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.brand}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.goals" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Goals</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.goals}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.target_audience" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Target</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.target_audience}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.brand_rules" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Rules</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.brand_rules}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.guidelines_of_engagement" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Guidelines</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.guidelines_of_engagement}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.desired_tone_of_voice" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Desired tone</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.desired_tone_of_voice}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.brand_personality_desc" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Brand personality</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.brand_personality_desc}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.type_of_content" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Type of content</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.type_of_content}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.posting_frequency" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Posting frequency</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.posting_frequency}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.kpi" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">KPI</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.kpi}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.reporting_frequency" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Reporting Frequency</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.reporting_frequency}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.words_to_avoid" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Words to avoid</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.words_to_avoid}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.words_to_use" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Words to use</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.words_to_use}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.emoji_to_avoid" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Emoji to avoid</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.emoji_to_avoid}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.emoji_to_use" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Emoji to use</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.emoji_to_use}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.person_to_sign_off" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Person to sign off</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.person_to_sign_off}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.brand_colours" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Brand colours</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.brand_colours}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.sm_platforms" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">SM Platforms</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.sm_platforms}}</dd>
                                                </div>

                                                <div v-if="designJob.design_brief.additional_notes" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Additional notes</dt>
                                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{designJob.design_brief.additional_notes}}</dd>
                                                </div>
                                                <div v-if="designJob.design_brief.file_public_url" class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
                                                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                                                <div class="flex w-0 flex-1 items-center">
                                                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                                        <span class="truncate font-medium">{{designJob.design_brief.file_name}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-4 flex-shrink-0">
                                                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                        <div class="text-sm leading-6 text-gray-500" v-else>hidden...</div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div v-if="is_admin" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Update Status (Admin)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Update Design Job Status</p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">

                                <div class="sm:col-span-3">
                                    <label  class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                    <div class="mt-2">
                                        <select v-model="statusForm.design_job_status_id"
                                                class="mt-2 block w-2/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option v-for="n in all_design_job_statuses" :key="n.id" :value="n.id">{{
                                                    n.name
                                                }}
                                            </option>
                                        </select>
<!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="status_comment2" class="block text-sm font-medium leading-6 text-gray-900">Comments</label>
                                    <AreaInput
                                        v-model="statusForm.comments"
                                        aria-required="true"
                                        id="status_comment2"
                                        :rows=6
                                        placeholder="Required comments..."
                                        type="text"
                                        class="mt-1 block w-full"

                                    />
                                    <InputError class="mt-2" :message="statusForm.errors.comments"/>



                                </div>

                                <div class="mt-2 flex items-center justify-end gap-x-6">

                                    <SecondaryButton @click="updateStatus"  class="m-1">
                                        Update
                                    </SecondaryButton>
                                </div>


                            </div>
                        </div>

                        <div v-if="is_admin" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Update Payment Status (Admin)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Update The overall payment status</p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">

                                <div class="sm:col-span-3">
                                    <label  class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                    <div class="mt-2">
                                        <select v-model="paymentForm.payment_status_id"
                                                class="mt-2 block w-2/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option v-for="n in all_payment_statuses" :key="n.id" :value="n.id">{{
                                                    n.name
                                                }}
                                            </option>
                                        </select>
                                        <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                    </div>
                                    <SecondaryButton @click="updatePayment"  class="mt-2">
                                        Update
                                    </SecondaryButton>
                                </div>


                            </div>
                        </div>

                        <div v-if="is_admin" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Assign Users (Admin)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Assign project manager and designer</p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">


                                <div class="sm:col-span-3">
                                    <label  class="block text-sm font-medium leading-6 text-gray-900">Project Manager</label>
                                    <div class="mt-2">
                                        <select v-model="pmForm.pm_user_id"
                                                class="mt-2 block w-3/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option v-for="n in all_users" :key="n.id" :value="n.id">{{
                                                    n.name
                                                }} ({{n.email}})
                                            </option>
                                        </select>
                                        <SecondaryButton @click="updatePm"  class="mt-2">
                                            Update
                                        </SecondaryButton>
                                        <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label  class="block text-sm font-medium leading-6 text-gray-900">Creator</label>
                                    <div class="mt-2">
                                        <select v-model="creatorForm.creator_user_id"
                                                class="mt-2 block w-3/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option v-for="n in all_users" :key="n.id" :value="n.id">{{
                                                    n.name
                                                }} ({{n.email}})
                                            </option>
                                        </select>
                                        <SecondaryButton @click="updateCreator"  class="mt-2">
                                            Update
                                        </SecondaryButton>
                                        <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div v-if="is_creator" class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Creator upload (Creator)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Upload Design files</p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">


                                <div class="sm:col-span-3">
                                    <label  class="block text-sm font-medium leading-6 text-gray-900">File type</label>
                                    <div class="mt-2">
                                        <select v-model="uploadForm.file_type_id"
                                                class="mt-2 block w-2/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option v-for="n in all_file_types" :key="n.id" :value="n.id">{{
                                                    n.type
                                                }}
                                            </option>
                                        </select>
                                        <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                    </div>
                                </div>

                                <div class="col-span-4">

                                                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-2 flex min-w-0 flex-1 gap-2">

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

                                                                                <progress v-if="uploadForm.progress"
                                                                                          :value="uploadForm.progress.percentage"
                                                                                          max="100">
                                                                                    {{ uploadForm.progress.percentage }}%
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

<!--                                    <label
                                        class="block text-sm font-medium leading-6 text-gray-900">Select file 1:</label>

                                    <input id="upload_file_1" type="file" @input="uploadForm.file_1 = $event.target.files[0]" />
                                    <progress v-if="uploadForm.progress" :value="uploadForm.progress.percentage" max="100">
                                        {{ uploadForm.progress.percentage }}%
                                    </progress>-->


                                </div>

                                <div class="sm:col-span-6">
                                    <label for="upload_comment" class="block text-sm font-medium leading-6 text-gray-900">Comments</label>
                                    <AreaInput
                                        v-model="uploadForm.comments"
                                        aria-required="true"
                                        id="upload_comment"
                                        :rows=6
                                        placeholder="Required comments..."
                                        type="text"
                                        class="mt-1 block w-full"

                                    />


                                </div>


                                <div class="mt-2 flex items-center justify-end gap-x-6">

                                    <SecondaryButton @click="UploadFile" class="m-1">
                                        Update
                                    </SecondaryButton>
                                </div>


                            </div>
                        </div>

                        <div v-if="is_pm" class=" border-b border-gray-900/10 pb-12 ">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Project Manager review (PM)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Review design files</p>
                            </div>

                            <div class="mt-4">

                                <div class="sm:col-span-9">

                                    <div class="px-4 sm:px-6 lg:px-8">
                                        <div class="sm:flex sm:items-center">
                                            <div class="sm:flex-auto">
                                                <h1 class="text-base font-semibold leading-6 text-gray-900">Files</h1>
                                                <p class="mt-2 text-sm text-gray-700">A list of all files submitted by the creator.</p>
                                            </div>
                                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                            </div>
                                        </div>
                                        <div class="mt-8 flow-root">
                                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="inline-block min-w-full py-2 align-middle">
                                                    <table class="min-w-full divide-y divide-gray-300">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">ID</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">PM</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Client</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">File</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments Creator</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments PM</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments Client</th>
                                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                                                <span class="sr-only">Edit</span>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-200 bg-white">

                                                        <tr v-for="file in all_files" :key="file.id">

                                                            <div v-if="viewFileStatusModal">
                                                                <file-status-modal
                                                                    :show="viewFileStatusModal"
                                                                    @close="closeFileStatusModal"
                                                                    perspective='PM'
                                                                    :is_client_approved="file.is_client_approved"
                                                                    :file_store_id="file.id"
                                                                    :file_name="file.file_name"
                                                                    :is_approved="file.is_approved"
                                                                    :file_store:="{file}"
                                                                />
                                                            </div>


                                                            <td class="whitespace-nowrap py-4 pl-2 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{file.id}}</td>
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

                                                                <SecondaryButton class="m-2 " @click="setViewFileStatusModal">
                                                                    Update
                                                                </SecondaryButton>

                                                                <div class="m-2 ">
                                                                    <a href='/storage/MYXgg3GxQoLBGsXlHsjSEwIvOhpcIf5P8WVtVpx3.zip' target="_blank"
                                                                       class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                                        Download
                                                                    </a>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-6">

                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                                <div class="text-sm">To allow client to see the approved files please update the status.</div>
                                                <div class="mt-2">
                                                    <select v-model="statusForm.design_job_status_id"
                                                            class="mt-2 block w-2/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option v-for="n in pm_all_design_job_statuses" :key="n.id" :value="n.id">{{
                                                                n.name
                                                            }}
                                                        </option>
                                                    </select>
                                                    <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                                </div>
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="status_comment3" class="block text-sm font-medium leading-6 text-gray-900">Comments</label>
                                                <AreaInput
                                                    v-model="statusForm.comments"
                                                    aria-required="true"
                                                    id="status_comment3"
                                                    :rows=6
                                                    placeholder="Required comments..."
                                                    type="text"
                                                    class="mt-1 block w-full"

                                                />
                                                <InputError class="mt-2" :message="statusForm.errors.comments"/>



                                            </div>

                                            <div class="mt-2 flex items-center justify-end gap-x-6">

                                                <SecondaryButton @click="updateStatus"  class="m-1">
                                                    Update
                                                </SecondaryButton>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div v-if="is_client" class=" border-b border-gray-900/10 pb-12 ">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Client review (Client)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Review design files</p>
                            </div>

                            <div class="mt-4">

                                <div v-if="designJob.design_job_status_id >= 8" class="sm:col-span-9">

                                    <div class="px-4 sm:px-6 lg:px-8">
                                        <div class="sm:flex sm:items-center">
                                            <div class="sm:flex-auto">
                                                <h1 class="text-base font-semibold leading-6 text-gray-900">Files</h1>
                                                <p class="mt-2 text-sm text-gray-700">A list of all files submitted by the PM.</p>
                                            </div>
                                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                            </div>
                                        </div>
                                        <div class="mt-8 flow-root">
                                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="inline-block min-w-full py-2 align-middle">
                                                    <table class="min-w-full divide-y divide-gray-300">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">ID</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">PM</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Client</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">File</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments Creator</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments PM</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comments Client</th>
                                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                                                <span class="sr-only">Edit</span>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-200 bg-white">

                                                        <tr v-for="file in approved_all_files" :key="file.id">

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


                                                            <td class="whitespace-nowrap py-4 pl-2 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{file.id}}</td>
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

                                                                <SecondaryButton class="m-2 " @click="setViewFileStatusModal">
                                                                    Update
                                                                </SecondaryButton>

                                                                <div class="m-2 ">
                                                                    <a href='/storage/MYXgg3GxQoLBGsXlHsjSEwIvOhpcIf5P8WVtVpx3.zip' target="_blank"
                                                                       class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                                        Download
                                                                    </a>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-6">

                                                <label  class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                                <div class="text-sm">To finalise the design or request changes please update the status</div>
                                                <div class="mt-2">
                                                    <select v-model="statusForm.design_job_status_id"
                                                            class="mt-2 block w-2/3 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option v-for="n in client_all_design_job_statuses" :key="n.id" :value="n.id">{{
                                                                n.name
                                                            }}
                                                        </option>
                                                    </select>
                                                    <!--                                        <InputError class="mt-2" :message="supplierForm.errors.terms_of_payment_id"/>-->
                                                </div>
                                            </div>

                                            <div class="sm:col-span-6">
                                                <label for="status_comment4" class="block text-sm font-medium leading-6 text-gray-900">Comments</label>
                                                <AreaInput
                                                    v-model="statusForm.comments"
                                                    aria-required="true"
                                                    id="status_comment4"
                                                    :rows=6
                                                    placeholder="Required comments..."
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
                                                <InputError class="mt-2" :message="statusForm.errors.comments"/>



                                            </div>

                                            <div class="mt-2 flex items-center justify-end gap-x-6">

                                                <SecondaryButton @click="updateStatus"  class="m-1">
                                                    Update
                                                </SecondaryButton>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div v-else>No files available to view</div>

                            </div>
                        </div>

                    </div>


                </div>

                <div class="m-4 p-4">
                    <div class="flow-root">

                        <ul role="list" class="-mb-8">
                            <li v-for="(event, eventIdx) in all_events" :key="event.id">
                                <div class="relative pb-8">
                                    <span v-if="eventIdx !== all_events.length - 1" class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
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
    </AppLayout>
</template>
