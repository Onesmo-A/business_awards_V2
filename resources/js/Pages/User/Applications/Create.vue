<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Stepper from '@/Components/Stepper.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import FileInput from '@/Components/FileInput.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

const props = defineProps({
    selectedCategory: {
        type: Object,
        required: true,
    },
    nomination_fee: {
        type: Number,
        required: true,
    },
    // BORESHO: Ongeza prop ya 'is_free'
    is_free: {
        type: Boolean,
        default: false,
    },
    errors: Object,
});

const steps = [
    { name: 'Select Category', status: 'complete' },
    { name: 'Fill Form', status: 'current' },
    { name: 'Payment & Confirmation', status: 'upcoming' },
];

const confirmingSubmission = ref(false);

const form = useForm({
    category_id: props.selectedCategory.id,
    applicant_name: '',
    business_name: '',
    age: '',
    nationality: '',
    country_of_residence: '',
    city: '',
    applicant_phone: '',
    applicant_email: '',
    facebook_url: '',
    instagram_url: '',
    tiktok_url: '',
    bio: '',
    photo: null,
});

const photoPreview = ref(null);

function updatePhotoPreview(file) {
    if (!file) {
        photoPreview.value = null;
        return;
    }
    const reader = new FileReader();
    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
}

const confirmSubmission = () => {
    // BORESHO: Kama ni bure, tuma moja kwa moja. Kama sio, onyesha modal.
    if (props.is_free) {
        submit();
    } else {
        confirmingSubmission.value = true;
    }
};


const submit = () => {
    form.post(route('user.applications.store'), {
        preserveScroll: true,
        onSuccess: () => confirmingSubmission.value = false,
        onError: () => confirmingSubmission.value = false,
    });
};
</script>

<template>
    <Head :title="`Fill Form - ${selectedCategory.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="text-white text-xl font-semibold leading-tight">Start Award Application</h3>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <Stepper :steps="steps" class="mb-8" />

                <div class="bg-[#121212] border border-[#333] overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="confirmSubmission" class="p-6 space-y-6">
                        <h3 class="text-lg font-medium leading-6 text-[var(--accent-primary)]">2. Fill Application Form</h3>
                        <p class="mt-1 text-sm text-gray-400">
                            You are applying for the award:
                            <span class="font-semibold text-white">{{ selectedCategory.name }}</span>
                        </p>

                        <!-- Personal / Business Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="applicant_name" value="Full Name" class="text-gray-300" />
                                <TextInput
                                    id="applicant_name"
                                    v-model="form.applicant_name"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.applicant_name" />
                            </div>

                            <div>
                                <InputLabel for="business_name" value="Business / Stage Name (If any)" class="text-gray-300" />
                                <TextInput
                                    id="business_name"
                                    v-model="form.business_name"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                />
                                <InputError class="mt-2" :message="form.errors.business_name" />
                            </div>

                            <div>
                                <InputLabel for="age" value="Age" class="text-gray-300" />
                                <TextInput
                                    id="age"
                                    v-model="form.age"
                                    type="number"
                                    min="18"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.age" />
                            </div>

                            <div>
                                <InputLabel for="nationality" value="Nationality" class="text-gray-300" />
                                <TextInput
                                    id="nationality"
                                    v-model="form.nationality"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.nationality" />
                            </div>

                            <div>
                                <InputLabel for="country_of_residence" value="Country of Residence" class="text-gray-300" />
                                <TextInput
                                    id="country_of_residence"
                                    v-model="form.country_of_residence"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.country_of_residence" />
                            </div>

                            <div>
                                <InputLabel for="city" value="City" class="text-gray-300" />
                                <TextInput
                                    id="city"
                                    v-model="form.city"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.city" />
                            </div>

                            <div>
                                <InputLabel for="applicant_phone" :value="is_free ? 'Phone Number (With Country Code)' : 'Phone Number (For Payment)'" class="text-gray-300" />
                                <TextInput
                                    id="applicant_phone"
                                    v-model="form.applicant_phone"
                                    type="text"
                                    class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                    placeholder="+2557XXXXXXXX"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.applicant_phone" />
                            </div>

                            <div>
                                <InputLabel for="applicant_email" value="Email Address" class="text-gray-300" />
                            <TextInput
                                id="applicant_email"
                                v-model="form.applicant_email"
                                type="email"
                                class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.applicant_email" />
                            </div>
                        </div>

                        <!-- Bio -->
                        <div>
                            <InputLabel for="bio" value="Business Descreption / Biography" class="text-gray-300" />
                            <TextareaInput
                                id="bio"
                                v-model="form.bio"
                                class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]"
                                rows="3"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.bio" />
                        </div>

                        <!-- Picha -->
                        <div>
                            <InputLabel for="photo" value="Photo / Business Logo" class="text-gray-300" />
                            <FileInput
                                id="photo"
                                class="mt-1 block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#333] file:text-[var(--accent-primary)] hover:file:bg-[#444]"
                                v-model="form.photo"
                                @update:modelValue="updatePhotoPreview"
                                accept="image/*"
                            />
                            <div v-if="photoPreview" class="mt-4">
                                <span class="block w-24 h-24 rounded-full overflow-hidden bg-[#1a1a1a] border border-[#333]">
                                    <img :src="photoPreview" class="object-cover w-full h-full" alt="Preview" />
                                </span>
                            </div>
                            <InputError class="mt-2" :message="form.errors.photo" />
                        </div> 

                        <!-- Social Handles -->
                        <div class="col-span-1 md:col-span-2 border-t border-[#333] pt-6">
                             <h4 class="text-base font-medium text-[var(--accent-primary)]">Social Media Handles(Optional)</h4>
                             <p class="text-sm text-gray-400">Provide full links to your profiles.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="facebook_url" value="Facebook URL" class="text-gray-300" />
                                <TextInput id="facebook_url" v-model="form.facebook_url" type="url" class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]" placeholder="https://facebook.com/yourpage" />
                                <InputError class="mt-2" :message="form.errors.facebook_url" />
                            </div>
                             <div>
                                <InputLabel for="instagram_url" value="Instagram URL" class="text-gray-300" />
                                <TextInput id="instagram_url" v-model="form.instagram_url" type="url" class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]" placeholder="https://instagram.com/yourhandle" />
                                <InputError class="mt-2" :message="form.errors.instagram_url" />
                            </div>
                            <div>
                                <InputLabel for="tiktok_url" value="TikTok URL" class="text-gray-300" />
                                <TextInput id="tiktok_url" v-model="form.tiktok_url" type="url" class="mt-1 block w-full bg-[#1a1a1a] border-[#333] text-white focus:border-[var(--accent-primary)] focus:ring-[var(--accent-primary)]" placeholder="https://tiktok.com/@yourhandle" />
                                <InputError class="mt-2" :message="form.errors.tiktok_url" />
                            </div>
                        </div>


                        <!-- Ada na Button -->
                        <!-- BORESHO: Onyesha ada na button ya malipo kama si bure -->
                        <div v-if="!is_free" class="border-t border-[#333] pt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-400">
                                Application Fee:
                                <span class="font-bold text-lg text-[var(--accent-primary)]">
                                    TSh {{ new Intl.NumberFormat().format(nomination_fee) }}/=
                                </span>
                            </div>
                             <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Proceed to Payment
                             </PrimaryButton>
                        </div>
                        <!-- BORESHO: Onyesha button ya kutuma tu kama ni bure -->
                        <div v-else class="border-t border-[#333] pt-6 flex items-center justify-end">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit Application
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="confirmingSubmission" @close="confirmingSubmission = false">
            <template #title>
                Confirm Payment
            </template>

            <template #content>
                <p class="text-gray-300">You will receive a payment request of <span class="font-bold text-white">TSh {{ new Intl.NumberFormat().format(nomination_fee) }}/=</span> on <strong class="text-white">{{ form.applicant_phone }}</strong>.</p>
                <br /><br />
                <p class="text-gray-300">Please ensure your phone is nearby to confirm the transaction.</p>
            </template>

            <template #footer>
                <SecondaryButton @click="confirmingSubmission = false"> Cancel </SecondaryButton>
                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing" 
                    @click="submit"
                >
                    <span v-if="form.processing">Processing...</span>
                    <span v-else>Yes, Pay Now</span>
                </PrimaryButton>
            </template>
        </ConfirmationModal>
    </AuthenticatedLayout>
</template>
