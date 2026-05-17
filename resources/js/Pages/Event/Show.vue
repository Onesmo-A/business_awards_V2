<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    application: Object,
});

const retryForm = useForm({});

const retryPayment = () => {
    retryForm.post(route('user.applications.retry-payment', props.application.id));
};

const getStatusColor = (status) => {
    switch (status) {
        case 'approved': return 'text-green-400 bg-green-400/10 border-green-400/20';
        case 'rejected': return 'text-red-400 bg-red-400/10 border-red-400/20';
        case 'pending_payment': return 'text-yellow-400 bg-yellow-400/10 border-yellow-400/20';
        case 'payment_failed': return 'text-red-400 bg-red-400/10 border-red-400/20';
        default: return 'text-blue-400 bg-blue-400/10 border-blue-400/20';
    }
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'approved': return 'Imethibitishwa';
        case 'rejected': return 'Imekataliwa';
        case 'pending_payment': return 'Inasubiri Malipo';
        case 'payment_failed': return 'Malipo Yamefeli';
        case 'pending_review': return 'Inasubiri Mapitio';
        default: return status;
    }
};
</script>

<template>
    <Head title="Taarifa za Ombi" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
                Taarifa za Ombi #{{ application.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Status Banner -->
                <div v-if="application.status === 'pending_payment' || application.status === 'payment_failed'" class="mb-6 bg-yellow-900/20 border border-yellow-600/30 rounded-lg p-4 flex items-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-yellow-500">Malipo Yanahitajika</h3>
                        <p class="text-yellow-200/70 mt-1">Ombi lako limepokelewa lakini malipo bado hayajakamilika. Tafadhali kamilisha malipo ili ombi lako lifanyiwe kazi.</p>
                        <div class="mt-4">
                            <button 
                                @click="retryPayment" 
                                :disabled="retryForm.processing"
                                class="btn-primary px-4 py-2 text-sm rounded shadow-lg"
                            >
                                {{ retryForm.processing ? 'Inatuma...' : 'Jaribu Kulipa Tena' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-[#121212] border border-[#333] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="border-b border-[#333] px-6 py-4 flex justify-between items-center bg-[#1a1a1a]">
                        <h3 class="text-lg font-medium text-white">Maelezo ya Maombi</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-bold border uppercase tracking-wider" :class="getStatusColor(application.status)">
                            {{ getStatusLabel(application.status) }}
                        </span>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Kategoria</h4>
                            <p class="text-lg text-white font-semibold">{{ application.category ? application.category.name : 'Haijulikani' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Tarehe ya Kutuma</h4>
                            <p class="text-lg text-white">{{ new Date(application.created_at).toLocaleString() }}</p>
                        </div>

                        <div class="md:col-span-2 border-t border-[#333] pt-6">
                            <h4 class="text-sm font-medium text-[var(--accent-primary)] uppercase tracking-wider mb-4">Taarifa za Mwombaji</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Jina Kamili</p>
                                    <p class="text-white">{{ application.applicant_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Namba ya Simu</p>
                                    <p class="text-white">{{ application.applicant_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Barua Pepe</p>
                                    <p class="text-white">{{ application.applicant_email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 border-t border-[#333] pt-6">
                            <h4 class="text-sm font-medium text-[var(--accent-primary)] uppercase tracking-wider mb-2">Wasifu (Bio)</h4>
                            <div class="bg-[#1a1a1a] p-4 rounded-lg border border-[#333]">
                                <p class="text-gray-300 whitespace-pre-wrap">{{ application.bio }}</p>
                            </div>
                        </div>

                        <div v-if="application.photo_path" class="md:col-span-2 border-t border-[#333] pt-6">
                            <h4 class="text-sm font-medium text-[var(--accent-primary)] uppercase tracking-wider mb-4">Picha Iliyoambatanishwa</h4>
                            <img :src="application.photo_url" alt="Nominee Photo" class="w-48 h-48 object-cover rounded-lg border border-[#333]" />
                        </div>
                    </div>
                    
                    <div class="bg-[#1a1a1a] px-6 py-4 border-t border-[#333] flex justify-between items-center">
                        <Link :href="route('user.applications.index')" class="text-gray-400 hover:text-white text-sm font-medium">
                            &larr; Rudi kwenye Orodha
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>