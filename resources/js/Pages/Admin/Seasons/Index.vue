<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    seasons: Array,
});

const showModal = ref(false);
const editingSeason = ref(null);

const form = useForm({
    year: new Date().getFullYear() + 1,
    theme: '',
    description: '',
    event_date: '',
    cover_image: null, // Ongeza field ya picha
    can_show_winners: false,
});

const openCreateModal = () => {
    editingSeason.value = null;
    form.reset();
    form.year = new Date().getFullYear() + 1;
    showModal.value = true;
};

const openEditModal = (season) => {
    editingSeason.value = season;
    form.year = season.year;
    form.theme = season.theme;
    form.description = season.description;
    form.event_date = season.event_date;
    form.cover_image = null; // Reset picha wakati wa kuedit
    form.can_show_winners = Boolean(season.can_show_winners);
    showModal.value = true;
};

const submit = () => {
    if (editingSeason.value) {
        // Tumia POST na _method: 'put' ili kuruhusu upload ya faili wakati wa update
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(route('admin.seasons.update', editingSeason.value.id), {
            onSuccess: () => showModal.value = false,
        });
    } else {
        form.post(route('admin.seasons.store'), {
            onSuccess: () => showModal.value = false,
        });
    }
};

const deleteSeason = (id) => {
    if (confirm('Are you sure you want to delete this season?')) {
        router.delete(route('admin.seasons.destroy', id));
    }
};

const onFileChange = (event) => {
    form.cover_image = event.target.files[0];
};
</script>

<template>
    <AdminLayout title="Manage Seasons">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Award Seasons
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-end mb-4">
                        <PrimaryButton @click="openCreateModal">
                            Add New Season
                        </PrimaryButton>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Theme</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Show Winners</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="season in seasons" :key="season.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img 
                                        v-if="season.cover_image_url" 
                                        :src="season.cover_image_url" 
                                        class="h-10 w-16 object-cover rounded" 
                                        alt="Cover" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ season.year }}</td>
                                <td class="px-6 py-4">{{ season.theme || '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="season.can_show_winners ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ season.can_show_winners ? 'Visible' : 'Hidden' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ season.event_date || '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="openEditModal(season)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                    <button @click="deleteSeason(season.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            <tr v-if="seasons.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No seasons found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <Modal :show="showModal" @close="showModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    {{ editingSeason ? 'Edit Season' : 'Create Season' }}
                </h2>
                
                <div class="mt-4">
                    <InputLabel for="year" value="Year" />
                    <TextInput id="year" v-model="form.year" type="number" class="mt-1 block w-full" required />
                </div>

                <div class="mt-4">
                    <InputLabel for="theme" value="Theme (Optional)" />
                    <TextInput id="theme" v-model="form.theme" type="text" class="mt-1 block w-full" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Description (Optional)" />
                    <textarea id="description" v-model="form.description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                </div>

                <div class="mt-4">
                    <InputLabel for="event_date" value="Event Date (Optional)" />
                    <TextInput id="event_date" v-model="form.event_date" type="date" class="mt-1 block w-full" />
                </div>

                <div class="mt-4">
                    <InputLabel for="cover_image" value="Cover Image" />
                    <input type="file" @change="onFileChange" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    <p v-if="form.errors.cover_image" class="text-red-500 text-xs mt-1">{{ form.errors.cover_image }}</p>
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.can_show_winners" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Show Winners Publicly</span>
                    </label>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="showModal = false"> Cancel </SecondaryButton>
                    <PrimaryButton class="ml-3" @click="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>