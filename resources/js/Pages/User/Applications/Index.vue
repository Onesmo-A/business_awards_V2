<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { EyeIcon } from '@heroicons/vue/24/solid';

defineProps({
    applications: Object,
});

const formatDate = (date) => {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
};

const formatAmount = (amount) => {
    if (amount == null) return '0';
    return new Intl.NumberFormat().format(amount);
};

const formatStatus = (status) => {
    if (!status) return 'N/A';
    return status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};

const statusClass = (status) => {
    const classes = {
        'pending_review': 'bg-yellow-900/50 text-yellow-300 ring-yellow-700',
        'pending_payment': 'bg-blue-900/50 text-blue-300 ring-blue-700',
        'approved': 'bg-green-900/50 text-green-300 ring-green-700',
        'completed': 'bg-green-900/50 text-green-300 ring-green-700',
        'rejected': 'bg-red-900/50 text-red-300 ring-red-700',
        'payment_failed': 'bg-red-900/50 text-red-300 ring-red-700',
        'failed': 'bg-red-900/50 text-red-300 ring-red-700',
        'pending': 'bg-blue-900/50 text-blue-300 ring-blue-700',
    };
    return classes[status] || 'bg-gray-700/50 text-gray-300 ring-gray-600';
};
</script>

<template>
    <Head title="Application Status" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-white">Your Application Status</h1>
                        <p class="mt-2 text-sm text-gray-400">A list of all the applications you have submitted.</p>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="space-y-4 sm:hidden">
                        <div
                            v-if="applications.data.length === 0"
                            class="rounded-lg border border-gray-700 bg-[#121212] px-4 py-6 text-center text-sm text-gray-500"
                        >
                            You have not submitted any applications yet.
                            <Link :href="route('user.applications.selectCategory')" class="text-[var(--accent-primary)] hover:underline font-semibold">
                                Start a new application.
                            </Link>
                        </div>

                        <div
                            v-for="application in applications.data"
                            :key="`mobile-${application.id}`"
                            class="rounded-lg border border-gray-700 bg-[#121212] p-4 space-y-3"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-white break-words">{{ application.applicant_name }}</p>
                                    <p class="text-xs text-gray-400 break-words">{{ application.category?.name || 'Unknown' }}</p>
                                </div>
                                <Link :href="route('user.applications.show', application.id)" class="text-[var(--accent-primary)] hover:text-[var(--accent-primary-dark)]">
                                    <EyeIcon class="h-5 w-5" />
                                </Link>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span :class="statusClass(application.status)" class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                    {{ formatStatus(application.status) }}
                                </span>
                                <span v-if="application.transaction" :class="statusClass(application.transaction.status)" class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                    {{ formatStatus(application.transaction.status) }}
                                </span>
                                <span v-else class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset bg-green-900/50 text-green-300 ring-green-700">
                                    Free Application
                                </span>
                            </div>

                            <div class="text-xs text-gray-400 space-y-1">
                                <p v-if="application.transaction">
                                    Amount: <span class="font-semibold text-white">TSh {{ formatAmount(application.transaction.amount) }}</span>
                                </p>
                                <p>
                                    Date: <span class="text-gray-300">{{ formatDate(application.created_at) }}</span>
                                </p>
                            </div>
                        </div>

                        <Pagination :links="applications.links" class="pt-2" />
                    </div>

                    <div class="hidden sm:block -mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-[860px] w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Applicant</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Award</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Application Status</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Payment</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Date</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">View</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800 bg-[#121212]">
                                        <tr v-if="applications.data.length === 0">
                                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                                You have not submitted any applications yet.
                                                <Link :href="route('user.applications.selectCategory')" class="text-[var(--accent-primary)] hover:underline font-semibold">
                                                    Start a new application.
                                                </Link>
                                            </td>
                                        </tr>
                                        <tr v-for="application in applications.data" :key="application.id">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">{{ application.applicant_name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ application.category?.name || 'Unknown' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">
                                                <span :class="statusClass(application.status)" class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                                    {{ formatStatus(application.status) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">
                                                <!-- IMPROVEMENT: Show if it's free or the payment amount -->
                                                <div v-if="application.transaction">
                                                    <p class="font-semibold text-white">TSh {{ formatAmount(application.transaction.amount) }}</p>
                                                    <span :class="statusClass(application.transaction.status)" class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                                        {{ formatStatus(application.transaction.status) }}
                                                    </span>
                                                </div>
                                                <span v-else class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset bg-green-900/50 text-green-300 ring-green-700">
                                                    Free Application
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatDate(application.created_at) }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <Link :href="route('user.applications.show', application.id)" class="text-[var(--accent-primary)] hover:text-[var(--accent-primary-dark)]">
                                                    <EyeIcon class="h-5 w-5" />
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                             <Pagination :links="applications.links" class="mt-6" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
