<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

const props = defineProps({
    sponsors: Object,
    filters: Object,
});

const showConfirmModal = ref(false);
const sponsorToDelete = ref(null);

const form = useForm({});

const openConfirmModal = (sponsor) => {
    sponsorToDelete.value = sponsor;
    showConfirmModal.value = true;
};

const closeModal = () => {
    showConfirmModal.value = false;
    sponsorToDelete.value = null;
};

const deleteSponsor = () => {
    form.delete(route('admin.sponsors.destroy', sponsorToDelete.value.id), {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Manage Sponsors" />

    <AdminLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Sponsors</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the sponsors in the system.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('admin.sponsors.create')" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Add Sponsor
                    </Link>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Logo</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tier</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="sponsor in sponsors.data" :key="sponsor.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <img :src="sponsor.logo_url" :alt="sponsor.name" class="h-10 w-auto object-contain">
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ sponsor.name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 capitalize">{{ sponsor.tier }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span :class="[sponsor.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium']">
                                                {{ sponsor.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link :href="route('admin.sponsors.edit', sponsor.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                            <button @click="openConfirmModal(sponsor)" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    <tr v-if="sponsors.data.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No sponsors found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="sponsors.links" class="mt-6" />
                    </div>
                </div>
            </div>
        </div>

        <ConfirmationModal :show="showConfirmModal" @close="closeModal">
            <template #title>
                Delete Sponsor
            </template>
            <template #content>
                Are you sure you want to delete the sponsor "{{ sponsorToDelete?.name }}"? This action cannot be undone.
            </template>
            <template #footer>
                <button @click="deleteSponsor" :disabled="form.processing" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" :class="{ 'opacity-25': form.processing }">
                    Delete
                </button>
                <button @click="closeModal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Cancel
                </button>
            </template>
        </ConfirmationModal>
    </AdminLayout>
</template>