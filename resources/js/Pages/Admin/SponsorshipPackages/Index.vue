<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    packages: Object,
});

const deletePackage = (id) => {
    if (confirm('Are you sure you want to delete this package?')) {
        router.delete(route('admin.sponsorship-packages.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Sponsorship Packages" />

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-white">Sponsorship Packages</h1>
                <p class="mt-2 text-sm text-gray-300">Manage the sponsorship packages available for partners.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <Link :href="route('admin.sponsorship-packages.create')" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Add Package
                </Link>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Package Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Price</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Display Order</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Edit</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 bg-gray-900">
                            <tr v-for="pkg in packages.data" :key="pkg.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">{{ pkg.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ new Intl.NumberFormat('sw-TZ', { style: 'currency', currency: 'TZS' }).format(pkg.price) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ pkg.display_order }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                    <span :class="[pkg.is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400', 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium']">{{ pkg.is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <Link :href="route('admin.sponsorship-packages.edit', pkg.id)" class="text-indigo-400 hover:text-indigo-300">Edit</Link>
                                    <button @click="deletePackage(pkg.id)" class="ml-4 text-red-500 hover:text-red-400">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

