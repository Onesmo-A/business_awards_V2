<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { PlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineProps({
    guests: Array,
});

const deleteGuest = (id) => {
    if (confirm('Are you sure you want to delete this guest?')) {
        router.delete(route('admin.guest-of-honor.destroy', id));
    }
};
</script>

<template>
    <Head title="Guest of Honor" />
    <AdminLayout>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Guest of Honor</h2>
            <Link :href="route('admin.guest-of-honor.create')" class="btn-primary flex items-center gap-2">
                <PlusIcon class="w-5 h-5" /> Add Guest
            </Link>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-gray-700 text-gray-100 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">Image</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <tr v-for="guest in guests" :key="guest.id" class="hover:bg-gray-700/50">
                        <td class="px-6 py-4">
                            <img v-if="guest.image_url" :src="guest.image_url" class="w-12 h-12 rounded-full object-cover border border-gray-600" />
                            <div v-else class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center text-xs">No Img</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-white">{{ guest.name }}</td>
                        <td class="px-6 py-4">{{ guest.title }}</td>
                        <td class="px-6 py-4">
                            <span v-if="guest.is_active" class="px-2 py-1 text-xs font-bold text-green-900 bg-green-200 rounded-full">Active</span>
                            <span v-else class="px-2 py-1 text-xs font-bold text-gray-900 bg-gray-400 rounded-full">Inactive</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <Link :href="route('admin.guest-of-honor.edit', guest.id)" class="text-blue-400 hover:text-blue-300">
                                <PencilIcon class="w-5 h-5 inline" />
                            </Link>
                            <button @click="deleteGuest(guest.id)" class="text-red-400 hover:text-red-300">
                                <TrashIcon class="w-5 h-5 inline" />
                            </button>
                        </td>
                    </tr>
                    <tr v-if="guests.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No guests found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>