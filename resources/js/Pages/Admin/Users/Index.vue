<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'; // Improvement: add pagination

defineProps({
    users: Object,
});
</script>

<template>
    <AdminLayout title="Manage Users">
        <Head title="Users" />
        <h1 class="text-2xl font-bold text-white mb-3">Users List</h1>
        <p class="text-xs text-gray-400 mb-4 sm:hidden">Swipe left/right to view all columns.</p>

        <div class="bg-gray-800/50 border border-gold-500/10 shadow-lg rounded-lg overflow-hidden">
            <div class="-mx-4 px-4 sm:mx-0 sm:px-0 overflow-x-auto overscroll-x-contain">
            <table class="min-w-[760px] w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone Number</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <tr v-for="user in users.data" :key="user.id">
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-white text-sm">{{ user.name }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-400 text-sm">{{ user.email }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-400 text-sm">{{ user.phone_number || '-' }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-400 text-sm">{{ user.created_at }}</td>
                    </tr>
                     <tr v-if="users.data.length === 0">
                        <td colspan="4" class="px-4 sm:px-6 py-8 text-center text-gray-500">No users found.</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        <!-- Improvement: add pagination component -->
        <div class="mt-6">
            <Pagination :links="users.links" />
        </div>
    </AdminLayout>
</template>
