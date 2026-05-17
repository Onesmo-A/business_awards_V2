<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Stepper from '@/Components/Stepper.vue';
import { InformationCircleIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { ref, computed } from 'vue';

const props = defineProps({
    categoryGroups: Array,
    allowOnlineApplications: Boolean,
    supportPhone: String,
});

const steps = [
    { name: 'Select Category', status: 'current' },
    { name: 'Fill Form', status: 'upcoming' },
    { name: 'Payment & Confirmation', status: 'upcoming' },
];

const searchQuery = ref('');

const filteredCategoryGroups = computed(() => {
    if (!searchQuery.value) {
        return props.categoryGroups;
    }

    const lowerCaseQuery = searchQuery.value.toLowerCase();

    return props.categoryGroups.map(group => {
        const filteredChildren = group.children.filter(child =>
            child.name.toLowerCase().includes(lowerCaseQuery)
        );

        if (filteredChildren.length > 0) {
            return { ...group, children: filteredChildren };
        }
        return null;
    }).filter(group => group !== null);
});
</script>

<template>
    <Head title="Select Category" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="text-white text-xl font-semibold leading-tight">Start Award Application</h3>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <Stepper :steps="steps" class="mb-8" />

                <div v-if="!allowOnlineApplications" class="bg-yellow-900/50 border border-yellow-600 text-yellow-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <strong class="font-bold">Applications are currently closed!</strong>
                    <span class="block sm:inline"> For support, contact us via {{ supportPhone }}.</span>
                </div>

                <div v-else class="bg-[#121212] border border-[#333] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-100 space-y-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-[var(--accent-primary)]">1. Select the Award Category</h3>
                            <p class="mt-1 text-sm text-gray-400">Choose the award category you wish to contest for from the list below.</p>
                        </div>

                        <!-- Search Input -->
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input v-model="searchQuery" type="text" placeholder="Search category..." class="block w-full rounded-md border-0 bg-[#1a1a1a] py-2.5 pl-10 text-white ring-1 ring-inset ring-[#333] placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-[var(--accent-primary)] sm:text-sm sm:leading-6" />
                        </div>

                        <div v-if="filteredCategoryGroups.length > 0" class="space-y-8">
                            <div v-for="group in filteredCategoryGroups" :key="group.id">
                                <h4 class="text-base font-semibold text-gray-300 border-b border-gray-700 pb-2 mb-4">{{ group.name }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <Link
                                        v-for="child in group.children"
                                        :key="child.id"
                                        :href="route('user.applications.create', child.id)"
                                        class="group block p-4 bg-[#1a1a1a] hover:bg-[#222] border border-[#333] rounded-lg transition-all duration-300"
                                    >
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-md font-semibold text-white group-hover:text-[var(--accent-primary)] transition">{{ child.name }}</h3>
                                            <div class="text-right">
                                                <!-- BORESHO: Onyesha "BURE" au kiasi cha ada -->
                                                <span v-if="child.is_free || child.nomination_fee == 0" class="text-sm font-bold text-green-400">Free</span>
                                                <span v-else class="text-sm font-bold text-[var(--accent-primary)]">
                                                    TSh {{ new Intl.NumberFormat().format(child.nomination_fee) }}
                                                </span>
                                            </div>
                                        </div>
                                        <p v-if="child.description" class="mt-2 text-xs text-gray-400 line-clamp-2">{{ child.description }}</p>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-10 px-4 bg-[#1a1a1a] rounded-lg border border-dashed border-[#333]">
                            <InformationCircleIcon class="mx-auto h-12 w-12 text-gray-500" />
                            <h3 class="mt-2 text-sm font-medium text-white">No Categories Available</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Try different search terms or check back later.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>