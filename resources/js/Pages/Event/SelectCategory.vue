<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { ExclamationTriangleIcon, PhoneIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    categoryGroups: Array,
    allowOnlineApplications: {
        type: Boolean,
        default: true
    },
    supportPhone: {
        type: String,
        default: '+255 652 724 557'
    },
});

const showRestrictionModal = ref(false);

const handleCategoryClick = (categoryId) => {
    if (props.allowOnlineApplications) {
        router.get(route('user.applications.create', categoryId));
    } else {
        showRestrictionModal.value = true;
    }
};

const closeModal = () => {
    showRestrictionModal.value = false;
};
</script>

<template>
    <Head title="Chagua Kategoria" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-[var(--text-primary)] leading-tight">
                Anza Maombi Mapya
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#121212] border border-[#333] overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-8 text-center">
                        <h3 class="text-2xl font-bold text-[var(--accent-primary)] mb-2">Chagua Kategoria ya Kushiriki</h3>
                        <p class="text-gray-400">Tafadhali chagua kategoria inayokufaa ili kuendelea na fomu ya maombi.</p>
                    </div>

                    <div v-for="group in categoryGroups" :key="group.id" class="mb-10 last:mb-0">
                        <h4 class="text-xl font-semibold text-white border-b border-[#333] pb-2 mb-6 flex items-center">
                            <span class="text-[var(--accent-primary)] mr-2">|</span> {{ group.name }}
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div 
                                v-for="category in group.children" 
                                :key="category.id"
                                @click="handleCategoryClick(category.id)"
                                class="group relative bg-[#1a1a1a] border border-[#333] rounded-xl p-6 hover:border-[var(--accent-primary)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_5px_15px_rgba(212,175,55,0.1)] cursor-pointer"
                            >
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-[#0a0a0a] rounded-lg border border-[#333] group-hover:border-[var(--accent-primary)] transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-[var(--accent-primary)] bg-[rgba(212,175,55,0.1)] px-2 py-1 rounded-full">
                                        TZS {{ Number(category.nomination_fee).toLocaleString() }}
                                    </span>
                                </div>
                                <h5 class="text-lg font-bold text-white mb-2 group-hover:text-[var(--accent-primary)] transition-colors">{{ category.name }}</h5>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ category.description || 'Bonyeza hapa kujaza fomu ya maombi kwa kategoria hii.' }}</p>
                                <div class="flex items-center text-sm text-[var(--accent-primary)] font-medium">
                                    Jaza Fomu <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restriction Modal -->
        <TransitionRoot as="template" :show="showRestrictionModal">
            <Dialog as="div" class="relative z-50" @close="closeModal">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-[#1a1a1a] border border-[#333] px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                        <ExclamationTriangleIcon class="h-6 w-6 text-red-500" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-white">
                                            Maombi Yamefungwa
                                        </DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-400">
                                                Online Haijaruhusiwa kwa sasa.
                                            </p>
                                            <div class="mt-4 bg-[#0a0a0a] border border-[#333] p-3 rounded-md flex items-center justify-center sm:justify-start gap-2 text-gray-300 font-medium">
                                                <PhoneIcon class="h-5 w-5 text-gray-500" />
                                                <span>Piga simu no hii: <a :href="'tel:' + supportPhone" class="text-[var(--accent-primary)] hover:underline">{{ supportPhone }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" @click="closeModal">
                                        Sawa, Nimeelewa
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </AdminLayout>
</template>