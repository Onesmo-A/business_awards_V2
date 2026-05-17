<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    mapSection: Object,
});

const form = useForm({
    _method: props.mapSection ? 'PUT' : 'POST',
    title: props.mapSection?.title || 'Join Us at the Gala',
    description: props.mapSection?.description || '',
    event_date: props.mapSection?.event_date || '',
    event_time: props.mapSection?.event_time || '',
    location_name: props.mapSection?.location_name || '',
    google_maps_embed_url: props.mapSection?.google_maps_embed_url || '',
    dress_code: props.mapSection?.dress_code || '',
    is_active: props.mapSection?.is_active ?? true,
});

const submit = () => {
    const url = props.mapSection
        ? route('admin.map-sections.update', props.mapSection.id)
        : route('admin.map-sections.store');

    form.post(url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="mapSection ? 'Edit Location' : 'Create Location'" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-6">{{ mapSection ? 'Edit Event Location' : 'Add Event Location' }}</h1>
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="dress_code" value="Dress Code (e.g. Formal / Black Tie)" />
                                <TextInput id="dress_code" type="text" class="mt-1 block w-full" v-model="form.dress_code" placeholder="Formal / Black Tie" />
                                <InputError class="mt-2" :message="form.errors.dress_code" />
                            </div>
                            <div>
                                <InputLabel for="title" value="Section Title" />
                                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" v-model="form.description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="event_date" value="Event Date (e.g. Nov 3, 2025)" />
                                    <TextInput id="event_date" type="text" class="mt-1 block w-full" v-model="form.event_date" />
                                    <InputError class="mt-2" :message="form.errors.event_date" />
                                </div>
                                <div>
                                    <InputLabel for="event_time" value="Event Time (e.g. 6 PM - 11 PM)" />
                                    <TextInput id="event_time" type="text" class="mt-1 block w-full" v-model="form.event_time" />
                                    <InputError class="mt-2" :message="form.errors.event_time" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="location_name" value="Location Name (e.g. The Super Dome)" />
                                <TextInput id="location_name" type="text" class="mt-1 block w-full" v-model="form.location_name" />
                                <InputError class="mt-2" :message="form.errors.location_name" />
                            </div>

                            <div>
                                <InputLabel for="google_maps_embed_url" value="Google Maps Embed URL (src only)" />
                                <TextInput id="google_maps_embed_url" type="text" class="mt-1 block w-full" v-model="form.google_maps_embed_url" placeholder="https://www.google.com/maps/embed?..." />
                                <p class="text-xs text-gray-500 mt-1">Paste the URL from the 'src' attribute of the Google Maps embed code.</p>
                                <InputError class="mt-2" :message="form.errors.google_maps_embed_url" />
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-600">Active (Visible on homepage)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <Link :href="route('admin.map-sections.index')" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </Link>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ mapSection ? 'Update' : 'Create' }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>