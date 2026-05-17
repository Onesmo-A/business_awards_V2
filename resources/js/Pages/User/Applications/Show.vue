<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { CheckCircleIcon, ClockIcon, XCircleIcon } from '@heroicons/vue/24/solid';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import TextareaInput from '@/Components/TextareaInput.vue';

const props = defineProps({
    application: Object,
});

const currentYear = new Date().getFullYear();

const publicVotingUrl = computed(() => {
    const slug = props.application?.category?.slug;
    return slug ? route('categories.show', slug) : null;
});

const showEditModal = ref(false);
const photoPreview = ref(null);
const toast = useToast();

// Fomu ya kuedit
const form = useForm({
    _method: 'PUT',
    applicant_name: props.application.applicant_name,
    business_name: props.application.business_name,
    age: props.application.age,
    nationality: props.application.nationality,
    country_of_residence: props.application.country_of_residence,
    city: props.application.city,
    applicant_phone: props.application.applicant_phone,
    applicant_email: props.application.applicant_email,
    bio: props.application.bio,
    facebook_url: props.application.facebook_url,
    instagram_url: props.application.instagram_url,
    tiktok_url: props.application.tiktok_url,
    photo: null,
});

const updatePhotoPreview = (file) => {
    if (!file) {
        photoPreview.value = null;
        return;
    }
    const reader = new FileReader();
    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

const submitEdit = () => {
    form.post(route('user.applications.update', props.application.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Info Updated Successfully.');
            showEditModal.value = false;
            form.reset('photo');
            photoPreview.value = null;
        },
        onError: () => {
            toast.error('Failed to update application details. Please check the form.');
        },
    });
};

const retryPayment = () => {
    if (confirm('Are you sure you want to retry the payment? You will receive a prompt on your phone.')) {
        router.post(route('user.applications.retry-payment', props.application.id));
    }
};

const formatStatus = (status) => {
    if (!status) return 'N/A';
    return status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};

const statusClass = (status) => {
    const classes = {
        'pending_review': 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
        'pending_payment': 'bg-blue-500/10 text-blue-500 border-blue-500/20',
        'approved': 'bg-green-500/10 text-green-500 border-green-500/20',
        'rejected': 'bg-red-500/10 text-red-500 border-red-500/20',
        'payment_failed': 'bg-red-500/10 text-red-500 border-red-500/20',
    };
    return classes[status] || 'bg-gray-500/10 text-gray-500 border-gray-500/20';
};
</script>

<template>
    <Head title="Application Details" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
                <h2 class="font-semibold text-xl text-[var(--accent-primary)] leading-tight">
                    Application Details
                </h2>
                <Link :href="route('user.applications.index')" class="text-sm text-gray-400 hover:text-white self-start sm:self-auto">
                    &larr; Back to List
                </Link>
            </div>
        </template>

        <div class="py-6 sm:py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Status Banner -->
                <div class="mb-6 p-4 rounded-lg border flex flex-col md:flex-row justify-between md:items-center gap-4" 
                     :class="statusClass(application.status)">
                    <div class="flex items-start sm:items-center gap-3 w-full md:w-auto">
                        <span class="text-2xl">
                            <CheckCircleIcon v-if="application.status === 'approved'" class="h-8 w-8" />
                            <XCircleIcon v-else-if="application.status === 'rejected'" class="h-8 w-8" />
                            <ClockIcon v-else class="h-8 w-8" />
                        </span>
                        <div>
                            <h3 class="font-bold text-lg">Status: {{ formatStatus(application.status) }}</h3>
                            <p v-if="application.status === 'pending_payment'" class="text-sm opacity-80">
                                Waiting for payment confirmation.
                            </p>
                            <p v-if="application.status === 'payment_failed'" class="text-sm opacity-80">
                                Payment failed. Please try again.
                            </p>
                            <p v-if="application.status === 'pending_review'" class="text-sm opacity-80">
                                Congratulations! Your application has been successfully received. Please be patient while our team reviews your submission.
                            </p>
                            <p v-if="application.status === 'approved'" class="text-sm opacity-80">
                                Your application has been approved for the {{ currentYear }} awards season.
                            </p>
                            <p v-if="application.status === 'rejected'" class="text-sm opacity-80">
                                Sorry, this application was not approved.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex w-full md:w-auto flex-col sm:flex-row gap-3">
                        <PrimaryButton 
                            v-if="['pending_payment', 'payment_failed'].includes(application.status)" 
                            @click="retryPayment"
                            class="w-full sm:w-auto justify-center"
                        >
                            Retry Payment
                        </PrimaryButton>
                        
                        <SecondaryButton 
                            v-if="!['approved', 'rejected'].includes(application.status)"
                            @click="showEditModal = true"
                            class="w-full sm:w-auto justify-center"
                        >
                            Edit Details
                        </SecondaryButton>
                    </div>
                </div>

                <div
                    v-if="application.status === 'approved' && publicVotingUrl"
                    class="mb-6 overflow-hidden rounded-2xl border border-emerald-500/20 bg-gradient-to-br from-emerald-500/10 via-emerald-400/5 to-transparent"
                >
                    <div class="p-5 sm:p-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="max-w-2xl">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-300/80">
                                    Approved Nominee
                                </p>
                                <h3 class="mt-2 text-xl font-bold text-white sm:text-2xl">
                                    You are officially in the {{ currentYear }} competition.
                                </h3>
                                <p class="mt-2 text-sm leading-6 text-emerald-50/90 sm:text-base">
                                    Open your public voting page and share your nominee card with supporters. Your card includes a QR code they can use to vote for you quickly.
                                </p>
                            </div>

                            <div class="flex w-full flex-col gap-3 sm:w-auto sm:min-w-[220px]">
                                <a
                                    :href="publicVotingUrl"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-full bg-emerald-400 px-5 py-3 text-sm font-semibold text-black transition hover:bg-emerald-300"
                                >
                                    Open Voting Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="bg-[var(--background-section)] overflow-hidden shadow-sm sm:rounded-lg border border-gray-800">
                    <div class="p-4 sm:p-6 text-gray-100">
                        
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Photo Section -->
                            <div class="flex-shrink-0 self-center md:self-start">
                                <div class="w-32 h-32 md:w-48 md:h-48 rounded-lg overflow-hidden border-2 border-[var(--accent-dark)] bg-black">
                                    <img 
                                        v-if="application.photo_url" 
                                        :src="application.photo_url" 
                                        alt="Applicant" 
                                        class="w-full h-full object-cover"
                                    />
                                    <div v-else class="w-full h-full flex items-center justify-center text-gray-600">
                                        No Photo
                                    </div>
                                </div>
                            </div>

                            <!-- Details Section -->
                            <div class="flex-grow space-y-6">
                                <div>
                                    <h3 class="text-2xl font-bold text-white break-words">{{ application.applicant_name }}</h3>
                                    <p class="text-[var(--accent-primary)] font-medium break-words">{{ application.business_name }}</p>
                                    <p class="text-gray-400 text-sm mt-1 break-words">Category: {{ application.category?.name }}</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div class="p-3 bg-[var(--background-main)] rounded border border-gray-800">
                                        <span class="block text-gray-500 text-xs uppercase">Location</span>
                                        <span class="text-white">{{ application.city }}, {{ application.country_of_residence }}</span>
                                    </div>
                                    <div class="p-3 bg-[var(--background-main)] rounded border border-gray-800">
                                        <span class="block text-gray-500 text-xs uppercase">Nationality / Age</span>
                                        <span class="text-white">{{ application.nationality }} ({{ application.age }} Years)</span>
                                    </div>
                                    <div class="p-3 bg-[var(--background-main)] rounded border border-gray-800">
                                        <span class="block text-gray-500 text-xs uppercase">Phone</span>
                                        <span class="text-white break-all">{{ application.applicant_phone }}</span>
                                    </div>
                                    <div class="p-3 bg-[var(--background-main)] rounded border border-gray-800">
                                        <span class="block text-gray-500 text-xs uppercase">Email</span>
                                        <span class="text-white break-all">{{ application.applicant_email }}</span>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-[var(--accent-primary)] font-semibold mb-2 border-b border-gray-800 pb-1">Biography</h4>
                                    <p class="text-gray-300 whitespace-pre-line leading-relaxed break-words">{{ application.bio }}</p>
                                </div>

                                <div v-if="application.facebook_url || application.instagram_url || application.tiktok_url">
                                    <h4 class="text-[var(--accent-primary)] font-semibold mb-2 border-b border-gray-800 pb-1">Social Media</h4>
                                    <div class="flex flex-wrap gap-4">
                                        <a v-if="application.facebook_url" :href="application.facebook_url" target="_blank" class="text-blue-500 hover:text-blue-400 break-all">Facebook</a>
                                        <a v-if="application.instagram_url" :href="application.instagram_url" target="_blank" class="text-pink-500 hover:text-pink-400 break-all">Instagram</a>
                                        <a v-if="application.tiktok_url" :href="application.tiktok_url" target="_blank" class="text-purple-500 hover:text-purple-400 break-all">TikTok</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false">
            <div class="p-6 bg-[var(--background-section)] text-white">
                <h2 class="text-lg font-medium text-[var(--accent-primary)] mb-4">Edit Application Details</h2>
                
                <form @submit.prevent="submitEdit" class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                    <!-- Name & Business -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="edit_name" value="Full Name" />
                            <TextInput id="edit_name" v-model="form.applicant_name" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.applicant_name" />
                        </div>
                        <div>
                            <InputLabel for="edit_business" value="Business Name" />
                            <TextInput id="edit_business" v-model="form.business_name" class="w-full bg-[#1a1a1a] text-white border-gray-700" />
                            <InputError :message="form.errors.business_name" />
                        </div>
                    </div>

                    <!-- Age & Nationality -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="edit_age" value="Age" />
                            <TextInput id="edit_age" type="number" v-model="form.age" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.age" />
                        </div>
                        <div>
                            <InputLabel for="edit_nationality" value="Nationality" />
                            <TextInput id="edit_nationality" v-model="form.nationality" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.nationality" />
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="edit_country" value="Country" />
                            <TextInput id="edit_country" v-model="form.country_of_residence" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.country_of_residence" />
                        </div>
                        <div>
                            <InputLabel for="edit_city" value="City" />
                            <TextInput id="edit_city" v-model="form.city" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.city" />
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="edit_phone" value="Phone" />
                            <TextInput id="edit_phone" v-model="form.applicant_phone" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.applicant_phone" />
                        </div>
                        <div>
                            <InputLabel for="edit_email" value="Email" />
                            <TextInput id="edit_email" type="email" v-model="form.applicant_email" class="w-full bg-[#1a1a1a] text-white border-gray-700" required />
                            <InputError :message="form.errors.applicant_email" />
                        </div>
                    </div>

                    <!-- Bio -->
                    <div>
                        <InputLabel for="edit_bio" value="Bio" />
                        <TextareaInput id="edit_bio" v-model="form.bio" class="w-full bg-[#1a1a1a] text-white border-gray-700" rows="4" required />
                        <InputError :message="form.errors.bio" />
                    </div>

                    <!-- Photo -->
                    <div>
                        <InputLabel for="edit_photo" value="Update Photo (Optional)" />
                        <input 
                            type="file" 
                            @change="e => { form.photo = e.target.files[0]; updatePhotoPreview(e.target.files[0]); }"
                            class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-[var(--accent-primary)] file:text-black hover:file:bg-[var(--accent-secondary)]"
                        />
                        <div v-if="photoPreview" class="mt-2">
                            <img :src="photoPreview" class="h-20 w-20 object-cover rounded border border-gray-600" />
                        </div>
                        <InputError :message="form.errors.photo" />
                    </div>

                    <!-- Socials -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <TextInput v-model="form.facebook_url" placeholder="Facebook URL" class="w-full bg-[#1a1a1a] text-white border-gray-700" />
                        <TextInput v-model="form.instagram_url" placeholder="Instagram URL" class="w-full bg-[#1a1a1a] text-white border-gray-700" />
                        <TextInput v-model="form.tiktok_url" placeholder="TikTok URL" class="w-full bg-[#1a1a1a] text-white border-gray-700" />
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6">
                        <SecondaryButton @click="showEditModal = false" class="w-full sm:w-auto justify-center">Cancel</SecondaryButton>
                        <PrimaryButton :disabled="form.processing" class="w-full sm:w-auto justify-center">Save Changes</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>
